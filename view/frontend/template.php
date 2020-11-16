<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link href="public/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>



<body>
    <header>
        <a id="logo" href="index.php"> cdem.fun</a>
        <div id="connect">
            <div id="round"></div>
            <a href="Connect.php">Se connecter</a>       
        </div>
    </header>

    <div class="container">
        <?= $content ?>
    </div>

    <footer>

    </footer>
</body>

</html>