<?php
namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Anhskohbo\NoCaptcha\Rules\Captcha;

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
        Blade::if('IsAdmin', function () {
            return Auth::user()->role_id == 0;
        });
        Blade::if('IsBank', function () {
            return Auth::user()->role_id == 1;
        });
        Blade::if('IsNotaris', function () {
            return Auth::user()->role_id == 2;
        });
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            return app('captcha')->verifyResponse($value, request()->ip());
        });
    }
}
