<?php
require_once("model/Manager.php");

class PlayerManager extends Manager
{
    /* Fonction qui enregistre un joueur dans la base de donnée
    */
    function newPlayer($email, $pwd)
    {
        $db = $this->dbConnect();
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $party_SearchEmail = $db->query('SELECT email FROM player');

        while ($emailPlayer = $party_SearchEmail->fetch()) {
            if (strcmp($emailPlayer['email'], $email) == 0) {
                return False;
            }
        }

        $party_InsertNewPlayer = $db->prepare('INSERT INTO player(email, pwd)
        VALUES(:email, :pwd)');

        $party_InsertNewPlayer->execute(array(
            'email' => $email,
            'pwd' => $hash
        ));
        return True;
    }

    /* Fonction qui connecte un joueur
    */
    function connectPlayer($email, $pwd)
    {
        $db = $this->dbConnect();
        $party_Search = $db->query('SELECT * FROM player');

        while ($Player = $party_Search->fetch()) {
            if (strcmp($Player['email'], $email) == 0) {
                if (password_verify($pwd, $Player['pwd'])) {
                    $_SESSION['isConnected'] = True;
                    $_SESSION['idPlayer'] = $Player['idPlayer'];
                    return True;
                }
                return False;
            }
        }
    }

    /* Fonction qui déconnecte un joueur
    */
    function disconnectPlayer()
    {
        if (isset($_SESSION['isConnected']) and !empty($_SESSION['isConnected']))
            unset($_SESSION['isConnected']);
        if (isset($_SESSION['idPlayer']) and !empty($_SESSION['idPlayer']))
            unset($_SESSION['idPlayer']);
    }

    /* Fonction qui vérifie si un joueur est connecté
    */
    function isConnected()
    {
        if (isset($_SESSION['isConnected']) and !empty($_SESSION['isConnected']))
            return $_SESSION['isConnected'];
        return False;
    }

    /* Fonction qui crée un IdPlayer pour un joueur non connecté
    */
    function createIdPlayer()
    {
        $db = $this->dbConnect();
        $party_Id = $db->query('SELECT idPlayer FROM player WHERE idPlayer = (SELECT MAX(idPlayer) FROM player)');
        $id = $party_Id->fetch();
        $id = intval($id);
        return ($id + 1000);
    }
}
