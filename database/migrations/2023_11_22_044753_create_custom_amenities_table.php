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
        Schema::create('custom_amenities', function (Blueprint $table) {
            $table->id();
            $table->integer('list_id')->nullable();
            $table->string('custom_amenity_name')->nullable();
            $table->decimal('custom_amenity_fee')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_amenities');
    }
};
