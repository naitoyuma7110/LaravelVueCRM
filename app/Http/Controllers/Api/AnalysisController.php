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
    // start-end間のPurchaseレコード
    $subQuery = Order::betweenDate($request->startDate, $request->endDate);


    if ($request->type === 'perDay') {
      // list():配列の各要素を変数として定義する
      list($data, $labels, $totals) = AnalysisService::perDay($subQuery);
    }

    if ($request->type === 'perMonth') {
      list($data, $labels, $totals) = AnalysisService::perMonth($subQuery);
    }

    if ($request->type === 'perYear') {
      list($data, $labels, $totals) = AnalysisService::perYear($subQuery);
    }

    if ($request->type === 'decil') {
      list($data, $labels, $totals) = AnalysisService::decil($subQuery);
    }

    return response()->json([
      'data' => $data,
      'type' => $request->type,
      'labels' => $labels,
      'totals' => $totals,
    ], Response::HTTP_OK);
  }
}
