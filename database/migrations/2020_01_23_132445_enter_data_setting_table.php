<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnterDataSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         \DB::statement("INSERT INTO `settings` (`id`, `type`, `key`, `value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'content', 'termcontent', '', '1', NULL, NULL)");

        \DB::statement("INSERT INTO `settings` (`id`, `type`, `key`, `value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'content', 'privacycontent', '', '1', NULL, NULL)");
       
        \DB::statement("INSERT INTO `settings` (`id`, `type`, `key`, `value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'content', 'cookiecontent', '', '1', NULL, NULL)");
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
