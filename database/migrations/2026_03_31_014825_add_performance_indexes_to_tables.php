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
        // Learning centers table indexes
        Schema::table('learning_centers', function (Blueprint $table) {
            $table->index(['status', 'created_at']); // For filtering active courses
            $table->index(['type', 'status']); // For filtering by type and status
            $table->index(['province', 'region']); // For location-based searches
            $table->index('rating'); // For sorting by rating
            $table->index('created_at'); // For ordering
        });

        // Teachers table indexes
        Schema::table('teachers', function (Blueprint $table) {
            $table->index('learning_centers_id'); // Foreign key lookup
            $table->index('subject_id'); // For filtering by subject
        });

        // Subjects table indexes
        Schema::table('subjects', function (Blueprint $table) {
            $table->index('name'); // For subject searches
            $table->index('type'); // For filtering by type
        });

        // Subjects of learning centers table indexes
        Schema::table('subjects_of_learning_centers', function (Blueprint $table) {
            $table->index(['learning_centers_id', 'subject_id']); // Composite index for lookups
            $table->index('price'); // For price filtering
        });

        // Learning centers images table indexes
        Schema::table('learning_centers_images', function (Blueprint $table) {
            $table->index('learning_centers_id'); // Foreign key lookup
            $table->index(['learning_centers_id', 'is_primary']); // For finding primary image
        });

        // Learning centers comments table indexes
        Schema::table('learning_centers_comments', function (Blueprint $table) {
            $table->index('learning_centers_id'); // Foreign key lookup
            $table->index(['learning_centers_id', 'created_at']); // For comment ordering
        });

        // Favorites table indexes
        Schema::table('favorites', function (Blueprint $table) {
            $table->index(['users_id', 'learning_centers_id']); // Composite for user favorites
            $table->index('learning_centers_id'); // For popularity queries
        });

        // Chat sessions table indexes
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->index('users_id'); // For user session lookups
            $table->index('created_at'); // For session ordering
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_centers', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['type', 'status']);
            $table->dropIndex(['province', 'region']);
            $table->dropIndex('rating');
            $table->dropIndex('created_at');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropIndex('learning_centers_id');
            $table->dropIndex('subject_id');
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->dropIndex('name');
            $table->dropIndex('type');
        });

        Schema::table('subjects_of_learning_centers', function (Blueprint $table) {
            $table->dropIndex(['learning_centers_id', 'subject_id']);
            $table->dropIndex('price');
        });

        Schema::table('learning_centers_images', function (Blueprint $table) {
            $table->dropIndex('learning_centers_id');
            $table->dropIndex(['learning_centers_id', 'is_primary']);
        });

        Schema::table('learning_centers_comments', function (Blueprint $table) {
            $table->dropIndex('learning_centers_id');
            $table->dropIndex(['learning_centers_id', 'created_at']);
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropIndex(['users_id', 'learning_centers_id']);
            $table->dropIndex('learning_centers_id');
        });

        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropIndex('users_id');
            $table->dropIndex('created_at');
        });
    }
};
