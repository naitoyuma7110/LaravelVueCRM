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

    // Orderモデルは設定されたグローバルスコープ(Subtotalsql)で作成されたレコードを持つ
    static::addGlobalScope(new Subtotal);
  }

  // ローカルスコープ(BetweenDate)の使用を設定
  public function scopeBetweenDate($query, $startDate = null, $endDate = null)
  {
    if (is_null($startDate) && is_null($endDate)) {
      return $query;
    }

    if (!is_null($startDate) && is_null($endDate)) {
      return $query->where('created_at', '>=', $startDate);
    }

    if (is_null($startDate) && !is_null($endDate)) {
      return $query->where('created_at', '<=', $endDate);
    }

    if (!is_null($startDate) && !is_null($endDate)) {
      return $query->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', $endDate);
    }
  }
}
