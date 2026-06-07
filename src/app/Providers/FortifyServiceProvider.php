<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RegisterResponse::class,function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    return redirect('/mypage/profile');
                }
            };
        });

        $this->app->singleton(LoginResponse::class,function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    return redirect('/');
                }
            };
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
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
            ], [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレス形式で入力してください',
                'password.required' => 'パスワードを入力してください',
                'password.min' => 'パスワードは8文字以上で入力してください',
            ])->validate();

            if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                return Auth::user();
            }

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        });

        Fortify::loginView(function () {
            return view('login');
        });

        Fortify::registerView(function () {
            return view('register');
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}