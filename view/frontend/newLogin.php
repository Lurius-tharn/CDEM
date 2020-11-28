<?php
if (isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['pwd']) and !empty($_POST['pwd']) and isset($_POST['pwdCheck']) and !empty($_POST['pwdCheck'])) {
    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['pwd'] = htmlspecialchars($_POST['pwd']);
    $_POST['pwdCheck'] = htmlspecialchars($_POST['pwdCheck']);
    if (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['email'])) { //vérification de la mise en forme de l'email

        if ($_POST['pwd'] == $_POST['pwdCheck']) { //vérification du mot de passe

            if (preg_match('#^(?=.{8,}$)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$#', $_POST['pwd'])) { //vérification de la force du mot de passe
                
                $PlayerManager = new PlayerManager();
                if ($PlayerManager->newPlayer($_POST['email'], $_POST['pwd'])) { //si l'email n'est pas déjà inscrite on l'inscrit
                    $PlayerManager->connectPlayer($_POST['email'], $_POST['pwd']);
                    header('Location: index.php');
                    exit;
                } else {
                    $_SESSION['registerError'] = 'Email déjà utilisé';
                    header('Location: index.php?action=connect');
                    exit;
                }
            } else {
                $_SESSION['registerError'] = 'Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 8 caractères';
                header('Location: index.php?action=connect');
                exit;
            }
        } else {
            $_SESSION['registerError'] = 'Les deux mot de passe ne sont pas identiques';
            header('Location: index.php?action=connect');
            exit;
        }
    } else {
        $_SESSION['registerError'] = 'Email invalide';
        header('Location: index.php?action=connect');
        exit;
    }
} else {
    header('Location: index.php?action=connect');
    exit;
}
