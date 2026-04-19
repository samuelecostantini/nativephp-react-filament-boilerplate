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
        Schema::create('questions', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('quiz_id')->constrained()->cascadeOnDelete();
            $blueprint->text('text');
            $blueprint->integer('order')->default(0);
            $blueprint->string('type')->default('single_choice');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
