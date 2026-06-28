<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_a_product_as_liked()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' =>'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => '説明文',
            'image' => 'images/products/watch.jpg',
            'condition' => 1,
            'status' => 0,
        ]);

        $response = $this->actingAs($user)->post('/like/' . $product->id);

        $this->assertDatabaseHas('likes',[
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('1');
    }

    public function test_liked_icon_is_displayed_for_liked_products()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' =>'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => '説明文',
            'image' => 'images/products/watch.jpg',
            'condition' => 1,
            'status' => 0,
        ]);

        $this->actingAs($user)->post('/like/' . $product->id);

        $response = $this->actingAs($user)->get('/item/' . $product->id);

        $response->assertSee('♥');
        $response->assertSee('item-page__like-button--liked');
    }

    public function test_user_can_remove_a_like()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' =>'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => '説明文',
            'image' => 'images/products/watch.jpg',
            'condition' => 1,
            'status' => 0,
        ]);

        $this->actingAs($user)->post('/like/' . $product->id);

        $this->actingAs($user)->delete('/like/' . $product->id);

        $this->assertDatabaseMissing('likes',[
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}