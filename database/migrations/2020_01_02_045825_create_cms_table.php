<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_heading');
            $table->string('search_placeholder');
            $table->string('search_button_title');
            $table->string('advance_search_heading');
            $table->string('advance_search_title');
            $table->string('services_title');
            $table->string('services_sub_title');
            $table->string('category_title');
            $table->string('category_sub_title');
            $table->string('manufacturer_title');
            $table->string('manufacturer_sub_title');
            $table->string('testimonial_title');
            $table->string('testimonial_sub_title');
            $table->string('background_image')->nullable();
            $table->string('service_card_1_title')->nullable();
            $table->string('service_card_2_title')->nullable();
            $table->string('service_card_3_title')->nullable();
            $table->integer('service_card_2')->default(1);
            $table->integer('service_card_3')->default(1);
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
        Schema::dropIfExists('cms');
    }
}
