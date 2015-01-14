<?php
require_once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';
?>

<div class="formwrapper">
    <h2>Registreer als nieuwe klant: </h2>
    <form action="customer_register.php">
        <input type="text" name="username" placeholder="username"><br>
        <input type="password" name="password" placeholder="wachtwoord" id="pass1" onkeyup="checkPass();
                return false;">
        <span id="confirmMessage"></span><br>
        <input type="password" name="password2" placeholder="wachtwoord (nogmaals)" id="pass2" onkeyup="checkPass();
                return false;">
        <span id="confirmMessage"></span><br>
        <input type="text" name="firstname" placeholder="voornaam" id="person"><br>
        <input type="text" name="lastname" placeholder="achternaam" id="person"><br>
        <input type="text" name="email" placeholder="emailadres" id="person"><br>
        <input type="text" name="zip" placeholder="woonplaats(ZIP eigenlijk ofzo)" id="info"><br>
        <input type="text" name="streetaddress" placeholder="straatnaam" id="info"><br>
        <input type="text" name="streetnumber" placeholder="huisnummer" id="info"><br>
        <input class="button" type="submit" value="registreren">
    </form>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>

<?php
include 'views/footer.php';
?>
