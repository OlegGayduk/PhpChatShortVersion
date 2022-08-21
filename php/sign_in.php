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

    $log = value_sanitize($_POST['login']);

	if($log != false) { 

        $pass = value_sanitize($_POST['pass']);

	    if($pass != false) { 
           
            $db = connection();

            if($db != false) { 

                //$_SESSION['secret'] = "eirens"; 

                $res = log_sql_requests($db,$log,$pass);
    
                if($res != false) { 

                    $_SESSION['id'] = $res;

                    exit(true);

                } else {
                    exit('Login and Pass are incorrect!');
                }
            } else {
                exit('Please check your connection to the internet!');
            } 
        } else {
            exit('Fill in all the fields!');
        }
    } else {
        exit('Fill in all the fields!');
    }
} else {
	exit('Fatal error!');
}

?>