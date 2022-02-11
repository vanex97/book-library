<?php

namespace Src\controllers;

use Framework\MVC\Controller;
use Framework\MVC\View;
use Src\models\Book;
use Src\models\BookImageUploader;

class BooksController extends Controller
{

    /**
     * Maximum number of displayed books.
     */
    private const BOOKS_LIMIT = 18;

    public function index()
    {
        $search = $this->request->getUriParam('search');
        $offset = (int) $this->request->getUriParam('offset');

        if ($offset < 0) {
            View::loadError(404);
            return;
        }

        $book = new Book();
        if (!is_null($search)) {
            $quantity = $book->getSearchQuantity($_GET['search']);
            $books = $book->searchBooks($offset, self::BOOKS_LIMIT, $_GET['search']);
        } else {
            $quantity = $book->getQuantity();
            $books = $book->getBooks($offset, self::BOOKS_LIMIT);
        }

        if (is_null($search) && !$books) {
            View::loadError(404);
            return;
        }

        View::load('books-page.php', [
            'books' => $books,
            'imgFolder' => BookImageUploader::IMG_FOLDER,
            'search' => $search,
            'offset' => $offset,
            'limit' => self::BOOKS_LIMIT,
            'quantity' => $quantity
        ]);
    }

    public function book($book_id)
    {
        $book = new Book();
        $bookEntity = $book->getById($book_id);
        if ($bookEntity === null) {
            View::loadError(404);
            return;
        }
        $bookEntity['imgFolder'] = BookImageUploader::IMG_FOLDER;

        View::load('book-page.php', $bookEntity);
    }
}