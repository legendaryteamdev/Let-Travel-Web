<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotholeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pothole', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('action_id')->unsigned()->index()->nullable(); //Relate to mt_actions
            $table->integer('maintence_id')->unsigned()->index()->nullable();
            $table->foreign('maintence_id')->references('id')->on('maintence');
            
            $table->integer('point_id')->unsigned()->index()->nullable();
            $table->foreign('point_id')->references('id')->on('road_pk_points');

            $table->string('code', 150)->nullable();
            $table->double('quantity')->nullable();

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
        Schema::dropIfExists('pothole');
    }
}
