<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageChatStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_chat_status', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid')->nullable();
            $table->bigInteger('message_id')->nullable();
            $table->bigInteger('message_chat_id')->nullable();
            $table->enum('status', array('0','1'));
            $table->enum('is_del', array('0','1'));
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
        Schema::dropIfExists('message_chat_status');
    }
}
