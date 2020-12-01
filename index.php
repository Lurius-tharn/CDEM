<?php

/**
 * On inclue d'abord les fichiers nécessaires et on initialise la logique de routes
 */
include("includes/routing.php");
$fmk = new Routes();
include("includes/routes.php");

//Si la route est définie, on récupère la route en question
if (isset($_GET["url"])) {
    $route = htmlentities(trim($_GET["url"]));
} else {
    $route = "";
}

$fmkRoute = $fmk->getControlleur($route);

if ($fmk->isError404()) {
    require_once('errors/404.php');
    exit;
}

$controller = 'controllers/' . $fmkRoute[0];

include($controller);

$class = explode('.', $fmkRoute[0]);
$class = ucfirst($class[0]);

$actions = explode('/', $fmkRoute[1]);
$methodName = $actions[0];
array_shift($actions);

if ($class == 'HomeController')
    $object = new HomeController();
else if ($class == 'PartyController')
    $object = new PartyController();
else if ($class == 'PlayerController')
    $object = new PlayerController();


if (isset($actions) and !empty($actions)) {
    $methodVariable = array(array($object, $methodName), array($actions));
    call_user_func_array(array($object, $methodName), array($actions));
} else {
    $methodVariable = array($object, $methodName);
    if (is_callable($methodVariable, true, $callable_name)) {
        call_user_func(array($object, $methodName));
    } else {
        header('Location: /CDEM');
        exit;
    }
}
