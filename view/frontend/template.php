<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <title><?= $title ?></title>
    <link href="public/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    <?php if (isset($css)) {
        echo $css;
    } ?>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
</head>



<body>
    <header>
        <a id="logo" href="index.php"> cdem.fun</a>
        <div id="connect">
        <div id="round"></div>
            <?php
            $PlayerManager = new PlayerManager();
            if ($PlayerManager->isConnected()) {
            ?>
                <a href="index.php?action=disconnect">Se déconnecter</a>
            <?php
            } else {
            ?>
                <a href="index.php?action=connect">Se connecter</a>
            <?php
            }
            ?>
        </div>
    </header>

    <div class="container">
        <?= $content ?>
    </div>

    <footer>

    </footer>
</body>
<?php if (isset($js)) {
    echo $js;
} ?>

</html>