<?php
require_once('model/PartyManager.php');

function connectView()
{
    require('view/frontend/connectView.php');
}
function checkLogin()
{
    require('view/frontend/checkLogin.php');
}function newLogin()
{
    require('view/frontend/newLogin.php');
}
function forgottenPwd()
{
    require('view/frontend/forgottenPwd.php');
}

function homeView()
{
    require('view/frontend/homeView.php');
}

function createView()
{
    require('view/frontend/createView.php');
}

function joinView()
{
    require('view/frontend/joinView.php');
}

/* Fonction qui appelle la page d'attente après la création de partie de l'hôte
    Ajout de la partie dans la base de données
    redirection vers la fonction WaitView quand la partie sera créer(à voir).
*/
function waitingRoomView()
{
    if (isset($_POST['boolParty']) and !empty($_POST['boolParty']) and isset($_POST['Players']) and !empty($_POST['Players']) and isset($_POST['Score']) and !empty($_POST['Score'])) {

        $PartyManager = new PartyManager();
        $isPublic = 0;

        if (($_POST['boolParty'] == 'Privé')) {
            $isPublic = 0;
        } else if ($_POST['boolParty'] == 'Public') {
            $isPublic = 1;
        }

        $party = array(
            'nbMaxPlayers' => $_POST['Players'],
            'scoreMax' => $_POST['Score'],
            'isPublic' => $isPublic,
            'code' => generateRandomString()
        );
        $PartyManager->createParty($party);
        require('view/frontend/waitingRoomView.php');
    } else {
        createView();
    }
}

/*
Fonction pour générer un code de partiealéatoire

*/

function generateRandomString($length = 6)
{
    $PartyManager = new PartyManager();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    do {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
    } while (!$PartyManager->isAvailable($randomString));
    return $randomString;
}
