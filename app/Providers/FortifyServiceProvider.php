<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\LessonPlan;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/login');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::requestPasswordResetLinkView(fn () => view('auth.password.forgot'));
        Fortify::resetPasswordView(fn () => view('auth.password.reset-password'));
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::registerView(function (Request $request) {
            $lessonPlans = false;
            $stripePublicKey = false;

            // 受講プランを取得
            if (isset($request->token)){
                $teacher = Teacher::getTeacherInfoFromToken($request->token);
                if ($teacher){
                    $schoolId = $teacher->school_id;
                    $lessonPlans = LessonPlan::getLessonPlans($schoolId);
                    $school = School::getSchoolInfoFromId($schoolId);
                    
                    // 決済を組み込むか確認（環境ファイルにStripe情報がない and 受講プランにstripe_plan_idの設定が1つもない and SuperAdminで決済利用制限がされてない場合は決済機能はオフ）
                    $stripeSettings = config('services.stripe');
                    if (isset($stripeSettings[$schoolId])
                        && $lessonPlans && $lessonPlans->where('stripe_plan_id', '!=', null)->count() > 0
                        && $school->payment_restriction === 0){
                        $stripePublicKey = $stripeSettings[$schoolId]['public_key'];
                    }
                }
            }
            
            return view('auth.register', [
                'token'           => $request->token,
                'lessonPlans'     => $lessonPlans,
                'stripePublicKey' => $stripePublicKey
            ]);
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });
    }
}
