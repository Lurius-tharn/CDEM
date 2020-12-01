<?php

require_once('model/player.php');
require_once('views/view.php');

class PartyController
{

  public function __construct()
  {
  }

  public function create($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);

    $view = new View("createParty");
    $view->generate(null);
  }

  public function join($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);

    $view = new View("joinParty");
    $view->generate(null);
  }

  private function isUsername($username)
  {
    if (!isset($username[0]) or empty($username[0])) {
      $this->deleteUsername();
    }
  }

  public function deleteUsername()
  {
    if (isset($_COOKIE['username'])) {
      setcookie('username', '', time(), '/', null, false, true);
    }
    header('Location: /CDEM');
    exit;
  }

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
      $Party = new Party();

      $params = array(
        'nbMaxPlayers' => $_POST['Players'],
        'scoreMax' => $_POST['Score'],
        'isPublic' => $isPublic,
        'code' => $this->generateRandomString()
      );
      $Party->createParty($params);

      $view = new View("room");
      $view->generate(null);
    } else {
      $view = new View("createParty");
      $view->generate(null);
    }
  }

  /*
Fonction pour générer un code de partie aléatoire

*/

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

  function joinRoom()
  {
    require_once('model/party.php');
    $Party = new Party();

    if (isset($_POST['code']) and !empty($_POST['code'])) {

      $_POST['code'] = htmlspecialchars($_POST['code']);
      $id = $Party->getIdGame($_POST['code']);

      if (is_int($id)) {
        $Party->registerPlayer($id, 0);
        $view = new View("room");
        $view->generate(null);
      } else {
        $_SESSION['joinError'] = $id;
        $view = new View("joinParty");
        $view->generate(null);
      }
    } else {

      $id = $Party->getRandomIdGame();

      if (is_int($id)) {
        $Party->registerPlayer($id, 0);
        $view = new View("room");
        $view->generate(null);
      } else {
        $_SESSION['joinError'] = $id;
        $view = new View("joinParty");
        $view->generate(null);
      };
    }
  }
}
