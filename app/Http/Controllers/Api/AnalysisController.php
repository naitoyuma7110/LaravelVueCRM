<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
  public function index(Request $request)
  {

    $startDate = $request->startDate;
    $endDate = $request->endDate;

    // start-end間のPurchaseレコード
    $subQuery = Order::betweenDate($startDate, $endDate);

    // 注文毎の合計金額レコード
    if ($request->type === 'perDay') {
      $subQuery->where('status', true)
        ->groupBy('id')
        ->selectRaw('
          id,
          sum(subtotal) as totalPerPurchase,
          DATE_FORMAT(created_at, "%Y%m%d") as date
          ');
    }

    // DB:modelの基幹クラス queryビルダの各メソッドを使用可能となる
    // 日毎の合計売上金額レコード(date, total)
    $data = DB::table($subQuery)
      ->groupBy('date')
      ->selectRaw('date, sum(totalPerPurchase) as total')
      ->orderBy('date')
      ->get();

    // pluck：指定したキーに対応する値を取得
    $labels = $data->pluck('date');
    $totals = $data->pluck('total');

    return response()->json([
      'data' => $data,
      'type' => $request->type,
      'labels' => $labels,
      'totals' => $totals,
    ], Response::HTTP_OK);
  }
}
