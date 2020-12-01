<?php

require_once 'model/model.php';

class Party extends Model
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
        $sql = 'INSERT INTO game(nbPlayers, nbMaxPlayers, scoreMax, isInProgress, isPublic, code)
            VALUES(:nbPlayers, :nbMaxPlayers, :scoreMax, :isInProgress, :isPublic, :code)';
        $params = array(
            'nbPlayers' => 0,
            'nbMaxPlayers' => $partySettings['nbMaxPlayers'],
            'scoreMax' => $partySettings['scoreMax'],
            'isInProgress' => 0,
            'isPublic' => $partySettings['isPublic'],
            'code' => $partySettings['code']
        );

        $this->executeQuery($sql, $params);

        $sql = 'SELECT idGame FROM game WHERE code=:codeGame';
        $params = array('codeGame' => $partySettings['code']);

        $result = $this->executeQuery($sql, $params);

        $idGame = $result->fetch();
        $_SESSION['idGame'] = intval($idGame['idGame']);
        $this->registerPlayer(intval($idGame['idGame']), 1);
    }


    /* Fonction qui enregistre un joueur dans une partie
    */
    function registerPlayer($idGame, $isHost)
    {
        $_SESSION['idGame'] = intval($idGame);

        require_once 'model/player.php';
        $Player = new Player();

        if ($Player->isConnected()) {
            $idPlayer =  $_SESSION['idPlayer'];
        } else {
            $idPlayer = $Player->createIdPlayer();
            $_SESSION['idPlayer'] =  $idPlayer;
        }

        $sql = 'INSERT INTO play(idGame, idPlayer, username, isHost)
            VALUES(:idGame, :idPlayer, :username, :isHost)';

        $params = array(
            'idGame' => intval($idGame),
            'idPlayer' => $idPlayer,
            'username' => $_COOKIE['username'],
            'isHost' => intval($isHost)
        );  
        $this->executeQuery($sql, $params);

        $this->updateNbPlayers(intval($idGame));
    }

    /* Fonction qui met à jour le nombre de joueurs
        Possibilité de faire un trigger
    */
    function updateNbPlayers($idGame)
    {
        $sql ='UPDATE game SET nbPlayers =(nbPlayers+1)
        WHERE idGame = :idGame';
        $params = array('idGame' => $idGame);
        $this->executeQuery($sql, $params);
    }

    /* Fonction qui vérifie qu'un code de partie n'existe pas déjà
    */
    function isAvailable($code)
    {
        $sql ='SELECT code FROM game';
        $result = $this->executeQuery($sql);

        while ($codeGame = $result->fetch()) {
            if ($codeGame == $code)
                return False;
        }
        return True;
    }

    /* Fonction qui récupère idGame en fonction de son code
    */
    function getIdGame($code)
    {
        $sql = 'SELECT * FROM game WHERE code = :code';
        $params = array('code' => $code);
        $result = $this->executeQuery($sql, $params);

        $game = $result->fetch();
        if (!$game)
            return 'Partie introuvable';
        if ($game['isInProgress'] == 1)
            return 'La partie a déjà commencé';
        if ($game['nbPlayers'] >= $game['nbMaxPlayers'])
            return 'La partie est complète';

        return intval($game['idGame']);
    }

    /* Fonction qui récupère un idGame d'une partie publique et non commencée
    */
    function getRandomIdGame()
    {
        $sql = 'SELECT * FROM game WHERE isPublic = 1 AND isInProgress = 0';
        $result = $this->executeQuery($sql);

        while ($game = $result->fetch()) {
            if (!$game)
                return 'Aucune partie n\'est disponible';
            if ($game['nbPlayers'] < $game['nbMaxPlayers'])
                return intval($game['idGame']);
        }
        return 'Aucune partie n\'est disponible';
    }
}
