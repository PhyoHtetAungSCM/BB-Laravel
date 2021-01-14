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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile', 64)->nullable();
            $table->integer('type')->default('1');
            $table->string('phone')->nullable();
            $table->date('dob')->format('Y/m/d')->nullable();
            $table->string('address')->nullable();

            $table->integer('create_user_id');
            $table->integer('updated_user_id');
            $table->integer('deleted_user_id')->nullable();
            $table->date('created_at')->format('Y/m/d');
            $table->date('updated_at')->format('Y/m/d');
            $table->date('deleted_at')->format('Y/m/d')->nullable();
            
            // $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            // $table->timestamps();
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
