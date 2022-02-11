<?php

use Framework\Routing\Router;
use Framework\Routing\Request;

include_once '../vendor/autoload.php';

$router = new Router(new Request());

$router->get('/', 'BooksController', 'index');
$router->get('/book/{book_id}', 'BooksController', 'book');
$router->get('/admin', 'AdminController', 'index');
$router->post('/admin', 'AdminController', 'addBook');
$router->get('/admin/logout', 'AdminController', 'logout');
$router->post('/admin/deleteBook', 'AdminController', 'deleteBook');

// API
$router->post('/api/v1/addClick', 'BooksApi', 'addClick');
$router->post('/api/v1/addView', 'BooksApi', 'addView');
