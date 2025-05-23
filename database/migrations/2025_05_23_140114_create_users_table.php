<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['volunteer','organizer','admin'])->nullable();
            $table->enum('gender', ['male','female'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->string('otp_code', 10)->nullable();
            $table->dateTime('otp_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
