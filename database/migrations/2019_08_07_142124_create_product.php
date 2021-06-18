<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
	        $table->bigIncrements( 'id' );
	        $table->integer( 'group_id' )->nullable( false )->default( "" )->comment( '分组ID' );
	        $table->string( 'code', 10 )->nullable()->default( '' )->comment( '资产编号' );
	        $table->string( 'name', 32 )->nullable()->default( '' )->comment( '资产名称' );
	        $table->string( 'type', 10 )->nullable()->default( '1' )->comment( '类型stock股票 fund基金 etf' );
	        $table->decimal( 'amount' )->comment( '本金' );
	        $table->decimal( 'part' )->comment( '份额' );
	        $table->decimal( 'market' )->comment( '市值' );
	        $table->decimal( 'yesterday' )->comment( '昨日市值' );
	        $table->timestamp( 'created_at' )->useCurrent()->comment( '创建时间' );
	        $table->timestamp( 'updated_at' )->default( DB::raw( "CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" ) )
	              ->comment( '更新时间' );
        });
	    DB::statement( "ALTER TABLE `transfer` comment '资产明细'" );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
