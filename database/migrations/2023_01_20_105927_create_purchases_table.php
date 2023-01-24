<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('purchases', function (Blueprint $table) {
      $table->id();
      // foreignId:外部キー on:参照先テーブル references:参照先カラム onUpdate:同期設定
      // $table->foreignId('customer_id')->references('id')->on('customer')->onUpdate('cascade');

      // constrained:id名から参照先テーブル、カラムを自動設定
      $table->foreignId('customer_id')->constrained()->onUpdate('cascade');
      $table->boolean('status');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('purchases');
  }
};
