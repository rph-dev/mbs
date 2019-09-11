<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVMbsGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER() SQL SECURITY DEFINER VIEW `v_mbs_group` AS select `mbs_group`.`id` AS `id`,`mbs_group`.`group_id` AS `group_id`,`mbs_group`.`contact_id` AS `contact_id`,substr(`mbs_group`.`contact_id`,1,1) AS `contact_type`,substr(`mbs_group`.`contact_id`,2) AS `contact_only_id`,`mbs_group`.`total` AS `total`,`mbs_group`.`created_at` AS `created_at`,`mbs_group`.`updated_at` AS `updated_at`,`mbs_group`.`deleted_at` AS `deleted_at` from `mbs_group`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_mbs_group");
    }
}
