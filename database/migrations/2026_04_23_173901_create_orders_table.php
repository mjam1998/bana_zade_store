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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('send_method_id');
            $table->tinyInteger('status')->default(0);
            $table->string('name','255');
            $table->string('code','20')->nullable()->unique();
            $table->string('mobile','15');
            $table->decimal('total_amount',15,0);
            $table->decimal('pay_amount',15,0);
            $table->string('track_number',20)->nullable()->unique();
            $table->string('state','255');
            $table->string('city','255');
            $table->text('address');
            $table->string('postal_code',15);
            $table->boolean('is_paid')->default(false);
            $table->text('authority')->nullable();
            $table->string('ref_id','400')->nullable();
            $table->timestamp('send_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->foreign('send_method_id')->references('id')->on('send_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
