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
$credentialsfalse = 0;
if (isset($_GET['fn']) && $_GET['fn'] == "credentialsfalse") {
    $credentialsfalse = 1;
}


include 'views/header.php';
include 'views/navigation.php';


?>

        <div class="formwrapper">
            <h2 class="contenttitle">Inloggen Administrator: </h2>
            <form action="admin_login.php" method="post">
                <input type="text" name="username" placeholder="voornaam"><br>
                <input type="password" name="password" placeholder="wachtwoord"><br>
                <input class="button" type="submit" value="inloggen">
            </form>
            <?php
            if ($credentialsfalse == 1) {
            $display->addMessage("succes", "Categorie veranderd!");
            }
?>
        </div>
<?php
include 'views/footer.php';

?>

