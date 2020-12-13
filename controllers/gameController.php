<?php

require_once('model/player.php');
require_once('views/view.php');

class GameController
{
  public function __construct()
  {
  }

  // generate createGame view
  public function create($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);

    $view = new View("createGame");
    $view->generate(null);
  }

  // generate joinGame view
  public function join($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);

    $view = new View("joinGame");
    $view->generate(null);
  }

  // return true if the username exist
  private function isUsername($username)
  {
    if (!isset($username[0]) or empty($username[0])) {
      $this->deleteUsername();
    }
  }

  // delete usersname cookie
  public function deleteUsername()
  {
    if (isset($_COOKIE['username'])) {
      setcookie('username', '', time(), '/', null, false, true);
    }
    header('Location: /CDEM');
    exit;
  }

  // create a new waiting room
  // generate room view
  public function createRoom()
  {
    if (isset($_POST['boolParty']) and !empty($_POST['boolParty']) and isset($_POST['Players']) and !empty($_POST['Players']) and isset($_POST['Score']) and !empty($_POST['Score'])) {

      $_POST['boolParty'] = htmlspecialchars($_POST['boolParty']);
      $_POST['Players'] = htmlspecialchars($_POST['Players']);
      $_POST['Score'] = htmlspecialchars($_POST['Score']);

      $isPublic = 0;

      if (($_POST['boolParty'] == 'Privé')) {
        $isPublic = 0;
      } else if ($_POST['boolParty'] == 'Public') {
        $isPublic = 1;
      }

      require_once('model/game.php');
      require_once('model/player.php');
      $Game = new Game();
      $Player = new Player();

      $code = $this->generateRandomString();

      $params = array(
        'code' => $code,
        'scoreMax' => $_POST['Score'],
        'isPublic' => $isPublic,
        'nbMaxPlayers' => $_POST['Players']
      );
      $myGame = $Game->createGame($params);

      $Player->registerPlayer($myGame['code'], $_COOKIE['username'], 1);

      $view = new View("room");
      $view->generate($params);
    } else {
      $view = new View("createGame");
      $view->generate(null);
    }
  }

  // generate a game code
  public function generateRandomString($length = 6)
  {
    require_once('model/game.php');
    $Game = new Game();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    do {
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
    } while (!$Game->isAvailable($randomString));
    return $randomString;
  }

  // join an already existing game
  // generate room view
  public function joinRoom()
  {
    require_once('model/game.php');
    $Game = new Game();
    $Player = new Player();
    $code = htmlspecialchars($_POST['code']);

    if (isset($code) and !empty($code)) {
      $myGame = $Game->getGame($code);
      // Est-ce que la partie existe ?
      if (!$myGame) {
        $this->_viewOnError('Partie introuvable');
        // A-t-elle commencé ?
      } else if ($myGame['isInProgress'] == 1) {
        $this->_viewOnError('La partie a déjà commencé');
        // Arrivé ici, la partie existe
      } else {
        $players = $Game->getPlayers($code);
        // Est-elle pleine ?
        if (intval(count($players)) >= intval($myGame['nbMaxPlayers'])) {
          $this->_viewOnError('La partie est complète');
          // Si non, c'est OK on continue
        } else {
          $code = $myGame['code'];
        }
      }
    } else {
      $myGame = $Game->getRandomGame();
      if ($myGame) {
        $code = $myGame['code'];
      } else {
        $this->_viewOnError('Aucune partie n\'est disponible');
      };
    }
    $Player->registerPlayer($code, $_COOKIE['username'], 0);
    $view = new View("room");
    $view->generate($myGame);
  }

  // Affichage des vues en erreur
  private function _viewOnError($errorMessage)
  {
    $_SESSION['joinError'] = $errorMessage;
    $view = new View("joinGame");
    $view->generate(null);
    exit();
  }

  public function getPlayers($code)
  {
    require_once('model/game.php');
    $Game = new Game();
    $players = $Game->getPlayers($code[0]);
    $json = json_encode($players);
    echo $json;
  }

  public function playGame($code)
  {
    require_once('model/game.php');
    $Game = new Game();
    $code = htmlspecialchars($_POST['code']);

    if (isset($code) and !empty($code)) {
      //TODO
    } else {
      //TODO
    }
    //TODO
    $view = new View("game");
    $view->generate($myGame);
  }
}
