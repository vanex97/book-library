<?php

namespace Src\controllers;

use Framework\MVC\Controller;
use Framework\MVC\View;
use Src\models\Authors;
use Src\models\Book;
use Src\models\BookFormValidator;
use Src\models\BookImageUploader;
use Src\security\AdminBasicAuth;

class AdminController extends Controller
{
    /**
     * Maximum number of displayed books.
     */
    private const BOOKS_LIMIT = 10;

    public function __construct()
    {
        AdminBasicAuth::require_auth();
    }

    public function logout()
    {
        AdminBasicAuth::logout();
        echo 'You are logged out';
    }

    public function index()
    {
        $offset = (int) $this->request->getUriParam('offset');

        if ($offset < 0) {
            View::loadError(404);
            return;
        }

        $book = new Book();
        $quantity = $book->getQuantity();
        $books = $book->getBooks($offset, AdminController::BOOKS_LIMIT);

        View::load('admin.php', [
            'books' => $books,
            'offset' => $offset,
            'limit' => AdminController::BOOKS_LIMIT,
            'quantity' => $quantity
        ]);
    }

    /**
     * Adds a book and its authors via a form.
     */
    public function addBook()
    {
        // Check form.
        $authorsName = BookFormValidator::getAuthors($this->request);
        if ($authorsName === null || !BookFormValidator::checkRequiredKeys($this->request)) {
            View::loadError(404);
            return;
        }

        // Add book.
        $book = new Book();
        $bookImg = BookImageUploader::uploadImage();

        $bookId = $book->addBook(
            $this->request->getPostValue('name'),
            $this->request->getPostValue('year'),
            $this->request->getPostValue('pages_num'),
            $this->request->getPostValue('description'),
            $bookImg
        );

        // Add authors and links to the book.
        $author = new Authors();
        foreach ($authorsName as $authorName) {
            $authorId = $author->addAuthor($authorName);
            $book->addBookAuthor($bookId, $authorId);
        }

        $this->index();
    }

    /**
     * Soft delete book.
     */
    public function deleteBook()
    {
        $bookId = $this->request->getPostValue('id');
        if (!is_numeric($bookId)) {
            View::loadError(404);
            return;
        }

        $book = new Book();
        if (!$book->deleteBook((int) $bookId)) {
            View::loadError(404);
            return;
        }
        header('Location: /admin');
    }
}
