<?php
require_once 'classes.php';
if (isset($_POST['username']) && $_POST['password']) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    Customer::Login($username, $password);
}
include 'views/header.php';
include 'views/navigation.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loginpagina</title>
        <link rel="stylesheet" type="text/css" href="style_login.css">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>

        <div class="loginbox">
            <form action="customer_login.php" method="post">
                <input type="text" name="username" placeholder="voornaam"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <input type="submit" value="inloggen">
            </form>
        </div>

    </body>

</html>

<?php
include 'views/footer.php';
?>

