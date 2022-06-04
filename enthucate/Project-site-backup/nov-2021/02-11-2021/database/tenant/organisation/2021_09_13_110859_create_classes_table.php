<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid')->unsigned()->index(); 
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('organisation_id')->nullable();
            $table->bigInteger('school_id')->unsigned()->index(); 
            $table->foreign('school_id')->references('id')->on('school')->onDelete('cascade');
            $table->bigInteger('grade_id')->unsigned()->index(); 
            $table->foreign('grade_id')->references('id')->on('grade')->onDelete('cascade');
            $table->string('class_name')->nullable();
            $table->enum('is_del', array('0','1'));
            $table->integer('created_by')->nullable()->default(null);            
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
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
        Schema::dropIfExists('classes');
    }
}
