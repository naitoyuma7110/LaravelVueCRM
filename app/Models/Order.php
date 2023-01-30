<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\Subtotal;

use Carbon\Carbon;

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

    // where句で$startDate,$endDateからcreated_atを絞り込む際
    // YYYY-MM-DDのみの情報は、自動的にYYYY-MM-DD 00：00(00時00分)となる
    // endDateの日が指定期間内に含まれない状態->Curbonを使用しendDateに1日追加する

    if (is_null($startDate) && is_null($endDate)) {
      return $query;
    }

    if (!is_null($startDate) && is_null($endDate)) {
      return $query->where('created_at', '>=', $startDate);
    }

    if (is_null($startDate) && !is_null($endDate)) {
      $endDateAdd1day = Carbon::parse($endDate)->addDays(1);
      return $query->where('created_at', '<=', $endDateAdd1day);
    }

    if (!is_null($startDate) && !is_null($endDate)) {
      $endDateAdd1day = Carbon::parse($endDate)->addDays(1);
      return $query->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', $endDateAdd1day);
    }
  }
}
