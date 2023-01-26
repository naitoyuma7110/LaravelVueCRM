<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Item;


class Purchase extends Model
{
  use HasFactory;

  protected $fillable = [
    'customer_id',
    'status'
  ];

  // Get relation Customer(one) : Purchese->customer
  // リレーション(Customer:Purchase [one to many] )
  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  // Purches : Item [many to many]
  public function items()
  {
    // 暗黙的にitem_purchase(中間テーブル)を介したitemへのリレーションを作成できる
    // 中間テーブルのid(各リレーション先の外部キー)以外の属性の取得
    return $this->belongsToMany(Item::class)
      ->withPivot('quantity');
  }
}
