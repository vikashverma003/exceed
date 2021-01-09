<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewEntrycolumnRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("UPDATE `roles` SET `guard` = 'admin' WHERE `roles`.`name` = 'admin'");
        \DB::statement("UPDATE `roles` SET `guard` = 'admin' WHERE `roles`.`name` = 'sub_admin'");
        \DB::statement("UPDATE `roles` SET `guard` = 'web' WHERE `roles`.`name` = 'indivisual'");
        \DB::statement("UPDATE `roles` SET `guard` = 'web' WHERE `roles`.`name` = 'corporate'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
