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

    $startDate = '2021-01-01';
    $endDate = '2024-02-01';

    // Order: Customers-Purchases-(Item_Purchase)-Items

    // start-end間のPurchaseレコード
    $subQuery = Order::betweenDate($startDate, $endDate);

    // $query = DB::table($subQuery)
    //   ->groupBy('id')
    //   ->selectRaw('id, customer_name');

    // $count = DB::table($query)->count();

    // // count2は上手く取得できず…
    // $count2 = DB::table($subQuery)
    //   ->groupBy('id')
    //   ->selectRaw('id, customer_name')
    //   ->count();

    // dd($count, $count2);

    // Purchase(注文ごと)
    $subQuery =  $subQuery->where('status', true)
      ->groupBy('id')
      ->selectRaw('
      id,
      customer_id,
      customer_name,
      SUM(subtotal) as totalPerPurchase,
      created_at
    ');

    $subQuery = DB::table($subQuery)
      ->groupBy('customer_id')
      ->selectRaw('
          customer_id,
          customer_name,
          max(created_at) as recentDate,
          datediff(now(), max(created_at)) as recency,
          count(customer_id) as frequency,
          SUM(totalPerPurchase) as monetary
        ');

    // dd($subQuery->get());

    $subQuery = DB::table($subQuery)
      ->selectRaw('
      customer_id,
      customer_name,
      recentDate,
      recency,
      frequency,
      monetary,
      CASE
        WHEN recency < 14 then 5
        WHEN recency < 28 then 4
        WHEN recency < 60 then 3
        WHEN recency < 90 then 2
        ELSE 1 END as r,
      CASE
        WHEN 7 <= frequency THEN 5
        WHEN 5 <= frequency THEN 4
        WHEN 3 <= frequency THEN 3
        WHEN 2 <= frequency THEN 2
        ELSE 1 END as f,
      CASE
        WHEN 300000 <= monetary THEN 5
        WHEN 200000 <= monetary THEN 4
        WHEN 100000 <= monetary THEN 5
        WHEN 30000 <= monetary THEN 2
        ELSE 1 END as m
      ');

    $total = DB::table($subQuery)->count();

    $rCount = DB::table($subQuery)
      ->groupBy('r')
      ->selectRaw('r, count(r)')
      ->orderBy('r', 'desc')
      ->get();

    $fCount = DB::table($subQuery)
      ->groupBy('f')
      ->selectRaw('f, count(f)')
      ->orderBy('f', 'desc')
      ->get();

    $mCount = DB::table($subQuery)
      ->groupBy('m')
      ->selectRaw('m, count(m)')
      ->orderBy('m', 'desc')
      ->get();

    dd($total, $fCount, $rCount, $mCount);




    return Inertia::render('Analysis');
  }
}
