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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('type'); // 'user_created', 'center_created', 'teacher_added', 'comment_added', etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->morphs('subject'); // subject_type, subject_id - for polymorphic relation
            $table->json('metadata')->nullable(); // additional data
            $table->date('activity_date'); // for heatmap grouping
            $table->timestamps();
            
            $table->index('activity_date');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
