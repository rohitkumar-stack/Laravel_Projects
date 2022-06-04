<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
     public $set_schema_table = 'countries';
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('sortname')->nullable();
            $table->text('name')->nullable();
            $table->string('phonecode')->nullable();
        });
        DB::unprepared( file_get_contents(public_path('/sql/countries.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
