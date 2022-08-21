<?php

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

$get_sell = value_sanitize($_GET['sell']);

if($get_sell != false) {

    if($_SESSION['id'] != false) {
    
        $ses_id = $_SESSION['id'];

        $db = connection();
    
        if($db != false) { 

                $msgs = get_msgs($db,$ses_id,$get_sell);
        
                if($msgs != false) {
                    exit($msgs);
                } else {
                    exit(0);
                }
        } else {
            exit(0);
        }
    } else {
        exit(0);
    } 
} else {
    exit(0);
}



?>


?>