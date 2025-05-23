<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('volunteer_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('profession', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('interest1', 50)->nullable();
            $table->string('interest2', 50)->nullable();
            $table->string('ktp_file', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_profiles');
    }
}
