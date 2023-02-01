<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class AnalysisController extends Controller
{
  public function index()
  {

    $startDate = '2022-11-11';
    $endDate = '2023-01-01';

    // Purchase.idで各注文毎にまとめる
    $subQuery = Order::betweenDate($startDate, $endDate)
      ->groupBy('id')
      ->selectRaw('
        id,
        customer_id,
        customer_name,
        SUM(subtotal) as totalPerPurchase
        ');

    // 顧客毎に注文内容を合計する(購入金額合計)
    $subQuery = DB::table($subQuery)
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
    $subQuery = DB::table($subQuery)
      ->selectRaw('
      @row_num := @row_num + 1 as row_num,
      customer_id,
      customer_name,
      total
    ');

    // NTILEを使用して購入金額順に10段階のグループに分類
    // row_num初期化, $subQUeryは既に連番作成済みのtabel query
    DB::statement('set @row_num = 0;');
    $subQuery = DB::table($subQuery)
      ->selectRaw('
      row_num,
      customer_id,
      customer_name,
      total,
      NTILE(10) over (ORDER BY total DESC) as delci
    ');

    // 10段階のグループ毎に購入金額の合計、平均
    // 全体の売上に対する、グループ毎の合計購入金額の割合
    $count = DB::table($subQuery)->count(); // レコード数
    $total = DB::table($subQuery)->selectRaw(('sum(total) as total'))->get();
    $total = $total[0]->total; // 合計売上金額

    // DBモデルのquery内で変数$totalを使用
    DB::statement("set @total = $total;");
    $data = DB::table($subQuery)
      ->groupBy('delci')
      ->selectRaw('
        delci,
        SUM(total) as totalPerGroup,
        ROUND(AVG(total)) as average,
        ROUND(100 * SUM(total)/@total, 1) as totalRatio
        ')
      ->get();

    return Inertia::render('Analysis', [
      'data' => $data
    ]);
  }
}
