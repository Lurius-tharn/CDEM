<?php

require_once 'model/model.php';

class Player extends Model
{

    // Register a player in the database
    public function newPlayer($email, $pwd)
    {
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = 'SELECT email FROM player';
        $result = $this->executeQuery($sql);

        while ($emailPlayer = $result->fetch()) {
            if (strcmp($emailPlayer['email'], $email) == 0) {
                return False;
            }
        }

        $sql = 'INSERT INTO player(email, pwd) VALUES(:email, :pwd)';
        $params = array(
            'email' => $email,
            'pwd' => $hash
        );

        $this->executeQuery($sql, $params);
        $this->connectPlayer($email, $pwd);
        return True;
    }

    // Connect a player
    public function connectPlayer($email, $pwd)
    {
        $sql = 'SELECT * FROM player';
        $players = $this->executeQuery($sql);
        while ($Player = $players->fetch()) {
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

    // Disconnect a player
    public function disconnectPlayer()
    {
        if (isset($_SESSION['isConnected']) and !empty($_SESSION['isConnected']))
            unset($_SESSION['isConnected']);
        if (isset($_SESSION['idPlayer']) and !empty($_SESSION['idPlayer']))
            unset($_SESSION['idPlayer']);
    }

    // Check if a player is connected
    public function isConnected()
    {
        if (isset($_SESSION['isConnected']) and !empty($_SESSION['isConnected']))
            return $_SESSION['isConnected'];
        return False;
    }

    /* Fonction qui enregistre un joueur dans une partie
    */
    function registerPlayer(int $idGame, $isHost)
    {
        if ($this->isConnected()) {
            $idPlayer =  $_SESSION['idPlayer'];
        } else {
            $idPlayer = trim(com_create_guid(), '{}');
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
        return $this->getUserFromPlay($idPlayer, intval($idGame));
    }
    function getUserFromPlay(string $guid,int $idGame){
        $sql = 'SELECT * FROM play WHERE idPlayer=:idPlayer AND idGame=:idGame';
        $params = array(
            'idPlayer' => $guid,
            'idGame' => $idGame
        );
        $result = $this->executeQuery($sql, $params)->fetch();
        $result['account']=$this->getPlayer($guid);
        return $result;
    }
    function getPlayer($guid)
    {
        $sql = 'SELECT * FROM player WHERE idPlayer=:idPlayer';
        $params = array('idPlayer' => $guid);
        $result = $this->executeQuery($sql, $params)->fetch();
        return $result;
    }
}
