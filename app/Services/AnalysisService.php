<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AnalysisService
{
  /*
    @param: 指定した期間の注文レコード(OrderModel)
    @return: 注文レコード、注文レコードの日付、日付ごとの売上
  */
  public static function perDay($subQuery)
  {
    // 注文毎の合計金額レコード
    $query =  $subQuery->where('status', true)
      ->groupBy('id')
      ->selectRaw('
        id,
        sum(subtotal) as totalPerPurchase,
        DATE_FORMAT(created_at, "%Y%m%d") as date
      ');

    // DB:modelの基幹クラス queryビルダの各メソッドを使用可能となる
    // 日毎の合計売上金額レコード(date, total)
    $data = DB::table($query)
      ->groupBy('date')
      ->selectRaw('date, sum(totalPerPurchase) as total')
      ->orderBy('date')
      ->get();

    // pluck：指定したキーに対応する値を取得
    $labels = $data->pluck('date');
    $totals = $data->pluck('total');

    return [$data, $labels, $totals];
  }
}
