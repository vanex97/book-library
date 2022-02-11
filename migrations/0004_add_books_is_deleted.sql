ALTER TABLE books
    ADD is_deleted INT UNSIGNED
        AFTER click_num;