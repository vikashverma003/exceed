<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->unsignedBigInteger('course_id')->default(0);
            $table->unsignedBigInteger('course_timing_id')->default(0);
            $table->unsignedBigInteger('manufacturer_id')->default(0);
            $table->unsignedBigInteger('category_id')->default(0);
            $table->unsignedBigInteger('product_id')->default(0);
            $table->integer('seat')->default(0);
            $table->string('location')->nullable();
            $table->string('date')->nullable();
            $table->string('offer_price')->nullable();
            $table->string('price')->nullable();
            $table->string('currency')->nullable();
            $table->string('coupon')->nullable();
            $table->integer('coupon_applied')->default(0);
            $table->integer('discount')->default(0);
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
        Schema::dropIfExists('cart');
    }
}
