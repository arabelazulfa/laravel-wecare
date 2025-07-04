<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('time');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('time')->nullable();
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
};
