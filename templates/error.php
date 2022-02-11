<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page not found</title>
    <link rel="stylesheet" href="/public/style/error.css">
</head>
<body>
<div class="container">
    <div class="copy-container center-xy">
        <p>
            <?php echo htmlspecialchars("$errorCode $errorText") ?>
        </p>

    </div>
</div>
</body>
</html>

