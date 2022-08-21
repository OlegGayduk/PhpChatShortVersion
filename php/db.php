<?php
function connection() {
	
    $db = new mysqli('localhost', 'root', '','chat');

    if (mysqli_connect_errno()) {
       return false;
    } else {
       return $db;
    }	
}
?>