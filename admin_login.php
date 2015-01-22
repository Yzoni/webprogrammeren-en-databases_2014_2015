<?php 
require_once 'classes.php';
if(isset($_POST['username']) && $_POST['password']){
	$username = $_POST['username'];
	$password = $_POST['password'];
	Admin::login($username, $password);
}

if (isset($_GET['fn']) && $_GET['fn'] == "logout") {
    Admin::logout();
}

if (isset($_GET['fn']) && $_GET['fn'] == "credentialsfalse") {
    $display->addMessage("error", "Inloggegevens onjuist");
}


include 'views/header.php';
include 'views/navigation.php';


?>

        <div class="wrappercontent">
            <h2 class="contenttitle">Inloggen Administrator: </h2>
            <form action="admin_login.php" method="post">
                <input type="text" name="username" placeholder="voornaam"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <button type="submit" class="button"><span>&#xf084;</span>login</button>
            </form>
        </div>
<?php
include 'views/footer.php';

?>

