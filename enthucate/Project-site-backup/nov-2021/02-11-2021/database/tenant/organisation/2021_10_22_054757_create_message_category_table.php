<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'message_category';
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create('message_category', function (Blueprint $table) {
            $table->id();
            $table->text('category')->nullable();
            $table->enum('is_del', array('0','1'));
            $table->timestamps();
        });
        DB::unprepared( file_get_contents(public_path('/sql/message_category.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_category');
    }
}
