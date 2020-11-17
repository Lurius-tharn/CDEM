<?php
require('controller/controller.php');


if (isset($_GET['action'])) {
    if ($_GET['action'] == 'connect') {
        connectView();
    } else if ($_GET['action'] == 'create') {
        createView();
    } else if ($_GET['action'] == 'join') {
        joinView();
    }
} else {
    homeView();
}
