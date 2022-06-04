<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid')->unsigned()->index(); 
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('organisation_id')->nullable();
            $table->string('school_name')->nullable();
            $table->string('name')->nullable();
            $table->string('school_phone')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('emis_number')->nullable();
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
        Schema::dropIfExists('school');
    }
}
