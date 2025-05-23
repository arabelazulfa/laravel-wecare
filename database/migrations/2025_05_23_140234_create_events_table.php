<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->string('title', 150)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('location', 150)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->text('description')->nullable();
            $table->string('event_type', 100)->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
