<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid')->unsigned()->index(); // this is working
            $table->bigInteger('hierarchy_id')->nullable(); // this is working 
            $table->bigInteger('role_id')->nullable(); // this is working 
            $table->bigInteger('license_type')->nullable(); // this is working
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('organisation_tree')->nullable();
            $table->string('organisation_name')->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('position_title')->nullable();
            $table->string('position')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();           
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->enum('is_del', array('0','1'));
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
        Schema::dropIfExists('organisation');
    }
}
