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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->string('meta_title',400)->nullable();
            $table->string('meta_description',400)->nullable();
            $table->string('image',400);
            $table->string('image_alt',400)->nullable();
            $table->string('image_title',400)->nullable();
            $table->string('url',500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
