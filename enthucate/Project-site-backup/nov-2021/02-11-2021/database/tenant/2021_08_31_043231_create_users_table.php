<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hierarchy_id')->nullable(); // this is working 
            $table->bigInteger('role_id')->nullable(); // this is working
            $table->bigInteger('organisation_id')->nullable();
            $table->text('school_id')->nullable();
            $table->bigInteger('school_sub_id')->nullable();
            $table->bigInteger('department_id')->nullable(); 
            $table->string('JoinID')->nullable();                        
            $table->string('username')->nullable();            
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('organisation_url')->nullable();
            $table->string('position_title')->nullable();
            $table->string('position')->nullable();
            $table->string('country_code')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();            
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->Integer('otp')->nullable();
            $table->enum('is_del', array('0','1'));
            $table->enum('status', array('0','1'));
            $table->string('user_type')->nullable();                        
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
