<?php
require_once('model/PartyManager.php');
require_once('model/PlayerManager.php');

function connectView()
{
    require('view/frontend/connectView.php');
}
function checkLogin()
{
    require('view/frontend/checkLogin.php');
}
function newLogin()
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
    redirection vers la fonction WaitView quand la partie sera créée(à voir).
*/
function createWaitingRoomView()
{
    if (isset($_POST['boolParty']) and !empty($_POST['boolParty']) and isset($_POST['Players']) and !empty($_POST['Players']) and isset($_POST['Score']) and !empty($_POST['Score'])) {

        $_POST['boolParty'] = htmlspecialchars($_POST['boolParty']);
        $_POST['Players'] = htmlspecialchars($_POST['Players']);
        $_POST['Score'] = htmlspecialchars($_POST['Score']);

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
Fonction pour générer un code de partie aléatoire

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


function joinWaitingRoomView()
{
    $PartyManager = new PartyManager();

    if (isset($_POST['code']) and !empty($_POST['code'])) {

        $_POST['code'] = htmlspecialchars($_POST['code']);
        $id = $PartyManager->getIdGame($_POST['code']);

        if (is_int($id)) {
            $PartyManager->registerPlayer($id, 0);
            require('view/frontend/waitingRoomView.php');
        } else {
            $_SESSION['joinError'] = $id;
            joinView();
        }
    } else {

        $id = $PartyManager->getRandomIdGame();

        if (is_int($id)) {
            $PartyManager->registerPlayer($id, 0);
            require('view/frontend/waitingRoomView.php');
        } else {
            $_SESSION['joinError'] = $id;
            joinView();
        };
    }
}
