<?php

session_start();

ini_set("default_charset","UTF-8");

require_once("db.php");
require_once("sql_requests.php");

function value_sanitize($val) {
    
    if(isset($val)) {

        $val = htmlspecialchars($val);
        $val = stripcslashes($val);
        $val = addslashes($val);

        return $val;
    } else {
        return false;
    }
}

if(isset($_POST)) {

    if($_POST["text"] != false) {

        //exit("1");

        $text = value_sanitize($_POST["text"]);

        //$text = $_POST["text"];

        if($_POST["lastMsg"] != false) {

            //exit("1");

            $id = value_sanitize($_POST["lastMsg"]);

            if($_SESSION['id'] != false) {

                //exit("1");
                
                $ses_id = $_SESSION['id'];
            
                $db = connection();
                
                if($db != false) { 

                    //exit($text);

                    $date_min = date("H:i:s");
                    $date_day = date("d.m.Y");
    
                    $res = send_msg($db,$ses_id,$id,$text,$date_min,$date_day);

                    if($res == true) {
                        //exit("1");
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