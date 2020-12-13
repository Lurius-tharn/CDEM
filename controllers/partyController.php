<?php

require_once('model/player.php');
require_once('views/view.php');

class PartyController
{

  public function __construct()
  {
  }

  // generate createParty view
  public function create($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);

    $view = new View("createParty");
    $view->generate(null);
  }

  // generate joinParty view
  public function join($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);

    $view = new View("joinParty");
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

      require_once('model/party.php');
      require_once('model/player.php');
      $Party = new Party();
      $Player = new Player();

      $code = $this->generateRandomString();

      $params = array(
        'nbMaxPlayers' => $_POST['Players'],
        'scoreMax' => $_POST['Score'],
        'isPublic' => $isPublic,
        'code' => $code
      );
      $myParty = $Party->createParty($params);
      $_SESSION['idGame'] = intval($myParty['idGame']);

      $Player->registerPlayer(intval($myParty['idGame']), 1);

      setcookie('code', $code, time() + 365 * 24 * 3600, '/', null, false, true);
      $_SESSION['code'] = $code;
      $view = new View("room");
      $view->generate($params);
    } else {
      $view = new View("createParty");
      $view->generate(null);
    }
  }

  // generate a party code
  public function generateRandomString($length = 6)
  {
    require_once('model/party.php');
    $Party = new Party();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    do {
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
    } while (!$Party->isAvailable($randomString));
    return $randomString;
  }

  // join an already existing party
  // generate room view
  function joinRoom()
  {
    require_once('model/party.php');
    $Party = new Party();
    $Player = new Player();
    $code = htmlspecialchars($_POST['code']);
    if (isset($code) and !empty($code)) {
      $myParty = $Party->getParty($code);
      // Est-ce que la partie existe ?
      if (!$myParty) {
        $this->_viewOnError('Partie introuvable');
        // A-t-elle commencé ?
      } else if ($myParty['isInProgress'] == 1) {
        $this->_viewOnError('La partie a déjà commencé');
        // Arrivé ici, la partie existe
      } else {
        $players = $Party->getPlayers($code);
        // Est-elle pleine ?
        if (count($players) === intval($myParty['nbMaxPlayers'])) {
          $this->_viewOnError('La partie est complète');
          // Si non, c'est OK on continue
        } else {
          $id = $myParty['idGame'];
        }
      }
    } else {
      $myParty = $Party->getRandomGame();
      if ($myParty) {
        $id = $myParty['idGame'];
        $code = $myParty['code'];
      } else {
        $this->_viewOnError('Aucune partie n\'est disponible');
      };
    }
    $Player->registerPlayer($id, 0);
    setcookie('code', $code, time() + 365 * 24 * 3600, '/', null, false, true);
    $_SESSION['code'] = $code;
    $view = new View("room");
    $view->generate($myParty);
  }
  // Affichage des vues en erreur
  private function _viewOnError($errorMessage)
  {
    $_SESSION['joinError'] = $errorMessage;
    $view = new View("joinParty");
    $view->generate(null);
    exit();
  }

  function nbPlayers($idGame)
  {
    require_once('model/party.php');
    $Party = new Party();
    $nb = $Party->getNbPlayers($idGame[0]);
    echo $nb;
  }

  function nbMaxPlayers($idGame)
  {
    require_once('model/party.php');
    $Party = new Party();
    $nb = $Party->getNbMaxPlayers($idGame[0]);
    echo $nb;
  }

  function getPlayers($idGame)
  {
    require_once('model/party.php');
    $Party = new Party();
    $players = $Party->getPlayers($idGame[0]);
    $json = json_encode($players);
    echo $json;
  }
}
