<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->enum('role', ['volunteer', 'organizer'])->nullable();
            $table->enum('target_type', ['user', 'event'])->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('report_type', 100)->nullable();
            $table->enum('status', ['pending', 'resolved', 'rejected'])->default('pending');
            $table->text('message')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
