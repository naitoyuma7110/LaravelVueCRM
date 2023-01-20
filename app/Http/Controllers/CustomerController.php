<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;

use Inertia\Inertia;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // $getTest = Customer::select('id','name','kana','tel')->get();
    // $paginateTest = Customer::select('id','name','kana','tel')->paginate(20);
    // dd($getTest, $paginateTest);

    // クエリスコープの呼び出しはメソッド名、引数が変わる
    // where句が一致しない場合に全件を取得するのは仕様？
    $customers = Customer::searchCustomers($request->search)->select('id', 'name', 'kana', 'tel')->paginate(50);


    return Inertia::render('Customers/Index', [
      'customers' => $customers
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {

    return Inertia::render('Customers/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreCustomerRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreCustomerRequest $request)
  {

    Customer::create([
      'name' => $request->name,
      'kana' => $request->kana,
      'tel' => $request->tel,
      'email' => $request->email,
      'postcode' => $request->postcode,
      'address' => $request->address,
      'birthday' => $request->birthday,
      'gender' => $request->gender,
      'memo' => $request->memo,
    ]);

    return to_route('customers.index')
      ->with([
        'message' => '登録しました。',
        'status' => 'success'
      ]);;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function show(Customer $customer)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function edit(Customer $customer)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateCustomerRequest  $request
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateCustomerRequest $request, Customer $customer)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function destroy(Customer $customer)
  {
    //
  }
}
