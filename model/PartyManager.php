<?php
require_once("model/Manager.php");

class PartyManager extends Manager
{

    /* Fonction qui enregistre un joueur dans une partie
    */
    function registerPlayer($idGame)
    {
        $db = $this->dbConnect();
    }

    /* Fonction qui enregistre un joueur dans la base de donnée
    */
    function newPlayer($email, $hash)
    {
        $db = $this->dbConnect();
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
                if(password_verify($pwd, $Player['pwd'])){
                    return True;
                }
                return False;
            }
        }
    }


    /* Fonction qui crée la Partie(à partir de la page createView) 
        prends en paramètre un tableau comprenant:
            le numéro de l'hote(le numéro qui sera attribué au joueur en page d'acceuil)
            le nombre de joueurs(qui sera mis a jour, 1 au départ),
            le nombre de joueurs max(si le nombre de joueurs max est atteint la party se lance)
            le score max,
            si la partie est en cours(si non, elle est arrété),
            si la partie est en public,
            si oui, le code

    */
    function createParty($partySettings)
    {
        $db = $this->dbConnect();
        $party_InsertQuery = $db->prepare('INSERT INTO game(nbPlayers,nbMaxPlayers,scoreMax,isInProgress,isPublic,code)
            VALUES(:nbPlayers, :nbMaxPlayers, :scoreMax, :isInProgress, :isPublic, :code)');
        $party_InsertQuery->execute(array(
            'nbPlayers' => 1,
            'nbMaxPlayers' => $partySettings['nbMaxPlayers'],
            'scoreMax' => $partySettings['scoreMax'],
            'isInProgress' => 0,
            'isPublic' => $partySettings['isPublic'],
            'code' => $partySettings['code']
        ));

        $party_GetId = $db->prepare('SELECT idGame FROM game WHERE code=:codeGame');
        $party_GetId->execute(array('codeGame' => $partySettings['code']));
        $idGame = $party_GetId->fetch();
        $_SESSION['idGame'] = $idGame;
    }


    /* Fonction qui met à jour le nombre de joueurs
        Possibilité de faire un trigger
    */
    function updatenbPlayers($partyId)
    {
        $db = $this->dbConnect();
        $party_UpdateQuery = $db->prepare('UPDATE party SET nbPlayers =(nbPlayers+1)
        WHERE idGame = :idGame');
        $party_UpdateQuery->execute(array('idGame' => $partyId));
    }

    /* Fonction qui vérifie qu'un code de partie n'existe pas déjà
    */
    function isAvailable($code)
    {
        $db = $this->dbConnect();
        $party_GetCode = $db->query('SELECT code FROM game');

        while ($codeGame = $party_GetCode->fetch()) {
            if ($codeGame == $code)
                return False;
        }
        return True;
    }
}
