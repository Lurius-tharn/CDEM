<?php

require_once 'model/model.php';

class Game extends Model
{
    /* Fonction qui crée la Partie(à partir de la page createView) 
        prends en paramètre un tableau comprenant:
            le numéro de l'hote(le numéro qui sera attribué au joueur en page d'acceuil)
            le nombre de joueurs(qui sera mis a jour, 1 au départ),
            le score max,
            si la partie est en cours(si non, elle est arrété),
            si la partie est en public,
            si oui, le code

    */
    public function createGame($gameSettings)
    {
        $sql = 'INSERT INTO game(code, nbMaxPlayers, scoreMax, isInProgress, isPublic)
            VALUES(:code, :nbMaxPlayers, :scoreMax, :isInProgress, :isPublic)';
        $params = array(
            'code' => $gameSettings['code'],
            'nbMaxPlayers' => $gameSettings['nbMaxPlayers'],
            'scoreMax' => $gameSettings['scoreMax'],
            'isInProgress' => 0,
            'isPublic' => $gameSettings['isPublic'],
        );
        $this->executeQuery($sql, $params);
        return $this->getGame($params['code']);
    }

    public function getGame($code)
    {
        $sql = 'SELECT * FROM game WHERE code=:codeGame';
        $params = array('codeGame' => $code);
        $result = $this->executeQuery($sql, $params)->fetch();
        return $result;
    }

    /* Fonction qui vérifie qu'un code de partie n'existe pas déjà
    */
    public function isAvailable($code)
    {
        $sql = 'SELECT code FROM game';
        $result = $this->executeQuery($sql);

        while ($codeGame = $result->fetch()) {
            if ($codeGame == $code) {
                return false;
            }
        }
        return true;
    }

    /* Fonction qui récupère une partie publique, non pleine et non commencée
    */
    public function getRandomGame()
    {
        $sqlCount = 'SELECT count(*) as nb FROM game WHERE isPublic = 1 AND isInProgress = 0';
        $resultCount = $this->executeQuery($sqlCount)->fetch();
        if (!$resultCount || intval($resultCount['nb']) === 0) {
            return false;
        } else {
            $sql = 'SELECT * FROM game WHERE isPublic = 1 AND isInProgress = 0';
            $results = $this->executeQuery($sql);
            $nb = intval($resultCount['nb']);

            for ($i = 0; $i < $nb; $i++) {
                $result = $results->fetch();

                if (intval(count($this->getPlayers($result['code']))) < intval($result['nbMaxPlayers'])) {
                    $sql = 'SELECT * FROM game WHERE code = \'' . $result['code'] . '\'';
                    $game = $this->executeQuery($sql)->fetch();
                    return $game;
                }
            }
            return false;
        }
    }

    // Fonction qui retourne tous les joueurs d'une partie
    public function getPlayers($code)
    {
        $sql = 'SELECT * FROM play WHERE code = :code';
        $params = array('code' => $code);
        $result = $this->executeQuery($sql, $params)->fetchAll();

        return $result;
    }

    /* Fonction qui lance une partie
    */
    public function started($code)
    {
        
    }

    /* Fonction qui supprime une partie
    */
    public function deleteGame($code)
    {
        $sql = 'DELETE FROM game WHERE code =:code';
        $params = array(
            'code' => $code
        );
        $this->executeQuery($sql, $params);
    }

    /* Fonction qui sélectionne un nouvel hôte
    */
    public function newHost($code)
    {
        $sql = 'SELECT * FROM play WHERE code = :code AND isHost = 0';
        $params = array('code' => $code);

        $result = $this->executeQuery($sql, $params)->fetch();
        $idPlayer = $result['idPlayer'];

        $sql = 'UPDATE play SET isHost = 0 WHERE isHost = 1 AND code =:code';
        $params = array( 'code' => $code);
        $this->executeQuery($sql, $params);

        $sql = 'UPDATE play SET isHost = 1 WHERE code =:code AND idPlayer =:idPlayer';
        $params = array(
            'code' => $code,
            'idPlayer' => $idPlayer
        );

        $this->executeQuery($sql, $params);
    }
}
