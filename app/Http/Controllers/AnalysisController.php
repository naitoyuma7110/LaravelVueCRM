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

    $startDate = '2016-01-01';
    $endDate = '2023-02-01';

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

    // RFMランクの基準値を配列で設定
    $rfmParams = [
      14, 28, 60, 90, 5, 4, 3, 2, 70000, 50000, 20000, 10000
    ];

    $subQuery = DB::table($subQuery)
      ->selectRaw('
      customer_id,
      customer_name,
      recentDate,
      recency,
      frequency,
      monetary,
      CASE
        WHEN recency < ? then 5
        WHEN recency < ? then 4
        WHEN recency < ? then 3
        WHEN recency < ? then 2
        ELSE 1 END as r,
      CASE
        WHEN ? <= frequency THEN 5
        WHEN ? <= frequency THEN 4
        WHEN ? <= frequency THEN 3
        WHEN ? <= frequency THEN 2
        ELSE 1 END as f,
      CASE
        WHEN ? <= monetary THEN 5
        WHEN ? <= monetary THEN 4
        WHEN ? <= monetary THEN 3
        WHEN ? <= monetary THEN 2
        ELSE 1 END as m
      ', $rfmParams);

    $total = DB::table($subQuery)->count();

    $rCount = DB::table($subQuery)
      ->groupBy('r')
      ->selectRaw('r, count(r)')
      ->orderBy('r', 'desc')
      // ->pluck('count(r)');
      ->get();

    $fCount = DB::table($subQuery)
      ->groupBy('f')
      ->selectRaw('f, count(f)')
      ->orderBy('f', 'desc')
      // ->pluck('count(f)');
      ->get();

    $mCount = DB::table($subQuery)
      ->groupBy('m')
      ->selectRaw('m, count(m)')
      ->orderBy('m', 'desc')
      // ->pluck('count(m)');
      ->get();


    // rRank(1～5)毎にグループにまとめる
    // またグループ内にfのランク(1～5)が何件含まれるかそれぞれカウント
    $data = DB::table($subQuery)
      ->groupBy('r')
      ->selectRaw('
        concat("r_", r) as rRank,
        count(CASE WHEN f = 5 THEN 1 END) as f_5,
        count(CASE WHEN f = 4 THEN 1 END) as f_4,
        count(CASE WHEN f = 3 THEN 1 END) as f_3,
        count(CASE WHEN f = 2 THEN 1 END) as f_2,
        count(CASE WHEN f = 1 THEN 1 END) as f_1
        ')
      ->orderBy('rRank', 'desc')
      ->get();

    // $rank = 5;
    // $eachCount = [];
    // for ($i = 0; $i < 5; $i++) {
    //   array_push($eachCount, [
    //     'rank' => $rank,
    //     'r' => $rCount[$i],
    //     'f' => $fCount[$i],
    //     'm' => $mCount[$i]
    //   ]);
    //   $rank--;
    // }

    // dd($subQuery->get(), $rCount, $fCount, $mCount);

    return Inertia::render('Analysis');
  }
}
