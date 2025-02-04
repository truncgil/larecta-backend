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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // İçerik türü
            $table->string('title'); // İçeriğin başlığı
            $table->string('slug')->unique(); // URL dostu başlık
            $table->text('content')->nullable(); // Detaylı içerik
            $table->json('meta')->nullable(); // Dinamik alanlar için JSON sütunu
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // İçerik durumu
            $table->timestamps(); // Oluşturulma ve güncellenme tarihleri
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
