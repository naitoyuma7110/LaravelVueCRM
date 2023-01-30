<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnalysisController extends Controller
{
  public function index(Request $request)
  {

    $startDate = $request->startDate;
    $endDate = $request->endDate;

    $period = Order::betweenDate($startDate, $endDate)
      ->groupBy('id')
      ->selectRaw('
        id,
        sum(subtotal) as total,
        customer_name,
        status,
        created_at
        ')
      ->orderBy('created_at')
      ->paginate(50);

    // return response()->json([
    //   'data' => [
    //     'startDate' => $startDate,
    //     'endDate' => $endDate
    //   ]
    // ], Response::HTTP_OK);
    return response()->json([
      'data' => $period
    ], Response::HTTP_OK);
  }
}
