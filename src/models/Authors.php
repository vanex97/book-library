<?php

namespace Src\models;

use Framework\Database;
use Framework\MVC\Model;

class Authors
{
    private ?\PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPDO();
    }

    /**
     * @param $name
     * @return string
     */
    public function addAuthor($name): string
    {
        $sth = $this->pdo->prepare("
            INSERT INTO authors (name) VALUES (:name)
        ");
        $sth->execute([
            'name' => $name
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
     * @param $name
     * @return array|null
     */
    public function authorByName($name): ?string
    {
        $sth = $this->pdo->prepare("
            SELECT * FROM authors WHERE name LIKE :name
        ");
        $sth->execute([
            'name' => "%$name%"
        ]);
        $author = $sth->fetchAll();
        if (empty($author)) return null;
        return $author;
    }

    /**
     * @param $authorId
     * @param $bookId
     */
    public function addAuthorBook($authorId, $bookId)
    {
        $sth = $this->pdo->prepare("
            INSERT INTO authors_books (author_id, book_id)
            VALUES (:authorId, :bookId)
        ");
        $sth->execute([
            'authorId' => $authorId,
            'bookId' => $bookId
        ]);
    }
}