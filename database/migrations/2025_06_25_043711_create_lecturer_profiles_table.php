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
        Schema::create('lecturer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('lecturer_id', 50)->unique()->nullable();
            $table->foreignId('faculty_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('specialization')->nullable();
            $table->enum('academic_rank', ['assistant', 'lecturer', 'associate_professor', 'professor']);
            $table->string('qualification')->nullable(); // PhD, Master, etc.
            $table->text('research_interests')->nullable();
            $table->string('office_location')->nullable();
            $table->text('office_hours')->nullable();
            $table->enum('status', ['active', 'inactive', 'retired'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_profiles');
    }
};
