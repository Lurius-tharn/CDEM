<?php
session_start();
require('controller/controller.php');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'connect') {
        connectView();
    } else if ($_GET['action'] == 'check') {
        checkLogin();
    }else if ($_GET['action'] == 'new') {
        newLogin();
    }else if ($_GET['action'] == 'forgottenPwd') {
        forgottenPwd();
    }else if (!isset($_COOKIE['pseudo']) OR empty($_COOKIE['pseudo'])) {
        homeView();
    } else if ($_GET['action'] == 'create') {
        createView();
    } else if ($_GET['action'] == 'join') {
        joinView();
    } else if ($_GET['action'] == 'waitingRoom') {
        waitingRoomView();
    }
} else {
    homeView();
}
