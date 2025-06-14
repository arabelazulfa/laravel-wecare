<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::dropIfExists('nama_tabel_lama'); // misalnya 'notifications' (kalau beda dari Laravel)
}

public function down()
{
    Schema::create('nama_tabel_lama', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('title');
        $table->text('message');
        $table->boolean('is_read')->default(false);
        $table->boolean('is_urgent')->default(false);
        $table->string('link')->nullable();
        $table->timestamps();
    });
}

};
