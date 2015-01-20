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

include 'views/header.php';
include 'views/navigation.php';
?>
        <div class="formwrapper">
            <h2 class="contenttitle">Inloggen klant: </h2>
            <form action="customer_login.php" method="post">
                <input type="text" name="email" placeholder="email"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <input class="button" type="submit" value="inloggen">
            </form>
            <a href="customer_passwordforgot.php">Wachtwoord vergeten?</a>
		<?php
            if ($credentialsfalse == 1) {
                echo "email of wachtwoord fout";
            }
	?>
        </div>

<?php
include 'views/footer.php';
?>

