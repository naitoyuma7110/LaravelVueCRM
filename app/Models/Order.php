<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\Subtotal;


class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {

      // Orderモデルは設定されたsqlで作成されたレコードを持つ
      static::addGlobalScope(new Subtotal);
    }
}
