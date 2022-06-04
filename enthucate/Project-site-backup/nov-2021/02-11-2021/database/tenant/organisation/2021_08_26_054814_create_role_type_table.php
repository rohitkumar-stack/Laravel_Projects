<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'role_type';
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create('role_type', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable();
            $table->enum('is_del', array(0,1)); 
            $table->timestamps();
        });
        DB::unprepared( file_get_contents(public_path('/sql/role_type.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_type');
    }
}
