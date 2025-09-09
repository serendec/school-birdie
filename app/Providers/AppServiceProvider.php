<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::shouldBeStrict(! $this->app->isProduction());

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            // 開発環境ではテスト用のレスポンスを許可
            if (app()->environment('local') && $value === 'test-response') {
                return true;
            }
            
            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value
                ]
            ]);
            $body = json_decode((string)$response->getBody());
            return $body->success;
        }, 'エラーが発生しました、時間をおいて再度お試しください。複数回エラーが発生する場合は、お問い合わせください。');
    }
}
