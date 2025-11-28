<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('headline')->nullable();
            $table->json('education')->nullable(); // [{degree, institution, year}]
            $table->json('experience')->nullable(); // [{position, org, duration, description}]
            $table->json('subjects')->nullable();   // [{subject, level, rate}]
            $table->json('availability_schedule')->nullable();

            $table->decimal('hourly_rate', 8, 2)->default(0);
            $table->enum('teaching_mode', ['online', 'offline', 'both'])->default('both');

            $table->string('location')->nullable();
            $table->string('video_intro')->nullable();
            $table->integer('experience_years')->default(0);

            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->boolean('is_certified')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_profiles');
    }
};
