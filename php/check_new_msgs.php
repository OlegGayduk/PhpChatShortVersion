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

    if($_SESSION['id'] != false) {
        
        $ses_id = $_SESSION['id'];
    
        $db = connection();
        
        if($db != false) { 

            $id = value_sanitize($_POST['lastMsg']);

            if($id == 0) {
    
                $msgs = get_msgs($db,$ses_id);
            
                if($msgs != false) {
        
                    //exit(json_encode(array($msgs,1)));

                    exit($msgs);
            
                } else {
                    exit(false);
                }
            } else {

                //exit("1");

                $msgs = get_new_sended_msgs($db,$ses_id,$id);

                if($msgs != false) {
        
                    exit($msgs);
            
                } else {
                    exit(false);
                }
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