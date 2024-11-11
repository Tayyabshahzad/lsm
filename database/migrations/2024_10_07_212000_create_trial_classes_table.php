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
        Schema::create('trial_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // reference to the user
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // reference to the course
            $table->string('status')->default('pending'); // status of the trial (e.g., pending, completed)
            $table->timestamp('trial_start')->nullable(); // start time of the trial
            $table->timestamp('trial_end')->nullable(); // end time of the trial
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
        Schema::dropIfExists('trial_classes');
    }
};
