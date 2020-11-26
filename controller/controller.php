<?php
require_once('model/PartyManager.php');

function connectView(){
    require('view/frontend/connectView.php');

}
function homeView(){
    require('view/frontend/homeView.php');

}
function createView(){
  
    $_SESSION['pseudo'] = $_GET['pseudo'];
    if (isset($_SESSION['pseudo']) AND !empty($_SESSION['pseudo'])) {
        require('view/frontend/createView.php');

    }else {
        homeView();
    }

}
function PartySettingsView($page){
    $PartyManager = new PartyManager();
    $_SESSION['pseudo'] = $_GET['pseudo'];
    if (isset($_SESSION['pseudo']) AND !empty($_SESSION['pseudo'])) {
        $createPlayer = $PartyManager-> createPlayer($_SESSION['pseudo']);
        if($page=='create')
        require('view/frontend/createView.php');

        if($page=='join')
        require('view/frontend/joinView.php');

    }else {
        homeView();
    }

}
 
/* Foction qui appelle la page d'attente après la création de partie de l'hôte
    Ajout de la partie dans la base de données
    redirection vers la fonction WaitView quand la partie sera créer(à voir).
*/
 function CreatePartyView()
{
  
    $PartyManager = new PartyManager();
    $isPublic =0;
    $code='';
    $idHost= $PartyManager->getIdHost($_SESSION['pseudo']);
    
    if (($_POST["boolParty"] =='Privé')){
        $isPublic =0;
        $code=generateRandomString();
    
    }else if ($_POST["boolParty"]=='Public') {
        $isPublic =1;
    }
    
    $party = array (
        'idHost'=> $idHost,
        'nbMaxPlayers'=> $_POST['Players'],
        'scoreMax'=> $_POST['Score'], 
        'isPublic'=> $isPublic, 
        'code'=> $code
    );
    $Party = $PartyManager->createParty($party);

  echo 'ajouté a la base de données';
    
   
      
}

/*
Fonction pour générer un code de partiealéatoire

*/ 

function generateRandomString($length = 6) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}