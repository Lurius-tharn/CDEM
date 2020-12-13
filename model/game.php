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

    /* Fonction qui récupère une partie publique et non commencée
    */
    public function getRandomGame()
    {
        $sqlCount = 'SELECT count(*) as nb FROM game WHERE isPublic = 1 AND isInProgress = 0';
        $resultCount = $this->executeQuery($sqlCount)->fetch();
        if (!$resultCount || intval($resultCount['nb']) === 0) {
            return false;
        } else {
            $numEnr = random_int(1, intval($resultCount['nb'])) - 1;
            $sql = 'SELECT * FROM game WHERE isPublic = 1 AND isInProgress = 0 LIMIT 1 OFFSET ' . $numEnr;
            $result = $this->executeQuery($sql)->fetch();
            return $result;
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
}
