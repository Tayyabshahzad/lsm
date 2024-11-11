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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Name of the person giving the testimonial
            $table->string('email');  // Email of the person giving the testimonial
            $table->text('message');  // Testimonial content
            $table->string('position')->nullable();  // Position or title (optional)
            $table->boolean('approved')->default(false);  // Admin approval status
            $table->unsignedTinyInteger('rating')->default(0); // Rating from 1 to 5
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
};
