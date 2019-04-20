<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_prizes', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('member_id')->unsigned()->index()->nullable();
            $table->foreign('member_id')->references('id')->on('member')->onDelete('cascade');

            
            $table->string('image', 100)->default('public/user/profile.png');
            $table->integer('score_id')->unsigned()->index()->nullable();
            $table->decimal('score', 10, 5)->nullable();
            $table->string('description', 250)->nullable();

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
        Schema::dropIfExists('member_prizes');
    }
}
