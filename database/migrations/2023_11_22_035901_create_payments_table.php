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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('gust_id')->nullable();
            $table->integer('host_id')->nullable();
            $table->integer('list_id')->nullable();
            $table->integer('booking_id')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->decimal('gust_amount')->nullable();
            $table->decimal('host_amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
