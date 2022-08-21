<?php

function log_sql_requests($db,$log,$pass) {

    if($db != false) {

        $result = $db->query("SELECT id,login,pass FROM users WHERE login='$log' and pass='$pass'");

        if($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            if(isset($row['login'],$row['pass'],$row['id'])) {

                return $row['id'];
            } else {
                $db->close();
                return false;
            }
        } else {
            $db->close();
            return false;
        }
    } else {
        return false;
    }
} 

function get_msgs($db,$ses_id) {

    if($db != false) {

        /*$result = $db->query("SELECT otpr_id,poluch_id,main_id FROM msgs WHERE (otpr_id='$ses_id' and poluch_id='$sell') or (poluch_id='$ses_id' and otpr_id='$sell') and status=0");

        if($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            do {
                if($ses_id == $row['poluch_id']) {

                    $id = $row['main_id'];

                    $db->query("UPDATE msgs SET status=1 WHERE main_id='$id'");

                    $db->query("UPDATE dialogs SET status=1 WHERE main_text_id='$id'");
                }
            } while($row = $result->fetch_assoc());

            $result->close();
        } else { 
            $result->close();
        }*/

        $result3 = $db->query("SELECT id,receiver,sender,text,date_min,date_day FROM msgs ORDER BY id LIMIT 30");
        
        if($result3->num_rows > 0) {

            $row3 = $result3->fetch_assoc();

            $a = 0;

            try {
                do {

                    $arr[$a] = array('id' => $row3['id'],'sender' => $row3['sender'],'text' => $row3['text'],'date_min' => $row3['date_min'],'date_day' => $row3['date_day']);

                    $a++;
                } while($row3 = $result3->fetch_assoc());

            } catch(Exception $e) {
                //return $e->getMesage();

                return false;
            }

            return json_encode($arr);

            //return $arr;

            //return array($result3,$row3);
        } else {
            $db->close();
            return false;
        }
    } else {
        return false;
    }
}

function get_new_sended_msgs($db,$ses_id,$id) {
    
    if($db != false) {

        $result = $db->query("SELECT id,receiver,sender,text,date_min,date_day FROM msgs WHERE sender != '$ses_id' AND id > '$id' ORDER BY id LIMIT 30");

        if($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $a = 0;

            try {

                do {

                    $arr[$a] = array('id' => $row['id'],'sender' => $row['sender'],'text' => $row['text'],'date_min' => $row['date_min'],'date_day' => $row['date_day']);

                    $a++;
                } while($row = $result->fetch_assoc());

            } catch(Exception $e) {
                //return $e->getMesage();

                return false;
            }

            return json_encode($arr);
        } else {
            $db->close();
            return false;
        }
    } else {
        return false;
    }
}

function send_msg($db,$ses_id,$id,$text,$date_min,$date_day) {
    if($db != false) {

        /*$key = 2324;

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        $text= mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);

        $text = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);*/

        $db->query("INSERT INTO msgs(receiver,sender,text,date_min,date_day) VALUES (0,$ses_id,'$text','$date_min','$date_day')");

        $result = $db->query("SELECT id FROM msgs WHERE id='$id'");

        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function typing_status_change($db,$ses_id) {
    //$db->query("UPDATE users SET status=1 WHERE id='$ses_id' and status=0");

    $result = $db->query("SELECT alias FROM users WHERE id='$ses_id'");

    if($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $alias = $row['alias'];

        $db->query("INSERT IGNORE INTO typing_status(user_id,alias) VALUES ($ses_id,'$alias')");

        //$result2 = $db->query("SELECT id FROM typing_status WHERE ")
    } else {
        return false;
    }
}

?>