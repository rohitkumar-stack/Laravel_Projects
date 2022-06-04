<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_chat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_user')->nullable();
            // $table->bigInteger('from_user')->unsigned()->index(); 
            // $table->foreign('from_user')->references('id')->on('users')->onDelete('cascade');
            $table->text('to_user');
            $table->bigInteger('organisation_id')->nullable();
            $table->bigInteger('message_id')->nullable();
            $table->text('content')->nullable();
            $table->text('attachment')->nullable();
            $table->enum('status', array('0','1'));
            $table->enum('notifications_status', array('0','1')); 
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
        Schema::dropIfExists('message_chat');
    }
}
