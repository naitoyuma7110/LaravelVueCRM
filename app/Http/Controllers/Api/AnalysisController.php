<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\AnalysisService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class AnalysisController extends Controller
{
  public function index(Request $request)
  {

    // $startDate = $request->startDate;
    // $endDate = $request->endDate;

    // start-end間のPurchaseレコード
    $subQuery = Order::betweenDate($request->startDate, $request->endDate);


    if ($request->type === 'perDay') {
      // list():配列の各要素を変数として定義する
      list($data, $labels, $totals) = AnalysisService::perDay($subQuery);
    }

    return response()->json([
      'data' => $data,
      'type' => $request->type,
      'labels' => $labels,
      'totals' => $totals,
    ], Response::HTTP_OK);
  }
}
