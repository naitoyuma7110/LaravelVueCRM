<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Inertia\Inertia;

class ItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $items = Item::select('id', 'name', 'price', 'is_selling')->get();


    return Inertia::render('Items/Index', [
      'items' => $items
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return Inertia::render('Items/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreItemRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreItemRequest $request)
  {
    Item::create([
      'name' => $request->name,
      'memo' => $request->memo,
      'price' => $request->price
    ]);

    return to_route('items.index')
      ->with([
        'message' => '登録しました。',
        'status' => 'success'
      ]);;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function show(Item $item)
  {
    return Inertia::render('Items/Show', [
      'item' => $item
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function edit(Item $item)
  {

    // dd($item->is_selling);
    // ルートパラメータ(item : id)に対応したItemモデルを自動で引数として受け取り使用する
    return Inertia::render('Items/Edit', [
      'item' => $item
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateItemRequest  $request
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateItemRequest $request, Item $item)
  {
    // updateアクションはリクエストとDB情報(Itemモデル)を引数として使用可能
    $item->name = $request->name;
    $item->memo = $request->memo;
    $item->price = $request->price;
    $item->is_selling = $request->is_selling;
    $item->save();

    return to_route('items.index')
      ->with([
        'message' => '更新しました',
        'status' => 'success'
      ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function destroy(Item $item)
  {
    // 完全デリート
    $item->delete();

    // ソフトデリートについてはまた今度

    return to_route('items.index')
      ->with([
        'message' => '削除しました',
        'status' => 'danger'
      ]);
  }
}
