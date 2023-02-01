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
    // "%Y%m%d":レコードのdateは年月日に設定
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

  public static function perMonth($subQuery)
  {
    // 注文毎の合計金額レコード
    // "%Y%m%d":レコードのdateは年月に設定
    $query =  $subQuery->where('status', true)
      ->groupBy('id')
      ->selectRaw('
        id,
        sum(subtotal) as totalPerPurchase,
        DATE_FORMAT(created_at, "%Y%m") as date
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
  public static function perYear($subQuery)
  {
    // 注文毎の合計金額レコード
    // "%Y%m":レコードのdateは年に設定
    $query =  $subQuery->where('status', true)
      ->groupBy('id')
      ->selectRaw('
        id,
        sum(subtotal) as totalPerPurchase,
        DATE_FORMAT(created_at, "%Y") as date
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
  public static function decil($subQuery)
  {
    // 注文毎に小計を合計する
    $query = DB::table($subQuery)
      ->groupBy('id')
      ->selectRaw('
      id,
      customer_id,
      customer_name,
      SUM(subtotal) as totalPerPurchase
      ');

    // 顧客毎に注文内容を合計する(購入金額合計)
    $query = DB::table($query)
      ->groupBy('customer_id')
      ->selectRaw('
    customer_id,
    customer_name,
    SUM(totalPerPurchase) as total
    ')
      ->orderBy('total', 'desc');

    // 購入順に連番を振る
    // Mysqlでは SET GLOBAL 変数名 = 設定値 でグローバル変数を設定できる
    // Laravel上では@で設定、アクセス
    DB::statement('set @row_num = 0;');
    $query = DB::table($query)
      ->selectRaw('
    @row_num := @row_num + 1 as row_num,
    customer_id,
    customer_name,
    total
  ');

    // NTILEを使用して購入金額順に10段階のグループに分類
    // row_num初期化, $queryは既に連番作成済みのtabel query
    DB::statement('set @row_num = 0;');
    $query = DB::table($query)
      ->selectRaw('
    row_num,
    customer_id,
    customer_name,
    total,
    NTILE(10) over (ORDER BY total DESC) as decil
  ');

    // 10段階のグループ毎に購入金額の合計、平均
    // 全体の売上に対する、グループ毎の合計購入金額の割合
    $total = DB::table($query)->selectRaw(('sum(total) as total'))->get();
    $total = $total[0]->total; // 合計売上金額

    // DBモデルのquery内で変数$totalを使用
    DB::statement("set @total = $total;");
    $data = DB::table($query)
      ->groupBy('decil')
      ->selectRaw('
      decil,
      count(*) as count,
      SUM(total) as totalPerGroup,
      ROUND(AVG(total)) as average,
      ROUND(100 * SUM(total)/@total, 1) as totalRatio
      ')
      ->get();

    $labels = $data->pluck('decil');
    $totals = $data->pluck('totalPerGroup');


    return [$data, $labels, $totals];
  }

  public static function rfm($subQuery)
  {
  }
}
