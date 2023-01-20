<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use HasFactory;

  protected $fillable = [
    "name",
    "kana",
    "tel",
    "email",
    "postcode",
    "address",
    "birthday",
    "gender",
    "memo"
  ];

  // デフォルトでinput情報nullで呼び出す
  public function scopeSearchCustomers($query, $input = null)
  {
    if (!empty($input)) {
      // like句による検索,%は0文字以上のワイルドカード
      // 入力情報ありの時にkana or telテーブルを$inputの前方一致で検索
      if (Customer::where('kana', 'like', $input . '%')
        ->orWhere('tel', 'like', $input . '%')->exists()
      ) {
        return $query->where('kana', 'like', $input . '%')
          ->orWhere('tel', 'like', $input . '%');
      }
    }
  }
}
