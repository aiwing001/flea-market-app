<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_post_comment()
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

        $response = $this->actingAs($user)->post(
            '/comment/' . $product->id,
            [
                'content' => 'テストコメント',
            ]
        );

        $this->assertDatabaseHas('comments',[
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_guest_user_cannot_post_comment()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password')
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

        $response = $this->post('/comment/' . $product->id);

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_comment_is_required()
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

        $response = $this->actingAs($user)->post(
            '/comment/' . $product->id,
            [
                'content' => '',
            ]
        );

        $response->assertSessionHasErrors('content');
    }

    public function test_comment_must_not_exceed_255_characters()
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

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post(
            '/comment/' . $product->id,
            [
                'content' => $longComment,
            ]
        );

        $response->assertSessionHasErrors('content');
    }
}
