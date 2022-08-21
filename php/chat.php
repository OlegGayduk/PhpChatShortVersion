<?php

session_start();

ini_set('default_charset','UTF-8');

if($_SESSION['id'] == 0) header('Location: '.'login.php');

?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'/>
<title>Chat</title>
<link href="../css/chat.css" rel="stylesheet" type="text/css" />
<script src='../js/jqueryLibrary.js'></script>
<script src='../js/nanoscroll.js'></script>
<script src="../js/chat.js"></script>
</head>
<body>

<div class="container">
    <div id='msgs-history-col-wrap' class='nano'>
        <div class='overthrow nano-content' onscroll=''>
            <div class="msgs-history-selected"></div>
        </div>
    </div>

    <form class='msgs-send-form-wrap' method='post'>
        <div class='msgs-history-typing-wrap'>
            <span class='msgs-history-typing-wrap-text'></span></div>
        <textarea class='msgs-send-textarea' contenteditable='true' onkeydown='sendMsgFromKey(event)' oninput='writerStatusChange(this)' name='text'></textarea>
        <span type='submit' class='msgs-history-send-btn' onclick='sendMsg(event)'>ОТПРАВИТЬ</span>
    </form>  

    <div class="bottom-send-panel">
        <div class='send-media'>
            <form name="uploadFile" id='upload' method='post' enctype='multipart/form-data'>
                <input name="filename" class="im_attach_input" size="28" multiple="multiple" title="Send file" type="file" onchange='messFileUploadActs.fileUpload(this,uploadFile);'>
            </form>
        </div>
        <div class="send-photos">
            <form name="uploadMedia" id='upload' method='post' enctype='multipart/form-data'>
                <input name="filename" class="im_media_attach_input" size="28" multiple="multiple" accept="image/*, video/*, audio/*" title="Send media" type="file" onchange='messFileUploadActs.fileUpload(this,uploadMedia);'>
            </form>
        </div>
    </div>
</div>

</body>
</html>