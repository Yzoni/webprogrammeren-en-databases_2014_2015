<?php 
$username = $_POST['username'];
$password = $_POST['password'];
function doLogin() {
    Admin::login($username, $password);
}
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
            <form action="admin_login.php" method="post">
                <input type="text" name="name" placeholder="voornaam"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <input type="submit" value="inloggen">
            </form>
        </div>

    </body>

</html>

