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
        Schema::create('leads', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $blueprint->string('first_name');
            $blueprint->string('last_name');
            $blueprint->string('email');
            $blueprint->integer('quiz_result_score')->nullable();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
