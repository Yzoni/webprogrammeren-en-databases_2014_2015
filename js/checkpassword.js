/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 function checkPass()
 {
     var pass1 = document.getElementById('pass1');
     var pass2 = document.getElementById('pass2');
     var message = document.getElementById('confirmMessage');
     var goodColor = "#66cc66";
     var badColor = "#ff6666";
 var hiddenMessage = pass1.value.length;
 var minLength = 5;
     if (pass1.value == pass2.value && hiddenMessage > minLength) {
         pass1.style.backgroundColor = goodColor;
 pass2.style.backgroundColor = goodColor;
         message.style.color = goodColor;
         message.innerHTML = "Passwords Match!";
 } else if (pass1.value == pass2.value && hiddenMessage <= minLength) {
 pass1.style.backgroundColor = badColor;
 pass2.style.backgroundColor = badColor;
         message.style.color = badColor;
         message.innerHTML = "Your Password Must Be At Least 6 Characters";
 } else {
         pass1.style.backgroundColor = badColor;
 pass2.style.backgroundColor = badColor;
         message.style.color = badColor;
         message.innerHTML = "Passwords Do Not Match!";
     }
 }
 
 */
submitbutton = document.getElementById("submitbutton");
submitbutton.disabled = true;

function checkForm() {
checkFirstname();
    if (checkMail() && checkPassword() && checkFirstname() && checkLastname() && checkZip() && checkStreetname() && checkStreetnumber()) {
        submitbutton = document.getElementById("submitbutton");
        submitbutton.disabled = false;
    }
}

function checkEmpty(id, errorid) {
    if (id.value == "" || id.value == null) {
        document.getElementById(errorid).style.display = "inline";
    } else {
        document.getElementById(errorid).style.display = "none";
    }
}

function checkMail() {
    var x = document.getElementById("email");
    var errorid = "error0";
    if (checkEmpty(x, errorid)) {
        return true;
    }
}

function checkPassword() {
    var x = document.getElementById("password1");
    var errorid = "error1";
    if (checkEmpty(x, errorid)) {
        return true;
    }
}

function checkFirstname() {
    var x = document.getElementById("firstname");
    var errorid = "error3";
    if (checkEmpty(x, errorid)) {
        return true;
    }
}

function checkLastname() {
    var x = document.getElementById("lastname");
    var errorid = "error4";
    if (checkEmpty(x, errorid)) {
        return true;
    }
}

function checkzip() {
    var x = document.getElementById("zip");
    var errorid = "error5";
    if (checkEmpty(x, errorid)) {
        return true;
    }
}

function checkStreetname() {
    var x = document.getElementById("streetname");
    var errorid = "error6";
    if (checkEmpty(x, errorid)) {
        return true;
    }
}

function checkStreetnumber() {
    var x = document.getElementById("streetnumber");
    var errorid = "error7";
    if (checkEmpty(x, errorid)) {
        return true;
    }
}