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
    $endDate = '2022-02-01';

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

    dd($subQuery->get());



    return Inertia::render('Analysis');
  }
}
