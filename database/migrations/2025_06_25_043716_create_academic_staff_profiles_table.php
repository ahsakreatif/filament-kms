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
        Schema::create('academic_staff_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('academic_id', 50)->unique();
            $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
            $table->string('position'); // Head of Department, Dean, etc.
            $table->string('office_location')->nullable();
            $table->text('responsibilities')->nullable();
            $table->enum('status', ['active', 'inactive', 'retired'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_staff_profiles');
    }
};
