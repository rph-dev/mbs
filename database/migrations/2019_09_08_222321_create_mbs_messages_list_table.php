<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMbsMessagesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mbs_messages_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('message_id');
            $table->bigInteger('group_id');
            $table->bigInteger('user_id');
            $table->integer('position_id');
            $table->integer('department_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mbs_messages_list');
    }
}
