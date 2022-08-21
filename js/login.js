window.onload = function() {

    getId("login").value = "";
    getId("login").focus();

    return;
};

function getId(id) {
    return document.getElementById(id);
}

function checkValue() {

    var login = sanitize(getId('login').value);
    var pass = sanitize(getId('pass').value);

    if(login == false && pass == false) {
        getId('login').focus();
    } else {
        if(login != false) {
          if(pass != false) {
      
              var params = 'login=' + encodeURIComponent(login) + '&pass=' + encodeURIComponent(pass);

              document.getElementsByClassName('ball')[0].style.visibility = 'visible';

              httpRequest(params);
          
          } else {
              getId('pass').focus();
          }
        } else {
            getId('login').focus();
        }
    } 

    return;
}

function sanitize(text) {

    if(text.value === 0) {
        return false;
    } else {
        text.replace(/<[^>]+>/g, '');
        return text;
    }
}

function log(e) {

    e.preventDefault();
    checkValue();

    return;
}

function httpRequest(params) {
  
    var xhr = new XMLHttpRequest();

    xhr.open("POST",'../php/sign_in.php',true);
  
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.send(params);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState != 4) return;
    
        if (xhr.status != 200) {
            alert("Unable to connect to server! Try again later...");
        } else {
            document.getElementsByClassName('ball')[0].style.visibility = 'hidden';

            if(xhr.responseText == 1) {
                window.location.href = 'chat.php';
            } else {

                getId('come-button').disabled = false;
                getId('error-log').style.visibility = 'visible';

                getId('error-log').innerHTML = xhr.responseText;
            }
        }
    };

  return;
}

