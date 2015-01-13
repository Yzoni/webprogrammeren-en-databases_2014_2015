<?php
require_once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';
?>

<div class="formwrapper">
    <h2>Registreer als nieuwe klant: </h2>
    <form action="customer_register.php">
        <input type="text" name="username" placeholder="username"><br>
        <input type="password" name="wachtwoord" placeholder="wachtwoord" id="pass1" onkeyup="checkPass();
                return false;">
        <span id="confirmMessage"></span><br>
        <input type="password" name="wachtwoord2" placeholder="wachtwoord (nogmaals)" id="pass2" onkeyup="checkPass();
                return false;">
        <span id="confirmMessage"></span><br>
        <input type="text" name="voornaam" placeholder="voornaam" id="person"><br>
        <input type="text" name="achternaam" placeholder="achternaam" id="person"><br>
        <input type="text" name="emailadres" placeholder="emailadres" id="person"><br>
        <input type="text" name="woonplaats" placeholder="woonplaats" id="info"><br>
        <input type="text" name="straatnaam" placeholder="straatnaam" id="info"><br>
        <input type="text" name="huisnummer" placeholder="huisnummer" id="info"><br>
        <input class="button" type="submit" value="registreren">
    </form>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>

<?php
include 'views/footer.php';
?>
