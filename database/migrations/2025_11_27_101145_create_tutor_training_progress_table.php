<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_training_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('training_module_id')->constrained('training_modules')->onDelete('cascade');

            $table->boolean('is_completed')->default(false);
            $table->integer('score')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_training_progress');
    }
};
