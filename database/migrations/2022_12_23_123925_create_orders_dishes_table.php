<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders_dishes', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('dishes_id');
            $table->integer('count');
            $table->decimal('sum');
            $table->timestamps();

            $table->foreign('dishes_id')->references('id')->on('dishes');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_dishes');
    }
};
