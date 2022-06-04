<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid')->unsigned()->index(); 
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('organisation_id')->nullable();
            $table->string('group_name')->nullable();
            $table->text('description')->nullable();
            $table->text('members')->nullable();
            $table->text('create_members')->nullable();
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
        Schema::dropIfExists('group');
    }
}
