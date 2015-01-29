<?php

require_once 'classes.php';
if (isset($_POST['email']) && $_POST['password']) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    Customer::Login($email, $password);
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
        <div class="wrappercontent">
            <h2 class="contenttitle">Inloggen klant: </h2>
            <form action="customer_login.php" method="post">
                <input type="text" name="email" placeholder="email"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <button type="submit" class="button"><span>&#xf084;</span>login</button>
            </form>
<?php

if(isset($_SESSION['loginFalse']) && $_SESSION['loginFalse'] = 1) {
    echo "U moet ingelogd zijn om "
    . "af te rekenen. Indien u geen account heeft, "
    . "klik dan op de button om te registreren. <br>"
    . "<a href='customer_register.php' class='button'>"
    . "<span>&#xf14a;</span>registreren</a>";
}
?>
        </div>
<?php
include 'views/footer.php';
?>

