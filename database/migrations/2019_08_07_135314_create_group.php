<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create( 'group', function ( Blueprint $table ) {
		    $table->bigIncrements( 'id' );
		    $table->string( "name", 32 )->nullable( false )->default( "" )->comment( '名称' );
		    $table->decimal( 'capital' )->nullable( false )->default( 0 )->comment( '本金' );
		    $table->decimal( 'balance' )->nullable( false )->default( 0 )->comment( '余额' );
		    $table->decimal( 'market' )->nullable( false )->default( 0 )->comment( '市值' );
		    $table->decimal( 'yesterday' )->nullable( false )->default( 0 )->comment( '昨日资产' );
		    $table->decimal( 'week' )->nullable( false )->default( 0 )->comment( '本周资产' );
		    $table->decimal( 'month' )->nullable( false )->default( 0 )->comment( '本月资产' );
		    $table->timestamp( 'created_at' )->useCurrent()->comment( '创建时间' );
		    $table->timestamp( 'updated_at' )->default( DB::raw( "CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" ) )
		          ->comment( '更新时间' );
	    } );
	    DB::statement( "ALTER TABLE `group` comment '资产分组'" );
	    
	    Schema::create( 'transfer', function ( Blueprint $table ) {
		    $table->bigIncrements( 'id' );
		    $table->integer( 'group_id' )->nullable( false )->default( 0 )->comment( "分组ID" );
		    $table->tinyInteger( "type" )->nullable( false )->default( "1" )->comment( '类型：1转入 2转出' );
		    $table->decimal( 'amount' )->nullable( false )->default( 0 )->comment( '交易金额' );
		    $table->decimal( 'change_after' )->nullable( false )->default( 0 )->comment( '交易后金额' );
		    $table->timestamp( 'created_at' )->useCurrent()->comment( '创建时间' );
		    $table->timestamp( 'updated_at' )->default( DB::raw( "CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" ) )
		          ->comment( '更新时间' );
	    } );
	    DB::statement( "ALTER TABLE `transfer` comment '资产组转账记录'" );
	    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group');
	    Schema::dropIfExists('transfer');
    }
}
