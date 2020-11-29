<?php
session_start();
require('controller/controller.php');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'connect') {
        connectView();
    } else if ($_GET['action'] == 'disconnect') {
        $PlayerManager = new PlayerManager();
        $PlayerManager->disconnectPlayer();
        homeView();
    } else if ($_GET['action'] == 'check') {
        checkLogin();
    } else if ($_GET['action'] == 'new') {
        newLogin();
    } else if ($_GET['action'] == 'forgottenPwd') {
        forgottenPwd();
    } else if (!isset($_COOKIE['username']) or empty($_COOKIE['username'])) {
        homeView();
    } else if ($_GET['action'] == 'create') {
        createView();
    } else if ($_GET['action'] == 'join') {
        joinView();
    } else if ($_GET['action'] == 'createWaitingRoom') {
        createWaitingRoomView();
    } else if ($_GET['action'] == 'joinWaitingRoom') {
        joinWaitingRoomView();
    }
} else {
    homeView();
}
