<?php

session_start();

ini_set("default_charset","UTF-8");

require_once("db.php");
require_once("sql_requests.php");

if(isset($_POST)) {

    if($_SESSION['id'] != false) {
        
        $ses_id = $_SESSION['id'];
    
        $db = connection();
        
        if($db != false) { 

            typing_status_change($db,$ses_id);

            exit(true);
        } else {
            exit(false);
        }
    } else {
        exit(false);
    }
} else {
    exit(false);
}

?>