/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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