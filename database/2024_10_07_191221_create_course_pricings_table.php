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
        Schema::create('course_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Foreign key to courses
            $table->decimal('price', 8, 2); // Price of the course
            $table->string('billing_cycle')->default('monthly'); // e.g., monthly, yearly
            $table->integer('classes_per_week')->default(1); // Number of classes per week
            $table->integer('course_duration')->default(60); // Duration of each class in minutes
            $table->boolean('is_best')->default(false); // Flag for marking "best" plan
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
        Schema::dropIfExists('course_pricings');
    }
};
