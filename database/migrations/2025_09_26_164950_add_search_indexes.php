<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Database Index Optimizations for SearchService
 * 
 * These indexes are REQUIRED for production-level performance
 * with 100k+ learning centers and related data.
 * 
 * Run this migration BEFORE deploying SearchService to production.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ==========================================================
        // learning_centers table indexes
        // ==========================================================
        Schema::table('learning_centers', function (Blueprint $table) {
            // Core search fields - individual indexes
            $table->index('name', 'idx_lc_name');
            $table->index('type', 'idx_lc_type');
            $table->index('tin', 'idx_lc_tin');
            $table->index('license_number', 'idx_lc_license');
            
            // Composite location index for geo + region filters
            $table->index(['region', 'province'], 'idx_lc_location');
            
            // Fulltext index for global search (MySQL 5.6+ required)
            // This enables FAST fulltext search on multiple columns
            $table->fullText(['name', 'address', 'region', 'province'], 'ft_lc_search');
            
            // Index for sorting by rating/favorites
            $table->index(['total_reyting', 'id'], 'idx_lc_rating_sort');
            $table->index(['created_at', 'id'], 'idx_lc_created_sort');
        });

        // ==========================================================
        // subjects_of_learning_centers table indexes
        // ==========================================================
        Schema::table('subjects_of_learning_centers', function (Blueprint $table) {
            // Critical for EXISTS queries on subject_name filter
            $table->index(['learning_centers_id', 'subject_name'], 'idx_solc_center_subject');
            
            // For filtering by subject name across all centers
            $table->index('subject_name', 'idx_solc_subject_name');
            
            // Fulltext for subject name search
            $table->fullText('subject_name', 'ft_solc_subject');
        });

        // ==========================================================
        // teachers table indexes
        // ==========================================================
        Schema::table('teachers', function (Blueprint $table) {
            // Critical for EXISTS queries on teacher name search
            $table->index(['learning_centers_id', 'name'], 'idx_teachers_center_name');
            
            // Fulltext for teacher name search
            $table->fullText('name', 'ft_teachers_name');
        });

        // ==========================================================
        // need_teacher table indexes
        // ==========================================================
        Schema::table('need_teacher', function (Blueprint $table) {
            // Critical for EXISTS queries on needTeachers filter
            $table->index(['learning_center_id', 'subject_name'], 'idx_nt_center_subject');
            
            // For sorting announcements by date
            $table->index(['learning_center_id', 'created_at'], 'idx_nt_center_created');
            
            // Fulltext for subject name and description search
            $table->fullText(['subject_name', 'description'], 'ft_nt_search');
        });

        // ==========================================================
        // teacher_subjects table indexes (for price filtering)
        // ==========================================================
        Schema::table('teacher_subjects', function (Blueprint $table) {
            // Critical for price range queries
            $table->index(['subject_id', 'price'], 'idx_ts_subject_price');
            
            // Composite for teacher + price queries
            $table->index(['teacher_id', 'price'], 'idx_ts_teacher_price');
        });

        // ==========================================================
        // favorites table indexes (for withCount performance)
        // ==========================================================
        Schema::table('favorites', function (Blueprint $table) {
            // Critical for fast favorites count
            $table->index(['learning_centers_id', 'rating'], 'idx_fav_center_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // learning_centers
        Schema::table('learning_centers', function (Blueprint $table) {
            $table->dropIndex('idx_lc_name');
            $table->dropIndex('idx_lc_type');
            $table->dropIndex('idx_lc_tin');
            $table->dropIndex('idx_lc_license');
            $table->dropIndex('idx_lc_location');
            $table->dropFullText('ft_lc_search');
            $table->dropIndex('idx_lc_rating_sort');
            $table->dropIndex('idx_lc_created_sort');
        });

        // subjects_of_learning_centers
        Schema::table('subjects_of_learning_centers', function (Blueprint $table) {
            $table->dropIndex('idx_solc_center_subject');
            $table->dropIndex('idx_solc_subject_name');
            $table->dropFullText('ft_solc_subject');
        });

        // teachers
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropIndex('idx_teachers_center_name');
            $table->dropFullText('ft_teachers_name');
        });

        // need_teacher
        Schema::table('need_teacher', function (Blueprint $table) {
            $table->dropIndex('idx_nt_center_subject');
            $table->dropIndex('idx_nt_center_created');
            $table->dropFullText('ft_nt_search');
        });

        // teacher_subjects
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->dropIndex('idx_ts_subject_price');
            $table->dropIndex('idx_ts_teacher_price');
        });

        // favorites
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropIndex('idx_fav_center_rating');
        });
    }
};
