<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brand_translations', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->foreignId('brand_id')->constrained()->onDelete('cascade'); // Foreign key with cascade on delete
            $table->string('locale', 5); // e.g., 'en', 'ar'
            $table->string('name'); // Translatable name
            $table->text('description')->nullable(); // Optional translatable description
            $table->string('meta_title')->nullable(); // Add meta title
            $table->text('meta_description')->nullable(); // Add meta description
            $table->string('meta_keywords')->nullable(); // Add meta keywords
            $table->unique(['brand_id', 'locale']); // Unique index on brand_id and locale
            $table->timestamps(); // Add this line to create updated_at and created_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_translations');
    }
}
