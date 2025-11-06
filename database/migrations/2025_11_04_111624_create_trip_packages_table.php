<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
Schema::create('trip_packages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('destination_id')->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->text('description')->nullable();
    $table->json('inclusions')->nullable(); // ✅ store array as JSON
    $table->longText('overview')->nullable();
    $table->longText('terms_and_conditions')->nullable();
    $table->longText('itinerary')->nullable();
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('trip_packages');
    }
};

