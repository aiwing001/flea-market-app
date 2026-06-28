<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_required()
    {
        $response = $this->post('/register',[
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください'
        ]);
    }

    public function test_email_is_required()
    {
        $response = $this->post('/register',[
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_password_is_required()
    {
        $response = $this->post('/register',[
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    public function test_password_must_be_at_least_8_characters()
    {
        $response = $this->post('/register',[
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);
    }

    public function test_password_must_be_confirmed()
    {
        $response = $this->post('/register',[
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '876564321',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません'
        ]);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register',[
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // テストケース一覧ではプロフィール設定画面へ遷移と記載
        // $response->assertRedirect('/mypage/profile');
        
        // 現在の実装ではメール認証画面へ遷移するためこちらでテスト
        $response->assertRedirect('/email/verify');

        $this->assertDatabaseHas('users',[
            'email' => 'test@example.com',
        ]);
    }

    // メール認証機能のテストは、会員登録機能と一連の処理であるため、RegisterTestにまとめて実装
    public function test_verification_email_is_sent_after_registration()
    {
        Notification::fake();

        $this->post('/register',[
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_is_redirected_to_profile_page_after_email_verification()
    {
        Event::fake();

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/mypage/profile?verified=1');

        $this->assertNotNull($user->fresh()->email_verified_at);

        Event::assertDispatched(Verified::class);
    }
}
