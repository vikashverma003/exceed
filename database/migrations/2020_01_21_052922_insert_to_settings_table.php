<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("INSERT INTO `settings` (`id`, `type`, `key`, `value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'contactemails', 'contact_email', '', '1', NULL, NULL)");
        \DB::statement("INSERT INTO `settings` (`id`, `type`, `key`, `value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'contactemails', 'quotes_email', '', '1', NULL, NULL)");
        \DB::statement("ALTER TABLE `quote_enquires` ADD `course` TEXT NULL DEFAULT NULL AFTER `course_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
