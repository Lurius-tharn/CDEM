<?php
if (isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['pwd']) and !empty($_POST['pwd'])) {
    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['pwd'] = htmlspecialchars($_POST['pwd']);

    $PlayerManager = new PlayerManager();
    if ($PlayerManager->connectPlayer($_POST['email'], $_POST['pwd'])) {
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['connectError'] = 'Email ou mot de passe incorrect';
        header('Location: index.php?action=connect');
        exit;
    }
} else {
    header('Location: index.php?action=connect');
    exit;
}
