ALTER TABLE books ALTER COLUMN click_num SET DEFAULT 0;
ALTER TABLE books ALTER COLUMN view_num SET DEFAULT 0;
ALTER TABLE books ALTER COLUMN is_deleted SET DEFAULT 0;

UPDATE books SET click_num=0 WHERE click_num IS NULL;
UPDATE books SET view_num=0 WHERE view_num IS NULL;
UPDATE books SET is_deleted=0 WHERE is_deleted IS NULL;