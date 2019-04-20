<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotholeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pothole_reports', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('pothole_id')->unsigned()->index()->nullable();
            $table->foreign('pothole_id')->references('id')->on('pothole')->onDelete('cascade');

            $table->integer('member_id')->unsigned()->index()->nullable();
            $table->foreign('member_id')->references('id')->on('member')->onDelete('cascade');

            $table->integer('commune_id')->unsigned()->index()->nullable();
            $table->foreign('commune_id')->references('id')->on('commune')->onDelete('cascade');

            $table->string('description', 500)->default('');
            $table->boolean('is_posted')->default(1);
            $table->dateTime('posted_at')->nullable();

            //Will be removed
            $table->string('lat', 20)->nullable(); 
            $table->string('lng', 20)->nullable();
            $table->point('point')->nullable();//   Coordinates    
            $table->string('additional_location', 350)->nullable(); 

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
        Schema::dropIfExists('pothole_reports');
    }
}
