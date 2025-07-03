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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('student_id', 50)->unique();
            $table->foreignId('study_program_id')->constrained()->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
            $table->integer('enrollment_year');
            $table->integer('current_semester');
            $table->decimal('gpa', 3, 2)->nullable();
            $table->foreignId('advisor_id')->nullable()->constrained('lecturer_profiles')->onDelete('set null');
            $table->enum('status', ['active', 'graduated', 'suspended', 'dropped'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
