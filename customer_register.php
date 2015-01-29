<?php
require_once 'classes.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $zip = $_POST['zip'];
    $gender = $_POST['gender'] == "true" ? true : false;
    $streetnumber = $_POST['streetnumber'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $streetaddress = $_POST['streetaddress'];
    if (empty($email) || empty($password) || empty($zip) || empty($streetnumber) || empty($firstname) || empty($lastname) || empty($streetaddress)) {
        $display->addMessage("error", "Niet alle velden ingevuld");
    } else {
        if (Customer::checkMailOccurrance($email)) {
            $display->addMessage("error", "Email al geregistreerd");
        } else {
            Customer::create($email, $password, $streetaddress, $streetnumber, $zip, $firstname, $lastname, $gender);
            $display->addMessage("success", "Account aangemaakt");
        }
    }
}

include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
    <h2 class="contenttitle">Registreer als nieuwe klant: </h2>
    <div class="wrapperregister">
    <form action="customer_register.php" method="POST">
        <input id="email" type="text" name="email" placeholder="emailadres" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  onkeyup="checkForm()"><br>
        <input type="password" name="password" placeholder="wachtwoord" id="password1" onkeyup="checkForm()">
        <input type="password" name="password2" placeholder="wachtwoord (nogmaals)" id="password2" onkeyup="checkForm()">
        <select name="gender" class="select_gender">
            <option value="true">Dhr.</option>
            <option value="false">Mevr.</option>
        </select>
        <input id="firstname" type="text" name="firstname" placeholder="voornaam" onkeyup="checkForm()"><br>
        <input id="lastname" type="text" name="lastname" placeholder="achternaam" onkeyup="checkForm()"><br>
        <input id="zip" type="text" name="zip" placeholder="postcode" pattern="[0-9]{4}[a-zA-Z]{2}$" onkeyup="checkForm()"><br>
        <input id="streetname" type="text" name="streetaddress" placeholder="straatnaam" onkeyup="checkForm()"><br>
        <input id="streetnumber" type="text" name="streetnumber" placeholder="huisnummer" onkeyup="checkForm()"><br>
        <button id="submitbutton" class="button" type="submit"><span>&#xf14a;</span>registreer</button>
    </form>
    </div>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>

<?php
include 'views/footer.php';
?>
