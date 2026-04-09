-- ============================================================================
-- Database Index Optimization for Learning Center Search
-- Run this SQL to optimize search performance
-- ============================================================================

-- learning_centers table indexes
ALTER TABLE learning_centers ADD INDEX idx_lc_name (name);
ALTER TABLE learning_centers ADD INDEX idx_lc_type (type);
ALTER TABLE learning_centers ADD INDEX idx_lc_region (region);
ALTER TABLE learning_centers ADD INDEX idx_lc_province (province);
ALTER TABLE learning_centers ADD INDEX idx_lc_status (status);
ALTER TABLE learning_centers ADD INDEX idx_lc_location (region, province);
ALTER TABLE learning_centers ADD INDEX idx_lc_type_region_status (type, region, status);

-- Full-text indexes (requires MySQL 5.6+ or MariaDB 10.0.5+)
-- Only run if your database supports full-text search
-- ALTER TABLE learning_centers ADD FULLTEXT ft_lc_name_address (name, address);
-- ALTER TABLE learning_centers ADD FULLTEXT ft_lc_region_province (region, province);

-- subjects_of_learning_centers table indexes
ALTER TABLE subjects_of_learning_centers ADD INDEX idx_slc_center_subject (learning_centers_id, subject_name);
ALTER TABLE subjects_of_learning_centers ADD INDEX idx_slc_subject_name (subject_name);
-- ALTER TABLE subjects_of_learning_centers ADD FULLTEXT ft_slc_subject_name (subject_name);

-- teachers table indexes
ALTER TABLE teachers ADD INDEX idx_teachers_center_name (learning_centers_id, name);
ALTER TABLE teachers ADD INDEX idx_teachers_name (name);

-- need_teacher table indexes
ALTER TABLE need_teacher ADD INDEX idx_nt_center_subject (learning_center_id, subject_name);
ALTER TABLE need_teacher ADD INDEX idx_nt_subject_name (subject_name);
ALTER TABLE need_teacher ADD INDEX idx_nt_created_at (created_at);

-- teacher_subjects table indexes (for price filtering)
ALTER TABLE teacher_subjects ADD INDEX idx_ts_subject_price (subject_id, price);
ALTER TABLE teacher_subjects ADD INDEX idx_ts_price (price);

-- favorites table indexes (for rating calculations)
ALTER TABLE favorites ADD INDEX idx_fav_center_rating (learning_centers_id, rating);
ALTER TABLE favorites ADD INDEX idx_fav_user_center (users_id, learning_centers_id);

-- ============================================================================
-- ANALYZE TABLES to update statistics after indexing
-- ============================================================================

ANALYZE TABLE learning_centers;
ANALYZE TABLE subjects_of_learning_centers;
ANALYZE TABLE teachers;
ANALYZE TABLE need_teacher;
ANALYZE TABLE teacher_subjects;
ANALYZE TABLE favorites;

-- ============================================================================
-- Verify indexes were created
-- ============================================================================

SHOW INDEX FROM learning_centers;
SHOW INDEX FROM subjects_of_learning_centers;
SHOW INDEX FROM teachers;
SHOW INDEX FROM need_teacher;
SHOW INDEX FROM teacher_subjects;
SHOW INDEX FROM favorites;
