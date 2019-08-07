<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name", 32)->nullable()->default("")->comment('名称');
            $table->decimal('go_in')->nullable()->default(0)->comment('转入');
            $table->decimal('go_out')->nullable()->default(0)->comment('转出');
            $table->decimal('capital')->nullable()->default(0)->comment('本金');
            $table->decimal('balance')->nullable()->default(0)->comment('余额');
            $table->decimal('market')->nullable()->default(0)->comment('市值');
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
        Schema::dropIfExists('project');
    }
}
