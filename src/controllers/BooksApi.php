<?php

namespace Src\controllers;

use Framework\Error;
use Framework\MVC\Controller;
use Src\models\Book;

class BooksApi extends Controller
{
    public function addClick()
    {
        $bookId = $this->request->getJsonValue('id');

        if (!is_int($bookId)) {
            Error::responseJson(400);
            return;
        }

        $book = new Book();
        if ($book->addClick($bookId)) {
            echo json_encode(["id" => $bookId]);
            return;
        }
        Error::responseJson(400);
    }

    public function addView()
    {
        $bookId = $this->request->getJsonValue('id');

        if (!is_int($bookId)) {
            Error::responseJson(400);
            return;
        }

        $book = new Book();
        if ($book->addView($bookId)) {
            echo json_encode(["id" => $bookId]);
            return;
        }
        Error::responseJson(400);
    }

}