<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintence', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('group_id')->unsigned()->index()->nullable();
            $table->foreign('group_id')->references('id')->on('maintences_group');

            $table->integer('type_id')->unsigned()->index()->nullable();
            $table->foreign('type_id')->references('id')->on('maintences_type');

            $table->integer('subtype_id')->unsigned()->index()->nullable();
            $table->foreign('subtype_id')->references('id')->on('maintences_subtype');

            $table->integer('unit_id')->unsigned()->index()->nullable();
            $table->foreign('unit_id')->references('id')->on('maintences_unit');

            $table->string('code', 150)->nullable();
            $table->string('kh_name', 150)->nullable();
            $table->string('en_name', 150)->nullable();
            $table->string('rate', 150)->nullable();
            $table->longText('description')->nullable();

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
        Schema::dropIfExists('maintence');
    }
}
