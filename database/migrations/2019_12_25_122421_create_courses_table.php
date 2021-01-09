<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name','255');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->integer('offer_price')->default(0);
            $table->integer('manufacturer_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('status')->default(1);
            $table->bigInteger('views')->default(0);
            $table->integer('duration')->default(0);
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
        Schema::dropIfExists('courses');
    }
}
