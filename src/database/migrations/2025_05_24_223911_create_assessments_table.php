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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('github_repository')->nullable();
            $table->string('score')->nullable();
            $table->enum('status', ['ongoing', 'passed', 'failed'])->default('ongoing'); // pending, passed, failed
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('modules_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
