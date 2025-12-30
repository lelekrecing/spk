<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('urutan')->unique(); // <-- taruh setelah id (urutan fisik gak wajib)
            $table->string('kode')->unique();
            $table->string('nama');

            $table->unsignedTinyInteger('intensitas');
            $table->unsignedTinyInteger('frekuensi');
            $table->unsignedTinyInteger('porsi');
            $table->unsignedTinyInteger('loyalitas');

            $table->unsignedTinyInteger('lama');
            $table->unsignedTinyInteger('rekomendasi');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
