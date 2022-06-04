<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid')->unsigned()->index(); 
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('organisation_id')->nullable();
            $table->text('type_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('members')->nullable();
            $table->text('recipients')->nullable();
            $table->bigInteger('message_category')->nullable();
            $table->text('message')->nullable();            
            $table->text('attachment')->nullable();
            $table->string('message_type')->nullable();
            $table->enum('message_priority', array('Normal','Urgent','Critical'));
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
        Schema::dropIfExists('message');
    }
}
