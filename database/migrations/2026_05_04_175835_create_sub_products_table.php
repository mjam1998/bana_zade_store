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
        Schema::create('sub_products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->unsignedBigInteger('product_id');
            $table->string('name','400');
            $table->decimal('price',15,0)->nullable();
            $table->decimal('discount',15,0)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_products');
    }
};
