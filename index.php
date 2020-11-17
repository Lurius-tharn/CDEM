<?php
require('controller/controller.php');


if (isset($_GET['action']) ) {
    if ($_GET['action']== 'create') {
       createView();
       
    }
     if ($_GET['action']=='join') {
        joinView();
    }
}else{
    homeView();
}
