<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_options', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->string('name'); // Name of the delivery option
            $table->text('description')->nullable(); // Description of the delivery option
            $table->decimal('price', 8, 2)->default(0.00); // Price for the delivery option
            $table->string('estimated_delivery_time')->nullable(); // Estimated delivery time, e.g., "2-3 days"
            $table->boolean('is_active')->default(true); // Status of the delivery option (active or not)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_options');
    }
}
