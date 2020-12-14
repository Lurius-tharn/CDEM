<?php

require_once('model/game.php');
require_once('views/view.php');

class MiniGameController
{
    public function __construct()
    {
    }

    public function getRankMiniGame($params)
    {
        if (isset($params[0]) and !empty($params[0]) and isset($params[1]) and !empty($params[1])) {
            $Game = new Game();
            $ranking = $Game->getRankMiniGame($params[0], $params[1]);
            $json = json_encode($ranking);
            echo $json;
        }
    }

    public function playMinigame($params)
    {
        if (isset($params[0]) and !empty($params[0]) and isset($params[1]) and !empty($params[1]) and isset($params[2]) and !empty($params[2])) {
            $Game = new Game();
            $Game->playMinigame($params[0], $params[1], $params[2]);
            exit;
        }
    }

    public function playerStartMG($params)
    {
        if (isset($params[0]) and !empty($params[0]) and isset($params[1]) and !empty($params[1])) {
            $Game = new Game();
            $Game->playerStartMG($params[0], $params[1]);
            exit;
        }
    }

    public function playerEndMG($params)
    {
        if (isset($params[0]) and !empty($params[0]) and isset($params[1]) and !empty($params[1])) {
            $Game = new Game();
            $Game->playerEndMG($params[0], $params[1]);
            exit;
        }
    }
}
