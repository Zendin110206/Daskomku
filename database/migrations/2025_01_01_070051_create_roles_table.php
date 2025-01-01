<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->string('avatar_url', 255)->nullable();
            $table->string('photo_character_url', 255)->nullable(); // AKU LIHAT DARI DLOR 2024 ada 2 link atau 3 link, TAPI GATAU KALAU NANTI KALIAN MAUNYA GIMANA gambarnya jadi satu kesatuan apa gimana, INI NANTI MASIH BINGUNG MANA YANG DIBUTUHIN APA JADI SATU ATAU GIMANA ENTAR NYESUAIKAN AJA
            $table->string('photo_profile_url', 255)->nullable();
            $table->integer('quota')->nullable(); // hurufnya biar beda sama yang shift yang jadwal 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
