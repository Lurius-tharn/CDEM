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
        return $this->getParty($params['code']);
    }

    function getParty($code){
        $sql = 'SELECT * FROM game WHERE code=:codeGame';
        $params = array('codeGame' => $code);
        $result = $this->executeQuery($sql, $params)->fetch();
        return $result;
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

    /* Fonction qui récupère une partie publique et non commencée
    */
    function getRandomGame()
    {
        $sqlCount = 'SELECT count(*) as nb FROM game WHERE isPublic = 1 AND isInProgress = 0';
        $resultCount = $this->executeQuery($sqlCount)->fetch();
        if( !$resultCount || intval($resultCount['nb']) === 0){
            return false;
        }else{
            $numEnr = random_int(1, intval( $resultCount['nb']))-1;
            $sql = 'SELECT * FROM game WHERE isPublic = 1 AND isInProgress = 0 LIMIT 1 OFFSET '.$numEnr;
            $result = $this->executeQuery($sql)->fetch();
            return $result;
        }
    }

    // Fonction qui retourne tous les joueurs d'une partie
    function getPlayers($code){
        $idGame = $this->getIdGame($code);
        $sql = 'SELECT * FROM play WHERE idGame = :idGame';
        $params = array('idGame' => $idGame);
        $result = $this->executeQuery($sql, $params)->fetchAll();
        
        return $result;
    }

    // Fonction qui retourne le nombre maximum de joueurs d'une partie
    function getNbMaxPlayers($code){
        $sql = 'SELECT nbMaxPlayers FROM game WHERE code = :code';
        $params = array('code' => $code);
        $result = $this->executeQuery($sql, $params);
        
        $nb = $result->fetch();
        return intval($nb[0]);
    }

    // Fonction qui retourne le nombre de joueurs d'une partie
    function getNbPlayers($code){
        $sql = 'SELECT nbPlayers FROM game WHERE code = :code';
        $params = array('code' => $code);
        $result = $this->executeQuery($sql, $params);
    
        $nb = $result->fetch();
        return intval($nb[0]);
    }
}
