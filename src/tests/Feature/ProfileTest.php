<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_information_is_displayed_with_current_values()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル101');
    }
}
