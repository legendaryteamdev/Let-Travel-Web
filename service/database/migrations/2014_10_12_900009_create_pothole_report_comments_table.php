<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotholeReportCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pothole_report_comments', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('report_id')->unsigned()->index()->nullable();
            $table->foreign('report_id')->references('id')->on('pothole_reports')->onDelete('cascade');
            
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('comment', 500)->default('');

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
        Schema::dropIfExists('pothole_report_comments');
    }
}
