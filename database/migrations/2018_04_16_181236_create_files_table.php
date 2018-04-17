<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('file');
            $table->string('original_name');
            $table->timestamps();
            $table->boolean('public')->default(true);
            $table->foreign('user_id')->references('id')->on('users')->ondelete('cascade');
        });

        Schema::create('file_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('file_id');
            $table->boolean('can_see')->default(false);
            $table->timestamp('read_at');
            $table->foreign('user_id')->references('id')->on('users')->ondelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_user');
        Schema::dropIfExists('files');
    }
}
