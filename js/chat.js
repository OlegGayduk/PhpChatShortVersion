let lastMsg = 0;

window.onload = function() {

	$('.nano').nanoScroller();

	setInterval(function() {
		check({type:'POST',url:'../php/check_new_msgs.php',sendContent:'lastMsg=' + encodeURIComponent(lastMsg),elem:document.getElementsByClassName('msgs-history-selected')[0]});
	},2000);
};

function getXhrType() {

    var xhr;

    try {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xhr = 0;
        }
    }

    if(!xhr && typeof XMLHttpRequest != 'undefined') xhr = new XMLHttpRequest();

    return xhr;
}

function check(params) {

	var x = getXhrType();

    if(x == 0) {
        alert("Fatal error");
        return;
    }

    x.onreadystatechange = function() {

        if(x.readyState != 4) return;
    
        if(this.status == 200) {
    
            if(x.responseText == 0) {
                if(lastMsg == 0) if(document.getElementsByClassName('empty-dialogs')[0] == undefined) $(document.getElementsByClassName('nano-content')[0]).append("<span class='empty-dialogs'>You haven't got any msgs here yet</span>");
            } else {

            	//alert(x.responseText);
            	
            	//if(document.getElementsByClassName('empty-dialogs')[0] != undefined) $(".nano-content").removeClass("empty-dialogs");

            	var msgsArrLength = eachCycle(JSON.parse(x.responseText));

                if(msgsArrLength == 0) {
                    alert("Error! Try again later...");
                } else {
                    parseJson(JSON.parse(x.responseText),msgsArrLength,"append");
                }
            }
    
        } else {
            alert("Unable to connect to server! Try again later...");
        }       
    };

    x.open(params.type,params.url,true);

    x.setRequestHeader("Cache-Control", "no-cache");

    x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    x.send(params.sendContent);

    return;
}

function sendMsgFromKey(e) {

    if(e.keyCode == "13") sendMsg(e);

	return;
}

function sendMsg(e) {

	e.preventDefault();

	var dat = new Date();

	var date = dat.getHours() + ':' + dat.getMinutes() + ':' + dat.getSeconds();

    if(document.getElementsByClassName('msgs-send-textarea')[0].value != '') {
    	
    	var value = sanitizeMsgValue(document.getElementsByClassName('msgs-send-textarea')[0].value);
    	//var value = document.getElementsByClassName('msgs-send-textarea')[0].value;
    	
    	if(document.getElementsByClassName('empty-dialogs')[0] != undefined) document.getElementsByClassName('empty-dialogs')[0].innerHTML = "";

    	//newMsgsAppend
    	var con = document.getElementsByClassName('nano-content')[0].scrollHeight;

    	$(document.getElementsByClassName('msgs-history-selected')[0]).append("<div class='msg-wrap' onclick='msgsActs.msgsSelect()' id='' onmouseover='msgsActs.msgsMouseOver()' onmouseout='msgsActs.msgsMouseOut()'>"+
        "<div class='msg-wrap-big msg-unread'>"+
            "<div class='msg-content'>"+
                "<span class='msg-date'></span>"+
                "<div class='msg-body msg-body-min'>"+
                    "<div class='msg-content-text'>"+
                        "<span class='msg-text'>"+value+"</span>"+
                    "</div>"+
                "</div>"+
            "</div>"+
        "</div>"); 

        document.getElementsByClassName('msgs-send-textarea')[0].value = "";

        msgsHeightChange(con);

        //alert((lastMsg + 1));

        lastMsg++;

        sendMsgRequest({type:'POST',url:'../php/send_msg.php',sendContent:'text=' + encodeURIComponent((value)) + '&lastMsg=' + encodeURIComponent(lastMsg),elem:document.getElementsByClassName('msgs-history-selected')[0]});
        
        //lastMsg--;

    }

	return;
}

function sendMsgRequest(params) {

    var x = getXhrType();

    if(x == 0) {
        alert("Fatal error");
        return;
    }

    x.onreadystatechange = function() {

        if(x.readyState != 4) return;
    
        if(this.status == 200) {

        	//alert(x.responseText);
    
            if(x.responseText == 0) {
            	alert("Unable to send msg!");
            } else {
            	//lastMsg++;
            }
    
        } else {
            alert("Unable to connect to server! Try again later...");
        }       
    };

    x.open(params.type,params.url,true);

    x.setRequestHeader("Cache-Control", "no-cache");

    x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    x.send(params.sendContent);

	return;
}

function sanitizeMsgValue(text) {
    text.replace(/<[^>]+>/g, '');
    return text;
}

function writerStatusChange(t) {

	/*if(t.value.length == 1) {

	    var x = getXhrType();
    
        if(x == 0) {
            alert("Fatal error");
            return;
        }
    
        x.onreadystatechange = function() {
    
            if(x.readyState != 4) return;
        
            if(this.status == 200) {
        
                if(x.responseText == 0) {
                	alert("Error while typing!");
                } else {
                	//document.getElementsByClassName('msgs-history-typing-wrap-text')[0].
                }
        
            } else {
                alert("Unable to connect to server! Try again later...");
            }       
        };
    
        x.open("POST","../php/typing_status.php",true);
    
        x.setRequestHeader("Cache-Control", "no-cache");
    
        x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
        x.send();
    }*/

	return;
}

function eachCycle(j) {

    var a = 0;
    var arr = [];
    
    try {
        for(var key in j) {
            //arr[a++] = key;
            a++;
        }
    } catch(e) {
        return false;
    }

    return a;
}

function parseJson(arr,arrLength,action) {

	//alert(arr);

    try {
        for(var i = 0;i < arrLength;i++) {
            (action == "append") ? newMsgsAppend(arr,i,arrLength) : newMsgsPrepend(arr,i,arrLength);               
        }
    } catch(e) {
        alert(e);
    }

    return;
} 

function newMsgsAppend(arr,i,length) {

	var con = document.getElementsByClassName('nano-content')[0].scrollHeight;

    //if(arr[i]['status'] == 0) {

    $(document.getElementsByClassName('msgs-history-selected')[0]).append(
    "<div class='msg-wrap' onclick='msgsActs.msgsSelect("+arr[i]['id']+")' id="+arr[i]['id']+" onmouseover='graphics.msgsMouseOver("+arr[i]['id']+")' onmouseout='graphics.msgsMouseOut("+arr[i]['id']+")'>"+
    "<div class='msg-wrap-big msg-unread'>"+
        "<div class='msg-content'>"+
            "<span class='msg-date'>"+arr[i]['date_min']+"</span>"+
            "<div class='msg-body msg-body-min'>"+
                "<div class='msg-content-text'>"+
                    "<span class='msg-text'>"+arr[i]['text']+"</span>"+
                "</div>"+
            "</div>"+
        "</div>"+
    "</div>"); 
    //}

    msgsHeightChange(con);

    if(i == (length - 1)) lastMsg = arr[i]['id'];

    return;
}

function newMsgsPrepend(j,i,arrLength) {

}

function msgsHeightChange(con) {

    if(document.getElementsByClassName('msgs-history-selected')[0].scrollHeight > con) {
        document.getElementsByClassName('msgs-history-selected')[0].style.marginTop = "0px";
    } else {
        document.getElementsByClassName('msgs-history-selected')[0].style.marginTop = con - document.getElementsByClassName('msgs-history-selected')[0].scrollHeight - 30 + 'px';
    
        if(document.getElementsByClassName('msgs-history-selected')[0].scrollHeight > (con - 30)) document.getElementsByClassName('msgs-history-selected')[0].style.marginTop = "0px";
    }
    
    $('.nano').nanoScroller();

    document.getElementsByClassName('nano-content')[0].scrollTop = document.getElementsByClassName('nano-content')[0].scrollHeight;

    return;
}

