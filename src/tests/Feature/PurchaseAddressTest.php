<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use Tests\TestCase;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_shipping_address_is_display_on_purchase_page()
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

        Address::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->post('/purchase/address/' . $product->id,
        [
            'postal_code' => '987-6543',
            'address' => '大阪府大阪市',
            'building' => 'テストマンション202',
        ]);

        $response->assertRedirect('/item/' . $product->id . '/purchase');

        $response = $this->actingAs($user)->get('/item/' . $product->id . '/purchase');

        $response->assertStatus(200);
        $response->assertSee('987-6543');
        $response->assertSee('大阪府大阪市');
        $response->assertSee('テストマンション202');
    }

    public function test_purchased_item_is_associated_with_shipping_address()
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
            'status' => 1,
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101'
        ]);

        $response = $this->actingAs($user)->get(
            '/purchase/success/' . $product->id . '?payment_method=card'
        );

        $response->assertRedirect('/');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'address_id' => $address->id,
            'total_price' => $product->price,
            'payment_method' => 'card',
        ]);
    }
}
