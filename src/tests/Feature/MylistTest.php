<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_displayed_in_mylist()
    {
        $loginUser = User::create([
            'name' => 'ログインユーザー',
            'email' => 'login@example.com',
            'password' => bcrypt('password'),
        ]);

        $otherUser = User::create([
            'name' => 'ほかのユーザー',
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
        ]);

        $productA = Product::create([
            'user_id' => $otherUser->id,
            'name' => 'いいねした商品',
            'brand' => 'ブランドA',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/a.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $productB = Product::create([
            'user_id' => $otherUser->id,
            'name' => 'いいねしてない商品',
            'brand' => 'ブランドB',
            'price' => 2000,
            'description' => '説明',
            'image' => 'images/products/b.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        Like::create([
            'user_id' => $loginUser->id,
            'product_id' => $productA->id,
        ]);

        $response = $this->actingAs($loginUser)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしてない商品');
    }

    public function test_purchased_items_are_displayed_sold_in_mylist()
    {
        $loginUser = User::create([
            'name' => 'ログインユーザー',
            'email' => 'login@example.com',
            'password' => bcrypt('password'),
        ]);

        $otherUser = User::create([
            'name' => 'ほかのユーザー',
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $otherUser->id,
            'name' => '購入済み商品',
            'brand' => 'ブランド',
            'price' => 4000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
            'condition' => 3,
            'status' => 2,
        ]);

        Like::create([
            'user_id' => $loginUser->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($loginUser)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('SOLD');
    }

    public function test_mylist_display_nothing_for_guest_users()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'ブランド',
            'price' => 1500,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('テスト商品');
    }
}
