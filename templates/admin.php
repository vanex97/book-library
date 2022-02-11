<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
        Library Admin SHPP
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="library admin Sh++">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        #inserted_image {
            max-width: 350px;
            max-height: 110px;
        }
    </style>

    <link rel="shortcut icon" href="http://localhost:3000/book/favicon.ico">
</head>
<style>body {
        display: none
    }</style>
<nav class="navbar navbar-light bg-light">
    <div class="container-lg">
        <a class="navbar-brand">Library Admin</a>
        <a class="btn btn-secondary" href="/admin/logout">Exit</a>
    </div>
</nav>
<div class="container-lg">
    <div class="d-flex mt-2 justify-content-center flex-wrap row">
        <div class="col-xl-6">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Book_Name</th>
                    <th scope="col">Authors</th>
                    <th scope="col">Year</th>
                    <th scope="col">Action</th>
                    <th scope="col">Clicks</th>
                    <th scope="col">Views</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($books as $index => $book): ?>
                <tr class="<?php if ($index % 2 == 0) echo htmlspecialchars('table-light') ?>">
                    <td>
                        <a href="/book/<?php echo htmlspecialchars($book['id']) ?>" class="link-dark">
                            <?php echo htmlspecialchars($book['name']) ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($book['author_name']) ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($book['year']) ?></td>
                    <td>
                        <form action="/admin/deleteBook" method="post" onsubmit="return confirm('Are you sure?');">
                            <input name="id" required type="number" hidden="hidden"
                                   value="<?php echo htmlspecialchars($book['id']) ?>">
                            <button type="submit" class="btn btn-link btn-sm delete-button">Delete</button>
                        </form>
                    </td>
                    <td class="text-center"><?php echo htmlspecialchars((int)$book['click_num']) ?></td>
                    <td class="text-center"><?php echo htmlspecialchars((int)$book['view_num']) ?></td>
                </tr>
                </tbody>
                <?php endforeach; ?>
            </table>
            <?php include 'offset_number_pagination.php' ?>
        </div>
        <div class="col-lg-6">
            <form action="/admin" method="post" enctype="multipart/form-data" class="border">
                <fieldset>
                    <legend>Add book</legend>
                </fieldset>
                <div class="p-3 row">
                    <div class="col-xl-6 text-center">
                        <input name="name" required type="text" class="form-control mb-2" placeholder="Book Name">
                        <input name="year" type="number" class="form-control mb-2" placeholder="Year">
                        <input name="pages_num" type="number" class="form-control mb-2" placeholder="Number of pages">
                        <input name="image" class="form-control mb-2 img-input" type="file" accept="image/*"
                               id="formFile">
                    </div>
                    <div class="col-xl-6">
                        <input name="authors[]" required type="text" class="form-control mb-2"
                               placeholder="Author Name 1">
                        <input name="authors[]" type="text" class="form-control mb-2" placeholder="Author Name 2">
                        <input name="authors[]" type="text" class="form-control mb-2" placeholder="Author Name 3">
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                                  rows="3"></textarea>
                    </div>
                </div>
                <div class="d-flex p-3 justify-content-between">
                    <button type="submit" class="btn btn-primary">Add ></button>
                    <p>Leave fields blank if authors <3</p>
                </div>
            </form>
        </div>
    </div>
</div>
<style>body {
        display: block
    }</style>
<script src="public/scripts/admin.js"></script>
</div>
</html>