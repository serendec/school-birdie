<?php

namespace App\Actions\Fortify;

use App\Models\LessonPlan;
use App\Models\School;
use App\Models\StudentProfile;
use App\Models\StudentTeacherRelation;
use App\Models\Teacher;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Symfony\Component\HttpFoundation\Response;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $ip = request()->ip();
        $key = 'register_rate_limit:'.$ip;
        $maxAttempts = 10; // 1分間に許可される最大試行回数
        $decaySeconds = 60; // リミットがリセットされるまでの時間（秒）
    
        // レートリミットを超えているか確認
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            throw ValidationException::withMessages([
                'email' => [__('エラーが発生しました。しばらくしてから再度お試しください。時間を置いても解決しない場合は、管理者にお問い合わせください。')],
            ])->status(Response::HTTP_TOO_MANY_REQUESTS);
        }
    
        // レートリミッターをヒットさせ、試行回数を記録
        RateLimiter::hit($key, $decaySeconds);

        // get school id from token & create token
        if (isset($input['token'])){
            $register_student_token = null;
            $input['school_id'] = School::getSchoolIdFromToken($input['token']);
            if ($input['school_id'] != null){
                $register_student_token = Str::random(32);
                $input['role'] = 'teacher';
            } else {
                $teacher = Teacher::getTeacherInfoFromToken($input['token']);
                $input['school_id'] = ($teacher) ? $teacher->school_id : null;
                $input['role'] = 'student';
            }
        }
        
        Validator::make($input, [
            'family_name'      => ['required', 'string', 'max:255'],
            'first_name'       => ['required', 'string', 'max:255'],
            'family_name_kana' => ['required', 'string', 'max:255'],
            'first_name_kana'  => ['required', 'string', 'max:255'],
            'icon'             => ['image', 'mimes:png,jpg,jpeg', 'max:2048', 'nullable'],
            'tel'              => ['required', 'string', 'max:13'],
            'email'            => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'line_id'              => ['string', 'max:255', 'nullable'],
            'password'             => $this->passwordRules(),
            'role'                 => ['required', 'in:admin,teacher,student'],
            'token'                => ['required'],
            'school_id'            => ['required', 'integer'],
            'g-recaptcha-response' => ['required', 'recaptcha']
        ])->validate();

        // bot対策
        $botDetected = false;

        // honeypot
        if (isset($input['fax']) && $input['fax'] != ''){
            $botDetected = true;
        }

        // 時間ベースのチェック
        if (!isset($input['form_loaded_at'])){
            $botDetected = true;
        } else {
            $minTimeInSeconds = 5;
            $formLoadedAt = $input['form_loaded_at'];
            $timePassed = time() - $formLoadedAt;
            if ($timePassed < $minTimeInSeconds) {
                $botDetected = true;
            }
        }

        // JavaScriptが有効かどうかのチェック
        if (!isset($input['js_challenge_result']) || $input['js_challenge_result'] != '7'){
            $botDetected = true;
        }

        if ($botDetected){
            throw ValidationException::withMessages([
                'fax' => '送信に失敗しました。管理者にお問い合わせください。',
            ]);
        }

        DB::beginTransaction();
        try {
            // User登録
            $user = User::create([
                'family_name'            => $input['family_name'],
                'first_name'             => $input['first_name'],
                'family_name_kana'       => $input['family_name_kana'],
                'first_name_kana'        => $input['first_name_kana'],
                'tel'                    => $input['tel'],
                'email'                  => $input['email'],
                'line_id'                => $input['line_id'],
                'role'                   => $input['role'],
                'school_id'              => $input['school_id'],
                'password'               => Hash::make($input['password']),
                'register_student_token' => $register_student_token
            ]);

            // 生徒の場合は担当講師の設定 & student_profiles tableに登録
            if ($input['role'] == 'student'){
                $studentTeacherRelations = new StudentTeacherRelation();
                $studentTeacherRelations->registerMainTeacher($teacher->id, $user->id);

                $studentProfile = new StudentProfile();
                $studentProfile->user_id = $user->id;
                if (isset($input['lesson_plan_id'])){
                    $studentProfile->lesson_plan_id = $input['lesson_plan_id'];
                }
                $studentProfile->save();

                // 決済がある場合
                if (isset($input['payment_token'])){
                    // 決済金額の取得
                    $lessonPlan = LessonPlan::getLessonPlan($input['lesson_plan_id'], $input['school_id']);
                    
                    // 決済処理
                    $paymentService = new PaymentService($input['school_id']);
                    $paymentResult = $paymentService->createSubscription(
                        $user,
                        $lessonPlan->stripe_plan_id,
                        $input['payment_token']
                    );
                    
                    // 決済が正常にできたか確認
                    if ($paymentResult->status != 'active' && $paymentResult->status != 'trialing'){
                        throw new \Exception('決済に失敗しました。');
                    }
                }
            }

            // upload image
            $icon = null;
            if (isset($input['icon'])){
                $icon = $input['icon']->store('icons/' . $input['school_id'], 'public');
                $icon = basename($icon);
            }
            $user->icon = $icon;
            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'cardnumber' => $e->getMessage(),
            ]);
        }

        return $user;
    }
}
