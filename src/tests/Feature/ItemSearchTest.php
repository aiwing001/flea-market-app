<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_can_be_searched_by_partial_match()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => '説明',
            'image' => 'test.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => 'ノートPC',
            'brand' => 'なし',
            'price' => 45000,
            'description' => '説明',
            'image' => 'test.jpg',
            'condition' => 1,
            'status' => 1,
        ]);

        $response = $this->get('/?keyword=腕');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('ノートPC');
    }

    public function test_search_keyword_is_preserved()
    {
        $response = $this->get('/?keyword=腕');

        $response->assertStatus(200);
        $response->assertSee('keyword=腕', false);
    }
}
