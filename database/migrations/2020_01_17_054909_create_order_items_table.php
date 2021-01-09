<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->default(0);
            $table->unsignedBigInteger('course_id')->default(0);
            $table->unsignedBigInteger('manufacturer_id')->default(0);
            $table->unsignedBigInteger('category_id')->default(0);
            $table->unsignedBigInteger('product_id')->default(0);
            $table->string('duration')->default(0);
            $table->string('location')->nullable();
            $table->string('date')->nullable();
            $table->integer('timing_id')->default(0);
            $table->integer('seats')->default(0);
            $table->string('amount_paid')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('order_items');
    }
}
