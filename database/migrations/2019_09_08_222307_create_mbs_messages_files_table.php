<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMbsMessagesFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mbs_messages_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 15);
            $table->integer('message_id');
            $table->string('file_type', 20);
            $table->string('file_name');
            $table->string('file_name_old');
            $table->string('file_path', 100);
            $table->string('video_thumbnail', 100)->nullable();
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('mbs_messages_files');
    }
}
