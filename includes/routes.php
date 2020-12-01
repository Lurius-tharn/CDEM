<?php
// Déclaration de la page d'accueil
$fmk->initIndexRoute("home", "", "homeController.php");

//cette ligne crée une route les arguments sont le nom, l'adresse lisible, le chemin vers le contrôleur et l'action
$fmk->initRoute("createParty", "create-party", "partyController.php", "create/");
$fmk->initRoute("joinParty", "join-party", "partyController.php", "join/");
$fmk->initRoute("delete-username", "delete-username", "partyController.php", "deleteUsername");

$fmk->initRoute("connect", "connect", "playerController.php", "connect");
$fmk->initRoute("disconnect", "disconnect", "playerController.php", "disconnect");
$fmk->initRoute("forgotten-password", "forgotten-password", "playerController.php", "forgottenPassword");

$fmk->initRoute("create-room", "create-room", "partyController.php", "createRoom");
$fmk->initRoute("join-room", "join-room", "partyController.php", "joinRoom");
