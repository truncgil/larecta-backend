<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->foreign('parent_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade');
            
            // İçerik seviyesini takip etmek için
            $table->integer('level')->default(0)->after('parent_id');
            // Sıralama için
            $table->integer('order')->default(0)->after('level');
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'level', 'order']);
        });
    }
};
