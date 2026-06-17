<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'data' => [
                    'user_id' => 1,
                    'name' => '腕時計',
                    'brand' => 'Rolax',
                    'price' => 15000,
                    'description' => 'スタイリッシュなデザインのメンズ腕時計',
                    'image' => 'images/products/Armani+Mens+Clock.jpg',
                    'condition' => 1,
                    'status' => 1,
                ],
                'categories' => [1, 5],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => 'HDD',
                    'brand' => '西芝',
                    'price' => 5000,
                    'description' => '高速で信頼性の高いハードディスク',
                    'image' => 'images/products/HDD+Hard+Disk.jpg',
                    'condition' => 2,
                    'status' => 1,
                ],
                'categories' => [2, 12],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => '玉ねぎ3束',
                    'brand' => 'なし',
                    'price' => 300,
                    'description' => '新鮮な玉ねぎ3束のセット',
                    'image' => 'images/products/iLoveIMG+d.jpg',
                    'condition' => 3,
                    'status' => 1,
                ],
                'categories' => [3],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => '革靴',
                    'brand' => null,
                    'price' => 4000,
                    'description' => 'クラシックなデザインの革靴',
                    'image' => 'images/products/Leather+Shoes+Product+Photo.jpg',
                    'condition' => 4,
                    'status' => 1,
                ],
                'categories' => [1, 5],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => 'ノートPC',
                    'brand' => null,
                    'price' => 45000,
                    'description' => '高性能なノートパソコン',
                    'image' => 'images/products/Living+Room+Laptop.jpg',
                    'condition' => 1,
                    'status' => 1,
                ],
                'categories' => [2],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => 'マイク',
                    'brand' => 'なし',
                    'price' => 8000,
                    'description' => '高音質のレコーディング用マイク',
                    'image' => 'images/products/Music+Mic+4632231.jpg',
                    'condition' => 2,
                    'status' => 1,
                ],
                'categories' => [2, 12],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => 'ショルダーバッグ',
                    'brand' => null,
                    'price' => 3500,
                    'description' => 'おしゃれなショルダーバッグ',
                    'image' => 'images/products/Purse+fashion+pocket.jpg',
                    'condition' => 3,
                    'status' => 1,
                ],
                'categories' => [1, 4],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => 'タンブラー',
                    'brand' => 'なし',
                    'price' => 500,
                    'description' => '使いやすいタンブラー',
                    'image' => 'images/products/Tumbler+souvenir.jpg',
                    'condition' => 4,
                    'status' => 1,
                ],
                'categories' => [4],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => 'コーヒーミル',
                    'brand' => 'Starbacks',
                    'price' => 4000,
                    'description' => '手動のコーヒーミル',
                    'image' => 'images/products/Waitress+with+Coffee+Grinder.jpg',
                    'condition' => 1,
                    'status' => 1,
                ],
                'categories' => [4],
            ],
            [
                'data' => [
                    'user_id' => 1,
                    'name' => 'メイクセット',
                    'brand' => null,
                    'price' => 2500,
                    'description' => '便利なメイクアップセット',
                    'image' => 'images/products/外出メイクアップセット.jpg',
                    'condition' => 2,
                    'status' => 1,
                ],
                'categories' => [4, 6],
            ],
        ];

        foreach ($products as $item) {
            $product = Product::create($item['data']);
            $product->categories()->attach($item['categories']);
        }
    }
}