<?php

namespace Src\models;

use Framework\Database;
use Framework\MVC\Model;
use PDO;
use PDOException;

class Book
{
    private ?PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPDO();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        $sth = $this->pdo->prepare('
            SELECT books.id, books.name, books.year, books.description, books.img, books.pages_num, authors.name AS author_name FROM books 
            LEFT JOIN authors_books ON authors_books.book_id = books.id
            LEFT JOIN authors ON authors_books.author_id = authors.id
            WHERE books.id=:id
        ');
        $sth->execute([
            'id' => $id
        ]);

        $res = $sth->fetchAll();
        return (isset($res[0])) ? $res[0] : null;
    }

    /**
     * @param $name
     * @param $year
     * @param null $pages_num
     * @param null $description
     * @param null $img
     * @return string
     */
    public function addBook($name, $year, $pages_num = null, $description = null, $img = null): string
    {
        $sth = $this->pdo->prepare("
            INSERT INTO books(name, year, pages_num, description, img)
            VALUES (:name, :year, :pages_num, :description, :img)
        ");
        $sth->execute([
            'name' => $name,
            'year' => (int)$year,
            'pages_num' => $pages_num,
            'description' => $description,
            'img' => $img
        ]);

        return $this->pdo->lastInsertId();
    }

    /**
     * @param $bookId
     * @param $authorId
     */
    public function addBookAuthor($bookId, $authorId)
    {
        $sth = $this->pdo->prepare("
            INSERT INTO authors_books (book_id, author_id)
            VALUES (:bookId, :authorId)
        ");
        $sth->execute([
            'bookId' => $bookId,
            'authorId' => $authorId
        ]);
    }

    /**
     * @param $offset
     * @param $limit
     * @return bool|array
     */
    public function getBooks($offset, $limit): bool|array
    {
        try {
            $sth = $this->pdo->prepare("
                SELECT books.id, books.name, books.img, books.year, books.click_num, books.view_num, 
                    GROUP_CONCAT(authors.name SEPARATOR ', ') AS author_name 
                FROM books
                LEFT JOIN authors_books ON authors_books.book_id = books.id
                LEFT JOIN authors ON authors_books.author_id = authors.id
                WHERE books.is_deleted = 0
                GROUP BY books.id 
                ORDER BY books.id DESC
                LIMIT :limit OFFSET :offset
            ");
            $sth->bindValue(':limit', $limit, $this->pdo::PARAM_INT);
            $sth->bindValue(':offset', $offset, $this->pdo::PARAM_INT);
            $sth->execute();
            return $sth->fetchAll();
        } catch (PDOException) {
            return [];
        }
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        try {
            return $this->pdo->query('SELECT COUNT(*) FROM books WHERE books.is_deleted = 0')->fetchColumn();
        } catch (PDOException) {
            return 0;
        }
    }

    /**
     * @param $offset
     * @param $limit
     * @param $search
     * @return bool|array
     */
    public function searchBooks($offset, $limit, $search): bool|array
    {
        $sth = $this->pdo->prepare("
            SELECT books.id, books.name, books.img, authors.name AS author_name FROM books
            LEFT JOIN authors_books ON authors_books.book_id = books.id
            LEFT JOIN authors ON authors_books.author_id = authors.id
            WHERE books.name LIKE :search AND books.is_deleted = 0
            LIMIT :limit OFFSET :offset
        ");
        $sth->bindValue(':limit', $limit, $this->pdo::PARAM_INT);
        $sth->bindValue(':offset', $offset, $this->pdo::PARAM_INT);
        $sth->bindValue('search', "%$search%");
        $sth->execute();
        return $sth->fetchAll();
    }

    /**
     * @param $search
     * @return mixed
     */
    public function getSearchQuantity($search): mixed
    {
        $sth = $this->pdo->prepare('SELECT COUNT(*) FROM books WHERE name LIKE :search AND books.is_deleted = 0');
        $sth->execute([
            'search' => "%$search%"
        ]);
        return $sth->fetchColumn();
    }

    /**
     * @param $bookId
     * @return int
     */
    public function deleteBook($bookId): int
    {
        $sth = $this->pdo->prepare('UPDATE books SET is_deleted = 1 WHERE id = :id');
        $sth->execute([
            'id' => $bookId
        ]);
        return $sth->rowCount();
    }

    /**
     * @param $id
     * @return int
     */
    public function addClick($id): int
    {
        $sth = $this->pdo->prepare('UPDATE books SET click_num = click_num + 1 WHERE id = :id');
        $sth->execute([
            'id' => $id
        ]);
        return $sth->rowCount();
    }

    /**
     * @param $id
     * @return int
     */
    public function addView($id): int
    {
        $sth = $this->pdo->prepare('UPDATE books SET view_num = view_num + 1 WHERE id = :id');
        $sth->execute([
            'id' => $id
        ]);
        return $sth->rowCount();
    }

}