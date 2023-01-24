<?php

namespace Database\Seeders;

use App\Models\Purchase;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ItemSeeder;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      UserSeeder::class,
      ItemSeeder::class
    ]);
    \App\Models\Customer::factory(300)->create();

    $items = Item::all();
    Purchase::factory(100)->create()
      ->each(function (Purchase $purchase) use ($items) {
        // ->items():絞り込みを行う場合はメソッド呼び出し
        // attach():リレーションの中間テーブルへのレコード挿入
        // item_purchaseテーブルへのitem_id,quanitityの挿入
        $purchase->items()->attach(
          // pluck(key):modelのkeyに対応する値をコレクションとして取得->toArray:配列に変換
          $items->random(rand(1, 3))->pluck('id')->toArray(),
          ['quantity' => rand(1, 5)]
        );
      });

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
  }
}
