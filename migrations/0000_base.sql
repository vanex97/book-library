CREATE TABLE books
(
    id          INT UNSIGNED AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    author      VARCHAR(100),
    year        INT(4),
    pages_num   INT(4),
    description VARCHAR(512),
    click_num   INT,
    img         VARCHAR(100),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS version
(
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(100),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
