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
            $table->bigIncrements('id');
            $table->integer('channel_id')->comment('渠道ID');
            $table->string('code', 10)->nullable()->default('')->comment('代号');
            $table->string('name', 32)->nullable()->default('')->comment('名称');
            $table->decimal('amount')->comment('本金');
            $table->decimal('part')->comment('份额');
            $table->decimal('market')->comment('市值');
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
        Schema::dropIfExists('product');
    }
}
