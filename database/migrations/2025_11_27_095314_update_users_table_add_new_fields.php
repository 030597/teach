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
    Schema::table('users', function (Blueprint $table) {
        $table->enum('type', ['student', 'tutor', 'school'])->default('student')->after('id');
        $table->string('phone')->nullable()->after('password');
        $table->string('avatar')->nullable()->after('phone');
        $table->enum('status', ['active', 'inactive', 'pending', 'suspended'])->default('pending')->after('avatar');
        $table->text('bio')->nullable()->after('status');
        $table->string('timezone')->default('UTC')->after('bio');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'type',
            'phone',
            'avatar',
            'status',
            'bio',
            'timezone',
        ]);
    });
}

};
