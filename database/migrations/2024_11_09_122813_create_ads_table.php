<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();            // Optional title for the ad
            $table->string('image');                        // Path to the image
            $table->string('link')->nullable();             // URL to redirect when the ad is clicked
            $table->string('position')->nullable();         // Position (e.g., 'sidebar', 'banner')
            $table->boolean('is_active')->default(true);    // Toggle to activate/deactivate the ad
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
