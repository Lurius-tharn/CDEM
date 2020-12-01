<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <title><?= $title ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
    <base href="/CDEM/";>
    <link href="public/css/style.css" rel="stylesheet" />
    <?php if (isset($css)) {
        echo $css;
    } ?>
</head>

<body>
    <header>
        <a id="logo" href="/CDEM"> cdem.fun</a>
        <div id="connect">
            <div id="round"></div>
            <?php
            if ($connected) {
            ?>
                <a href="disconnect">Se déconnecter</a>
            <?php
            } else {
            ?>
                <a href="connect">Se connecter</a>
            <?php
            }
            ?>
        </div>
    </header>