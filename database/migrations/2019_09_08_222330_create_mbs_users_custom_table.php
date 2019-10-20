<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMbsUsersCustomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mbs_users_custom', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('password_rand', 10);
            $table->string('detail')->nullable();
            $table->string('activated')->nullable();
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
        Schema::dropIfExists('mbs_users_custom');
    }
}
