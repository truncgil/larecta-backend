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
        Schema::table('types', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('name'); // Google Material Icon için
            $table->integer('order')->default(0)->after('icon'); // Sıralama için
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active')->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->dropColumn(['icon', 'order', 'status']);
        });
    }
};
