<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('payment_method');
            $table->foreignId('delivery_option_id')->nullable()->constrained('delivery_options');
            $table->decimal('total_amount', 10, 2); // Assuming decimal for price
            $table->string('order_status')->default('pending');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Foreign key constraint

        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
