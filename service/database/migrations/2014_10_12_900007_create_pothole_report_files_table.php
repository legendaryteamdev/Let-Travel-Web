<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotholeReportFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pothole_report_files', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('report_id')->unsigned()->index()->nullable();
            $table->foreign('report_id')->references('id')->on('pothole_reports')->onDelete('cascade');
            $table->string('uri', 500)->default('');
            $table->string('lat', 20)->nullable(); 
            $table->string('lng', 20)->nullable();
            $table->boolean('is_accepted')->default(1);

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
        Schema::dropIfExists('pothole_report_files');
    }
}
