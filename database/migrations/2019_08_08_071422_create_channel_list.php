<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('channel_id')->comment('渠道ID');
            $table->tinyInteger('type')->comment('类型：1注入 0转出');
            $table->decimal('amount')->comment('金额');
            $table->decimal('change_after')->comment('修改之后本金');
            $table->date('date')->comment('处理日期');
            $table->timestamps();
        });
	
	    Schema::create('product_list', function (Blueprint $table) {
		    $table->bigIncrements('id');
		    $table->integer('code')->comment('代码');
		    $table->tinyInteger('type')->comment('类型：1购买 0赎回');
		    $table->decimal('amount')->comment('金额');
		    $table->decimal('part')->comment('份额');
		    $table->decimal('change_after')->comment('修改之后本金');
		    $table->date('date')->comment('处理日期');
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
        Schema::dropIfExists('channel_list');
	    Schema::dropIfExists('product_list');
    }
}
