-- Migration: add youtube_url column and youtube type to resources table
-- Run once against the foodfusion database

USE foodfusion;

-- 1. Extend the type ENUM to include youtube
ALTER TABLE resources
  MODIFY COLUMN type ENUM('pdf','video','image','infographic','youtube') NOT NULL DEFAULT 'pdf';

-- 2. Add youtube_url column (nullable — only populated for youtube-type resources)
ALTER TABLE resources
  ADD COLUMN youtube_url VARCHAR(500) DEFAULT NULL AFTER path;
