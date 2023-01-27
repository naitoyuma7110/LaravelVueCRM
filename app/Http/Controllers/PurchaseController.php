<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Purchase;

use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // dd(Order::paginate(50));

    $orders = Order::groupBy('id')
      // selectRaw():素のSQL(select文)の挿入
      ->selectRaw('id, sum(subtotal) as total, status, created_at')
      ->paginate(50);

    return Inertia::render('Purchases/Index', [
      'orders' => $orders
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $customers = Customer::select('id', 'name', 'kana')->get();
    $items = Item::select('id', 'name', 'price')->where('is_selling', true)->get();

    return Inertia::render('Purchases/Create', [
      'customers' => $customers,
      'items' => $items
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StorePurchaseRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePurchaseRequest $request)
  {
    // トランザクション
    DB::beginTransaction();

    try {
      $purchase = Purchase::create([
        'customer_id' => $request->customer_id,
        'status' =>  $request->status
      ]);

      // requestに含まれる商品種類の数だけ生成されたPurchaseモデルに紐づく中間テーブルを作成しidと数量を記録する
      // 中間テーブル作成時のModelのidを第一引数に指定：Purches_idを自動生成
      foreach ($request->items as $item) {
        $purchase->items()->attach($purchase->id, [
          'item_id' => $item['id'],
          'quantity' => $item['quantity']
        ]);
      }

      DB::commit();

      return to_route('dashboard');
    } catch (\Exception $e) {
      DB::rollBack();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Purchase  $purchase
   * @return \Illuminate\Http\Response
   */
  public function show(Purchase $purchase)
  {

    $items = Order::where('id', $purchase->id)->get();

    $order = Order::groupBy('id')
      ->where('id', $purchase->id)
      ->selectRaw('id,  sum(subtotal) as total, customer_name, status, created_at, updated_at')
      ->get();

    // dd($items, $order);
    return Inertia::render('Purchases/Show', [
      'items' => $items,
      'order' => $order
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Purchase  $purchase
   * @return \Illuminate\Http\Response
   */
  public function edit(Purchase $purchase)
  {
    $order = Order::groupBy('id')
      ->where('id', $purchase->id)
      ->select('id', 'customer_id', 'customer_name', 'status', 'created_at', 'updated_at')->get();
    // dd($order);

    // dd($purchase->items()->first()->pivot->quantity, $purchase->items()->first()->name, $purchase->items()->first()->price);
    $returnItems = [];

    $allItems = Item::select('id', 'name', 'price')->get();
    foreach ($allItems as $allItem) {
      $quantity = 0;
      // 購入履歴に登録された商品のみ中間テーブルから数量を取得(履歴になければ0になるはず)
      foreach ($purchase->items as $item) {
        if ($allItem->id === $item->id) {
          $quantity = $item->pivot->quantity;
        }
      }
      array_push($returnItems, [
        'id' => $allItem->id,
        'name' => $allItem->name,
        'price' => $allItem->price,
        'quantity' => $quantity
      ]);
    }


    return Inertia::render('Purchases/Edit', [
      'items' => $returnItems,
      'order' => $order
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
   * @param  \App\Models\Purchase  $purchase
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePurchaseRequest $request, Purchase $purchase)
  {
    // dd($request);
    DB::beginTransaction();

    try {

      // purchaseのstatusを更新
      $purchase->update([
        'status' => $request->status,
      ]);

      // item_purchase中間テーブルの数量を更新
      // syncは引数の内容で削除と更新を同時に行う
      $itemRecords = [];
      foreach ($request->items as $requestItem) {
        // ↓これだとダメ([]でラップして追加されるため)
        // array_push($itemRecords, [
        //   $requestItem['id'] => [
        //     'quantity' => $requestItem['quantity']
        //   ]
        // ]);
        $itemRecords = $itemRecords + [$requestItem['id'] => [
          'quantity' => $requestItem['quantity']
        ]];
      }
      $purchase->items()->sync($itemRecords);
      DB::commit();

      return to_route('dashboard');
    } catch (e) {
      DB::rollBack();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Purchase  $purchase
   * @return \Illuminate\Http\Response
   */
  public function destroy(Purchase $purchase)
  {
    //
  }
}
