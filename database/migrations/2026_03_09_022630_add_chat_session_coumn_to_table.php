<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eski ai_chats ga session_id ustuni qo'shamiz
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->default('Yangi suhbat');
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->unsignedSmallInteger('message_count')->default(0);
            $table->timestamps();
        });

        // Eski ai_chats ga session qo'shish (agar mavjud bo'lsa alter, aks holda create)
        if (Schema::hasTable('ai_chats')) {
            Schema::table('ai_chats', function (Blueprint $table) {
                $table->foreignId('session_id')
                      ->nullable()
                      ->after('user_id')
                      ->constrained('chat_sessions')
                      ->onDelete('cascade');
            });
        } else {
            Schema::create('ai_chats', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('session_id')->constrained('chat_sessions')->onDelete('cascade');
                $table->enum('role', ['user', 'assistant']);
                $table->longText('content');
                $table->string('model')->default('deepseek/deepseek-r1');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ai_chats', 'session_id')) {
            Schema::table('ai_chats', function (Blueprint $table) {
                $table->dropForeign(['session_id']);
                $table->dropColumn('session_id');
            });
        }
        Schema::dropIfExists('chat_sessions');
    }
};