<?php session_start();

try{
    if(existe()){
        if(correct()){
            $_SESSION['connecté']=true;
            $_SESSION['pseudo']=$_POST['pseudo'];
            header('Location: homeview.php');
        } else
            header('Location: se connecter.php?incorrect=0');
    } else
        header('Location: se connecter.php?incorrect=1');
} catch (Exception $e){
    die("ça n'a pas marché");
}

function existe(){
    $bdd = new PDO(/*infos de la base de données*/);
    $infos = $bdd->prepare("SELECT COUNT(id) FROM clients WHERE pseudo=?");
    $infos->execute(array($_POST['pseudo']));
    return $infos->fetch()['COUNT(id)']>0;
}

function correct(){
    $bdd = new PDO(/*infos de la base de données*/);
    $infos = $bdd->prepare("SELECT mdp FROM clients WHERE pseudo=?");
    $infos->execute(array($_POST['pseudo']));
    return $infos->fetch()['mdp']==$_POST['mdp'];
}

?>