<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_start_purchase()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description'=> '説明文',
            'image' => 'images/products/watch.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $response = $this->actingAs($user)->post(
            '/item/' . $product->id . '/purchase',
            [
                'payment_method' => 'card',
            ]
        );

        $response->assertRedirect();
    }

    public function test_purchased_product_is_displayed_as_sold()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description'=> '説明文',
            'image' => 'images/products/watch.jpg',
            'condition' => 1,
            'status' => 2,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SOLD');
    }

    public function test_purchased_product_is_displayed_in_purchase_list()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description'=> '説明文',
            'image' => 'images/products/watch.jpg',
            'condition' => 1,
            'status' => 2,
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101'
        ]);

        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'address_id' => $address->id,
            'total_price' => $product->price,
            'payment_method' => 'card',
            'status' => 1,
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }
}
