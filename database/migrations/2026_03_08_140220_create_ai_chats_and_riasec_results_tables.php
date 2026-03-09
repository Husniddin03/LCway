<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // AI chat xabarlari
        Schema::create('ai_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['user', 'assistant']);
            $table->longText('content');
            $table->string('model')->default('deepseek/deepseek-r1');
            $table->timestamps();
        });

        // RIASEC test natijalari
        Schema::create('riasec_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('r_score')->default(0); // Realistic
            $table->unsignedTinyInteger('i_score')->default(0); // Investigative
            $table->unsignedTinyInteger('a_score')->default(0); // Artistic
            $table->unsignedTinyInteger('s_score')->default(0); // Social
            $table->unsignedTinyInteger('e_score')->default(0); // Enterprising
            $table->unsignedTinyInteger('c_score')->default(0); // Conventional
            $table->longText('ai_recommendation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riasec_results');
        Schema::dropIfExists('ai_chats');
    }
};