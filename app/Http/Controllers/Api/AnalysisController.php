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
    // 日毎の合計売上金額レコード
    $data = DB::table($subQuery)
      ->groupBy('date')
      ->selectRaw('date, sum(totalPerPurchase) as total')
      ->get();

    return response()->json([
      'data' => $data
    ], Response::HTTP_OK);
  }
}
