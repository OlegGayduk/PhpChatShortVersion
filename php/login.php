<?php

session_start();

ini_set('default_charset','UTF-8');

if($_SESSION['id'] != 0) header('Location: '.'chat.php');

?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'/>
<title>Sign in</title>
<link href="../css/login.css" rel="stylesheet" type="text/css" />
<script src="../js/login.js"></script>
</head>
<body>

<div class="big-header"></div>

<div class="sign-in-form">
    <p class='come'>Sign in</p>
    <div id="error-log"></div>
    <div id="loading"></div>
    <div id="back"></div>
    <div class="ball"></div>
    <div id="msg_sell_container"></div>
    <form name="ajax" method="post" id="ajaxform" onsubmit="log(event)">
        <p><label class="login-text">Login: </label><input id="login" name="login" type="text" size="40" maxlength="30" /></p>
        <p><label class="pass-text">Password: </label><input id="pass" name="pass" type="password" size="40" maxlength="30" /></p>
        <p><input id="come-button" name="sub_com" type="submit" value="Sign in" /></p>
    </form>
    <p class="welc">Welcome to the official Secumes web-client.</p>
</div>

</body>
</html>