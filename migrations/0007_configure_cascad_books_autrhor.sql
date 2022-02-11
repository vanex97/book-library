ALTER TABLE authors_books
DROP FOREIGN KEY authors_books_ibfk_1;

ALTER TABLE authors_books
    ADD CONSTRAINT authors_books_ibfk_1
    FOREIGN KEY (author_id) REFERENCES authors(id)
    ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE authors_books
DROP FOREIGN KEY authors_books_ibfk_2;

ALTER TABLE authors_books
    ADD CONSTRAINT authors_books_ibfk_2
    FOREIGN KEY (book_id) REFERENCES books(id)
    ON DELETE CASCADE ON UPDATE RESTRICT;
