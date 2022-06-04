<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateTable extends Migration
{
    public $set_schema_table = 'states';
    public function up()
    {
         if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('country_id')->nullable();
        });
        DB::unprepared( file_get_contents(public_path('/sql/states.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
