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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name','400');
            $table->string('slug','400')->unique();
            $table->string('code','400')->unique();
            $table->string('size','400')->nullable();
            $table->bigInteger('count')->nullable();
            $table->decimal('price',15,0)->nullable();
            $table->decimal('discount',15,0)->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title','400')->nullable();
            $table->string('meta_description','400')->nullable();
            $table->string('keywords','400')->nullable();
            $table->string('image','400')->nullable();
            $table->string('image_alt','400')->nullable();
            $table->string('image_title','400')->nullable();
            $table->boolean('has_sub_product')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
