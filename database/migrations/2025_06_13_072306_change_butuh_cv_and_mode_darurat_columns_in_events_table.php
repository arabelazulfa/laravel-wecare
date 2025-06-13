<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeButuhCvAndModeDaruratColumnsInEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->enum('butuh_cv', ['ya', 'tidak'])->change();
            $table->enum('mode_darurat', ['ya', 'tidak'])->change();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Kembalikan ke tipe semula jika rollback (misalnya integer atau boolean)
            $table->integer('butuh_cv')->change();
            $table->integer('mode_darurat')->change();
        });
    }
}
