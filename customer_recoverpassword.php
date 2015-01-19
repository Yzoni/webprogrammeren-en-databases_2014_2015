<?php
require_once 'classes.php';
if (isset($_POST['email']) && $_POST['password1'] && $_POST['password2']) {
    $code = $_POST['code'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
}

include 'views/header.php';
include 'views/navigation.php';
?>
<div class="formwrapper">
    <h2 class="contenttitle">Wachtwoord vergeten: </h2>
    <form action="customer_passwordforgot.php" method="post">
        <input type="text" name="code" placeholder="herstelcode"><br>
        <input type="text" name="email" placeholder="email"><br>
        <input type="password" name="password1" placeholder="wachtwoord"><br>
        <input type="password" name="password2" placeholder="herhaal wachtwoord"><br>
        <input class="button" type="submit" value="verstuur">
    </form>
</div>

<?php
include 'views/footer.php';
?>