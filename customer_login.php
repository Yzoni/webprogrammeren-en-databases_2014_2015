<?php

require_once 'classes.php';
if (isset($_POST['username']) && $_POST['password']) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    Customer::Login($username, $password);
}

if (isset($_GET['fn']) && $_GET['fn'] == "logout") { //ben je er?
    Customer::Logout();
}

include 'views/header.php';
include 'views/navigation.php';
?>
        <div class="formwrapper">
            <h2 class="contenttitle">Inloggen klant: </h2>
            <form action="customer_login.php" method="post">
                <input type="text" name="username" placeholder="voornaam"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <input class="button" type="submit" value="inloggen">
            </form>
        </div>

<?php
include 'views/footer.php';
?>

