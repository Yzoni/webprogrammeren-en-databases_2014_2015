<?php
require_once 'classes.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $zip = $_POST['zip'];
    $gender = $_POST['gender']=="true" ? true : false;
    $streetnumber = $_POST['streetnumber'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $streetaddress = $_POST['streetaddress']; 
    Customer::create($email, $password, $streetaddress, $streetnumber, $zip, $firstname, $lastname, $gender);
}

include 'views/header.php';
include 'views/navigation.php';
?>

<div class="formwrapper">
    <h2 class="contenttitle">Registreer als nieuwe klant: </h2>
    <form action="customer_register.php" method="POST">
        <input type="text" name="email" placeholder="emailadres" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"><br>
        <input type="password" name="password" placeholder="wachtwoord" id="pass1" onkeyup="checkPass();
                return false;">
        <span id="confirmMessage"></span><br>
        <input type="password" name="password2" placeholder="wachtwoord (nogmaals)" id="pass2" onkeyup="checkPass();
                return false;">
        <span id="confirmMessage"></span><br>
        <select name="gender">
            <option value="true">Dhr.</option>
            <option value="false">Mevr.</option>
        </select><br>
        <input type="text" name="firstname" placeholder="voornaam" id="person"><br>
        <input type="text" name="lastname" placeholder="achternaam" id="person"><br>
        <input type="text" name="zip" placeholder="postcode" pattern="[0-9]{4}[a-zA-Z]{2}$" id="info"><br>
        <input type="text" name="streetaddress" placeholder="straatnaam" id="info"><br>
        <input type="text" name="streetnumber" placeholder="huisnummer" id="info"><br>
        <button class="button" type="submit"><span>&#xf084;</span> | login</button>
    </form>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>

<?php
include 'views/footer.php';
?>
