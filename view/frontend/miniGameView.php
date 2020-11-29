<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <title><?= $title ?></title>
    <link href="public/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
</head>



<body>
    <header>
        <a id="logo" href="/CDEM"> cdem.fun</a>
    </header>

    <div class="container">
        <?= $content ?>
    </div>

    <footer>
    </footer>

</body>


</html>