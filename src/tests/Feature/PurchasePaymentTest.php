<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchasePaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_selected_payment_method_is_display_on_purchase_page()
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

        $response = $this->actingAs($user)->withSession([
                'payment_method' => 'card',
            ])
            ->get('/item/' . $product->id . '/purchase');

        $response->assertStatus(200);
        $response->assertSee('カード払い');
    }
}
