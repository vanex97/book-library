ALTER TABLE books
    DROP author;

CREATE TABLE authors
(
    id   INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(40) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE authors_books
(
    author_id INT UNSIGNED,
    book_id   INT UNSIGNED,
    FOREIGN KEY (author_id) REFERENCES authors (id),
    FOREIGN KEY (book_id) REFERENCES books (id)
);