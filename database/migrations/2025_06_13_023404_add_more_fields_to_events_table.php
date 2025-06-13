<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('jenis_acara')->nullable();
            $table->string('divisi')->nullable();
            $table->text('tugas_relawan')->nullable();
            $table->text('kriteria')->nullable();
            $table->integer('total_jam_kerja')->nullable();
            $table->integer('jumlah_relawan')->nullable();
            $table->boolean('butuh_cv')->default(false);
            $table->boolean('mode_darurat')->default(false);
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_acara',
                'divisi',
                'tugas_relawan',
                'kriteria',
                'total_jam_kerja',
                'jumlah_relawan',
                'butuh_cv',
                'mode_darurat',
            ]);
        });
    }
};
