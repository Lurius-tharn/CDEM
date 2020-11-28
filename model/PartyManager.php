<?php
require_once("model/Manager.php");

class PartyManager extends Manager
{
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
        $party_InsertQuery = $db->prepare('INSERT INTO game(nbPlayers, nbMaxPlayers, scoreMax, isInProgress, isPublic, code)
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
        $this->registerPlayer($idGame, 1);
    }


    /* Fonction qui enregistre un joueur dans une partie
    */
    function registerPlayer($idGame, $isHost)
    {
        $db = $this->dbConnect();

        $PlayerManager = new PlayerManager();
        if ($PlayerManager->isConnected()) {
            $idPlayer =  $_SESSION['idPlayer'];
        } else {
            $idPlayer = $PlayerManager->createIdPlayer();
            $_SESSION['idPlayer'] =  $idPlayer;
        }

        $party_InsertQuery = $db->prepare('INSERT INTO play(idGame, idPlayer, username, isHost)
            VALUES(:idGame, :idPlayer, :username, :isHost)');

        $party_InsertQuery->execute(array(
            'idGame' => intval($idGame),
            'idPlayer' => $idPlayer,
            'username' => $_COOKIE['username'],
            'isHost' => intval($isHost)
        ));
    }

    /* Fonction qui met à jour le nombre de joueurs
        Possibilité de faire un trigger
    */
    function updateNbPlayers($partyId)
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
