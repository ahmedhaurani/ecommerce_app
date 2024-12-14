<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key with cascade on delete
            $table->string('locale', 5); // e.g., 'en', 'ar'
            $table->string('name');
            $table->text('short_description');
            $table->text('description');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->unique(['product_id', 'locale']); // Unique index on product_id and locale
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
;
