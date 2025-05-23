<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('org_name', 150)->nullable();
            $table->string('org_type', 100)->nullable();
            $table->date('established_date')->nullable();
            $table->string('location', 150)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('org_phone', 20)->nullable();
            $table->string('website', 150)->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('focus_area', 100)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('organization_profiles');
    }
}
