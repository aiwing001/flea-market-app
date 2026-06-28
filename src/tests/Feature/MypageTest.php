<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_mypage()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
    }

    public function test_profile_image_is_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'image_url' => 'profile/test-user.png',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('storage/profile/test-user.png');
    }

    public function test_user_name_is_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }

    public function test_user_selling_products_are_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $otherUser = User::create([
            'name' => '別ユーザー',
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
        ]);

        $sellingProduct = Product::create([
            'user_id' => $user->id,
            'name' => '出品した商品',
            'brand' => 'ブランド',
            'price' => 1000,
            'description' => '説明文',
            'image' => 'images/products/selling.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $otherProduct = Product::create([
            'user_id' => $otherUser->id,
            'name' => '他人の商品',
            'brand' => 'ブランド',
            'price' => 2000,
            'description' => '説明文',
            'image' => 'images/products/other.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=sell');

        $response->assertStatus(200);
        $response->assertSee('出品した商品');
        $response->assertDontSee('他人の商品');
    }

    public function test_user_purchased_products_are_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => '購入した商品',
            'brand' => 'ブランド',
            'price' => 3000,
            'description' => '説明文',
            'image' => 'images/products/bought.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'address_id' => $address->id,
            'total_price' => $product->price,
            'payment_method' => 'card',
            'status' => 1,
            'ordered_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入した商品');
    }
}
