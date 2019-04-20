<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotholeConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pothole_consults', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('pothole_id')->unsigned()->index()->nullable();
            $table->foreign('pothole_id')->references('id')->on('pothole')->onDelete('cascade');
            
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('comment', 500)->nullable();
            $table->integer('updater_id')->unsigned()->index()->nullable();
            $table->integer('creator_id')->unsigned()->index()->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pothole_consults');
    }
}
