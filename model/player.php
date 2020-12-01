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

    // Create an idPlayer for a non-connected player
    public function createIdPlayer()
    {
        $sql = 'SELECT idPlayer FROM player WHERE idPlayer = (SELECT MAX(idPlayer) FROM player)';
        $id = $this->executeQuery($sql)->fetch();
        $id = intval($id);
        return ($id + 1000);
    }
}
