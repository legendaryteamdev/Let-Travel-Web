<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotholesStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('potholes_statuses', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('pothole_id')->unsigned()->index()->nullable();
            $table->foreign('pothole_id')->references('id')->on('pothole')->onDelete('cascade');

            $table->integer('status_id')->unsigned()->index()->nullable();
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->integer('mt_id')->unsigned()->index()->nullable();
            $table->string('comment', 500)->nullable();
            

            $table->integer('creator_id')->unsigned()->index()->nullable();
            $table->integer('updater_id')->unsigned()->index()->nullable();
            $table->integer('deleter_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('potholes_statuses');
    }
}
