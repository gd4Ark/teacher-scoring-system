<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('teacher_id')->references('id')->on('groups');
            $table->foreign('subject_id')->references('id')->on('groups');
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('teachs');
    }
}
