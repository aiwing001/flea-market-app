<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_sell_page()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

    $response = $this->actingAs($user)->get('/sell');
    $response->assertStatus(200);
    }

    public function test_user_can_register_a_product()
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $response = $this->actingAs($user)->post('/sell',[
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description'=> '説明文',
            'image' => UploadedFile::fake()->create('watch.jpg', 100, 'image/jpeg'),
            'condition' => 1,
            'categories' => [$category->id],
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => '説明文',
            'condition' => 1,
            'status' => 1,
        ]);

        $product = Product::where('name', '腕時計')->first();

        $this->assertNotNull($product);
        $this->assertStringStartsWith('storage/products/', $product->image);

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);
    }
}
