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
              // NEW: School Profiles Table
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('school_name');
            $table->string('registration_number')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('website')->nullable();
            $table->integer('total_students')->default(0);
            $table->integer('total_teachers')->default(0);
            $table->json('grades_offered')->nullable(); // ['primary', 'secondary', etc.]
            $table->text('facilities')->nullable();
            $table->enum('institution_type', ['school', 'college', 'university', 'coaching_center'])->default('school');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
