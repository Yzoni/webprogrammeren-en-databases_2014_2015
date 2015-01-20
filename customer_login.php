<?php

require_once 'classes.php';
if (isset($_POST['email']) && $_POST['password']) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    Customer::Login($username, $password);
}

if (isset($_GET['fn']) && $_GET['fn'] == "logout") {
    Customer::Logout();
}

if (isset($_GET['fn']) && $_GET['fn'] == "credentialsfalse") {
    $display->addMessage("error", "Inloggegevens onjuist");
}

include 'views/header.php';
include 'views/navigation.php';
?>
        <div class="formwrapper">
            <h2 class="contenttitle">Inloggen klant: </h2>
            <form action="customer_login.php" method="post">
                <input type="text" name="email" placeholder="email"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <button type="submit" class="button"><span>&#xf084;</span>login</button><a href="customer_passwordforgot.php" class="button"><span>&#xf059;</span>wachtwoord vergeten?</a>
            </form>
        </div>

<?php
include 'views/footer.php';
?>

