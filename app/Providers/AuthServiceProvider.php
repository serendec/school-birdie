<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\User'  => 'App\Policies\TeacherPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function ($user) {
            Log::info('Gate check for isSuperAdmin', ['user' => $user]);
            return $user->role === 'super_admin';
        });

        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('isTeacher', function ($user) {
            return ($user->role === 'admin' || $user->role === 'teacher');
        });

        Gate::define('isStudent', function ($user) {
            return ($user->role === 'student');
        });

        Gate::define('isNotSuperAdmin', function ($user) {
            return $user->role !== 'super_admin';
        });

        Gate::define('isAdminOrStudent', function ($user) {
            return ($user->role === 'student' || $user->role === 'admin');
        });
    }
}
