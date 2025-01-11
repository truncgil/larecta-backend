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
        Schema::create('type_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained()->onDelete('cascade'); // Type'a bağlı
            $table->string('name'); // Meta alanı ismi
            $table->string('field_type'); // Meta türü: 'text', 'number', 'textarea', vb.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_metas');
    }
};
