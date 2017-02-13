<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password', 60);
            $table->string('fullname', 60);
            $table->string('email', 60)->nullable();
            $table->string('foldername', 60);
            $table->string('photo')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
