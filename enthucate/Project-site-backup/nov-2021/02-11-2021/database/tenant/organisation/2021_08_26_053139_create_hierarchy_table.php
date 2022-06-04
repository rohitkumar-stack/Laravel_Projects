<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHierarchyTable extends Migration
{
     public $set_schema_table = 'hierarchy';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create('hierarchy', function (Blueprint $table) {
            $table->id();
            $table->string('level_name')->nullable();
            $table->text('description')->nullable();
            $table->string('license_type')->nullable();
            $table->enum('is_del', array(0,1)); 
            $table->timestamps();
        });
        DB::unprepared( file_get_contents(public_path('/sql/hierarchy.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hierarchy');
    }
}
