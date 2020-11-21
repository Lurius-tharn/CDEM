<?php
function connectView(){
    require('view/frontend/connectView.php');

}
function homeView(){
    require('view/frontend/homeView.php');

}
function createView(){
    require('view/frontend/createView.php');

}
function joinView(){
    require('view/frontend/joinView.php');

}
 
 function CreatePartyView()
{
    echo $_POST['Titre'];
   require('view/frontend/Game.php');
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