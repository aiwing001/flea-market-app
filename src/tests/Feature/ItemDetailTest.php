<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_required_item_details_are_displayed()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $commentUser = User::create([
            'name' => 'コメントユーザー',
            'email' => 'comment@example.com',
            'password' => bcrypt('password'),
        ]);

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
            'condition' => 2,
            'status' => 1,
        ]);

        $product->categories()->attach($category->id);

        Like::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
        ]);

        Comment::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'content' => 'コメント内容です',
        ]);

        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertSee('Rolax');
        $response->assertSee('15,000');
        $response->assertSee('説明');
        $response->assertSee('ファッション');
        $response->assertSee('コメントユーザー');
        $response->assertSee('コメント内容です');
    }

    public function test_multiple_selected_categories_are_displayed()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $categoryA = Category::create([
            'name' => 'ファッション',
        ]);

        $categoryB = Category::create([
            'name' => 'メンズ',
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
            'condition' => 2,
            'status' => 1,
        ]);

        $product->categories()->attach([
            $categoryA->id,
            $categoryB->id,
        ]);
        
        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
