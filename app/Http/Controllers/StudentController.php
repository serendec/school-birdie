<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\StudentTeacherRelation;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stripe\Invoice;
use Stripe\Stripe;
use Stripe\Subscription;

class StudentController extends Controller
{
    public function index()
    {
        // メイン講師情報を含んだ生徒リスト取得
        $student = new Student();
        $students = $student->getPaginatedListWithMainTeacher(Auth::user()->school_id);

        // 講師リスト取得
        $teachers = Teacher::getTeachers(Auth::user()->school_id);

        return view('student.index', compact('students', 'teachers'));
    }

    public function search(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'name'            => ['nullable', 'string'],
            'tel'             => ['nullable', 'string'],
            'email'           => ['nullable', 'string'],
            'main_teacher_id' => ['nullable', 'integer', 'min:1'],
            'sub_teacher_id'  => ['nullable', 'integer', 'min:1'],
            'inactive'        => ['nullable', 'in:1'],
        ])->validate();

        // メイン講師情報を含んだ生徒リスト検索
        $student = new Student();
        $students = $student->searchPaginatedListWithMainTeacher(Auth::user()->school_id, $request);

        // 講師リスト取得
        $teachers = Teacher::getTeachers(Auth::user()->school_id);

        // 絞り込み条件数を取得
        $filteredCount = 0;
        foreach ($request->all() as $key => $value) {
            if ($key != 'page' && $value !== null && $value !== '') {
                $filteredCount++;
            }
        }

        return view('student.index', compact('students', 'teachers', 'filteredCount'));
    }

    public function show(Request $request)
    {
        $student = Student::getStudentInfoFromId($request->id, Auth::user()->school_id);
        if (empty($student)){
            return redirect()->route('student.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }

        // 決済情報取得
        $latestInvoice = null;
        $statusJapanese = null;
        $frequency = null;
        $createdDate = null;
        if ($student->stripe_id){
            // Stripe APIキーの設定
            Stripe::setApiKey(config('services.stripe.'.$student->school_id.'.secret_key'));

            // 最新の請求書を取得
            $invoices = Invoice::all(['customer' => $student->stripe_id, 'limit' => 1]);

            // 最新の請求書情報を取得
            $latestInvoice = $invoices->data[0] ?? null;

            // ステータスの和訳
            $statusJapanese = $latestInvoice ? config('stripe.status.' . $latestInvoice->status, '不明') : null;

            // 頻度の和訳
            $subscription = Subscription::retrieve($latestInvoice->subscription);
            $frequency = config('stripe.frequency.' . $subscription->plan->interval, '不明');

            // 作成日
            $createdDate = $latestInvoice ? Carbon::createFromTimestamp($latestInvoice->created)->format('Y年n月j日') : null;
        }

        return view('student.show', compact('student', 'latestInvoice', 'statusJapanese', 'frequency', 'createdDate'));
    }

    public function edit(Request $request)
    {
        $student = Student::getStudentInfoFromId($request->id, Auth::user()->school_id);
        $lessonPlans = LessonPlan::getLessonPlans(Auth::user()->school_id);
        $teachers = Teacher::getPaginatedList(Auth::user()->school_id, 0);
        return view('student.edit', compact('student', 'lessonPlans', 'teachers'));
    }

    public function update(Request $request)
    {
        if (Auth::user()->role == 'admin'){
            Validator::make($request->all(), [
                'icon'              => ['image', 'mimes:png,jpg,jpeg', 'max:2048', 'nullable'],
                'family_name'       => ['required', 'string', 'max:255'],
                'first_name'        => ['required', 'string', 'max:255'],
                'family_name_kana'  => ['required', 'string', 'max:255'],
                'first_name_kana'   => ['required', 'string', 'max:255'],
                'nickname'          => ['string', 'max:255', 'nullable'],
                'lesson_plan_id'    => ['required', 'integer'],
                'main_teacher_id'   => ['required', 'integer'],
                'sub_teacher_ids.*' => ['integer', 'nullable'],
                'tel'               => ['required', 'string', 'max:13'],
                'line_id'           => ['string', 'max:255', 'nullable'],
                'id'                => ['required', 'integer'],
                'email'             => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore($request->id),
                ],
            ])->validate();
            $redirectTo = 'student.show';
        } elseif (Auth::user()->role == 'student') {
            Validator::make($request->all(), [
                'icon'              => ['image', 'mimes:png,jpg,jpeg', 'max:2048', 'nullable'],
                'family_name'       => ['required', 'string', 'max:255'],
                'first_name'        => ['required', 'string', 'max:255'],
                'family_name_kana'  => ['required', 'string', 'max:255'],
                'first_name_kana'   => ['required', 'string', 'max:255'],
                'nickname'          => ['string', 'max:255', 'nullable'],
                'tel'               => ['required', 'string', 'max:13'],
                'line_id'           => ['string', 'max:255', 'nullable'],
                'id'                => ['required', 'integer', 'in:' . Auth::id()],
                'email'             => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore($request->id),
                ],
            ])->validate();
            $redirectTo = 'mypage';
        }

        $student = new Student();
        $user = $student->getStudentInfoFromId($request->id, Auth::user()->school_id);
        if (!$user) {
            return redirect()->route('student.index')->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        // 新規画像の投稿があり、既存のアイコン画像があれば削除
        if ($request->hasFile('icon')){
            if ($user->icon) {
                Storage::disk('public')->delete('icons/' . Auth::user()->school_id . '/' . $user->icon);
            }
            $fileName = $request->file('icon')->store('icons/' . Auth::user()->school_id, 'public');
            $user->icon = basename($fileName);

        // アイコンをクリアする場合
        } elseif ($request->input('clear_icon') == '1') {
            if ($user->icon) {
                Storage::disk('public')->delete('icons/' . Auth::user()->school_id . '/' . $user->icon);
                $user->icon = null;
            }
        }

        // DB更新
        $user->fill($request->except('_method', '_token', 'clear_icon', 'id', 'icon', 'lesson_plan_id', 'main_teacher_id', 'sub_teacher_ids'));
        $user->save();

        if (Auth::user()->role == 'admin'){
            // 受講プランの更新
            StudentProfile::updateFromRequest($request);

            // メイン担当講師の更新
            DB::transaction(function () use ($request) {
                // 既存設定の有無を確認
                $relation = StudentTeacherRelation::where('student_id', $request->id)
                                                    ->where('category', 'main')
                                                    ->first();
                if ($relation) {
                    $relation->teacher_id = $request->main_teacher_id;
                    $relation->save();
                } else {
                    StudentTeacherRelation::create([
                        'student_id' => $request->id,
                        'teacher_id' => $request->main_teacher_id,
                        'category'   => 'main'
                    ]);
                }
            });

            // サブ担当講師の更新
            StudentTeacherRelation::where('student_id', $request->id)
                                    ->where('category', 'sub')
                                    ->delete();
            if ($request->sub_teacher_ids) {
                foreach ($request->sub_teacher_ids as $subTeacherId) {
                    $studentTeacherRelations[] = [
                        'student_id' => $request->id,
                        'teacher_id' => $subTeacherId,
                        'category'   => 'sub',
                    ];
                }
                StudentTeacherRelation::insert($studentTeacherRelations);
            }
        }

        // ログイン中のユーザー情報を更新
        Auth::setUser($user);

        return redirect()->route($redirectTo, $request->id)->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function delete(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:users,id'
            ],
        ]);

        $student = Student::getStudentInfoFromId($request->id, Auth::user()->school_id);
        if (empty($student)){
            return redirect()->route('student.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }
        // $this->authorize('delete', $student);

        $student->delete();

        return redirect()->route('student.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }

    public function showQrcode()
    {
        $studentToken = Auth::user()->register_student_token;
        return view('student.qrcode', compact('studentToken'));
    }
}
