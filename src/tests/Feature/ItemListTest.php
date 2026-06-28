<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_products_are_displayed()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => '商品A',
            'brand' => 'ブランドA',
            'price' => 1000,
            'description' => '商品Aの説明',
            'image' => 'images/products/test-a.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => '商品B',
            'brand' => 'ブランドB',
            'price' => 2000,
            'description' => '商品Bの説明',
            'image' => 'images/products/test-b.jpg',
            'condition' => 2,
            'status' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
    }

    public function test_purchased_items_are_displayed_sold()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => '購入済み商品',
            'brand' => 'ブランド',
            'price' => 4000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
            'condition' => 3,
            'status' => 2,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SOLD');
    }

    public function test_products_list_does_not_include_users_own_items()
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

        Product::create([
            'user_id' => $loginUser->id,
            'name' => '自分の商品',
            'brand' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/my.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        Product::create([
            'user_id' => $otherUser->id,
            'name' => '他人の商品',
            'brand' => 'ブランド',
            'price' => 2000,
            'description' => '説明',
            'image' => 'images/products/my.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $response = $this->actingAs($loginUser)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}
