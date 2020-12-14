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
        $sql = 'UPDATE game SET isInProgress = 1 WHERE code =:code';
        $params = array('code' => $code);

        $this->executeQuery($sql, $params);
    }

    /* Fonction qui détermine si une partie a commencé
    */
    public function isInProgress($code)
    {
        $sql = 'SELECT isInProgress FROM game WHERE code =:code';
        $params = array('code' => $code);

        $result = $this->executeQuery($sql, $params)->fetch();
        return intval($result[0]);
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
        $params = array('code' => $code);
        $this->executeQuery($sql, $params);

        $sql = 'UPDATE play SET isHost = 1 WHERE code =:code AND idPlayer =:idPlayer';
        $params = array(
            'code' => $code,
            'idPlayer' => $idPlayer
        );

        $this->executeQuery($sql, $params);
    }

    // Fonction qui attribue un minigame à tous les joueurs présents dans une partie
    public function playMinigame($code, $idMinigame, $num)
    {
        $players = $this->getPlayers($code);
        for ($i = 0; $i < count($players); $i++) {
            $sql = 'INSERT INTO play_minigame(idPlay, idMinigame, score, startDate, endDate, num)
                VALUES (:idPlay, :idMinigame, :score, :startDate, :endDate, :num)';
            $params = array(
                'idPlay' => $players[$i]['idPlay'],
                'idMinigame' => $idMinigame,
                'score' => 0,
                'startDate' => null,
                'endDate' => null,
                'num' => $num
            );
            $this->executeQuery($sql, $params);
        }
    }

    /*
    Fonction qui met à jour le startDate du joueur dès qu'il commence son mini-jeu*/
    public function playerStartMG($idPlay, $num)
    {
        $sql = 'UPDATE play_minigame SET startDate =:startDate WHERE idPlay =:idPlay AND num =:num';
        $params = array(
            'startDate' => date("Y-m-d H:i:s"),
            'idPlay' => $idPlay,
            'num' => $num
        );
        $this->executeQuery($sql, $params);
    }

    /*
    Fonction qui met à jour le endDate du joueur dès qu'il a finit son mini-jeu*/
    public function playerEndMG($idPlay, $num)
    {
        $sql = 'UPDATE play_minigame SET endDate =:endDate WHERE idPlay =:idPlay AND num =:num';
        $params = array(
            'endDate' => date("Y-m-d H:i:s"),
            'idPlay' => $idPlay,
            'num' => $num
        );
        $this->executeQuery($sql, $params);
    }

    /**
     * Fonction qui, une fois le mini jeux fini par tous les joueurs ou le temps écoulé,
     * nous donne le classement en fonction de la difference entre le temps du début et le temps de la fin.
     */
    public function getRankMiniGame($code, $num)
    {
        // 1 recuperer les joueurs, classés en fonction de leur temps
        $sql = 'SELECT username, idPlayMinigame, TIMESTAMPDIFF(SECOND,startDate,endDate) 
            FROM play_minigame, play WHERE play_minigame.idPlay = play.idPlay AND play.code = :code AND num =:num
            Order BY TIMESTAMPDIFF(SECOND,startDate,endDate)';
        $params = array(
            'code' => $code,
            'num' => $num
        );
        $results = $this->executeQuery($sql, $params);

        // 2 attribuer les points
        $sqlCount = 'SELECT count(*) as nb FROM play_minigame, play WHERE play_minigame.idPlay = play.idPlay AND play.code = :code AND num =:num';
        $params = array(
            'code' => $code,
            'num' => $num
        );
        $resultCount = $this->executeQuery($sqlCount, $params)->fetch();

        for ($i = 0; $i < $resultCount['nb']; $i++) {
            $player = $results->fetch();

            switch ($i) {
                case 0:
                    $score = 5;
                    break;
                case 1:
                    $score = 3;
                    break;
                case 2:
                    $score = 1;
                    break;
                default:
                    $score = 0;
                    break;
            }
            $sql = 'UPDATE play_minigame SET score = :score WHERE idPlayMinigame =:idPlayMinigame';
            $params = array(
                'idPlayMinigame' => $player['idPlayMinigame'],
                'score' => $score
            );
            $this->executeQuery($sql, $params);
        }


        // 3 retourner les joueurs et leur score à ce mini-jeu dans l'ordre du classement
        $sql = 'SELECT username, score
            FROM play_minigame, play WHERE play_minigame.idPlay = play.idPlay AND play.code = :code AND num =:num
            Order BY score DESC';
        $params = array(
            'code' => $code,
            'num' => $num
        );
        $results = $this->executeQuery($sql, $params)->fetchAll();
        return $results;
    }
}
