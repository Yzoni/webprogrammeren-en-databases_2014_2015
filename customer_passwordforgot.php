<?php

require_once 'classes.php';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    Customer::passwordRecovery($email);
}
Customer::sendMail();

include 'views/header.php';
include 'views/navigation.php';
?>
        <div class="formwrapper">
            <h2 class="contenttitle">Wachtwoord vergeten: </h2>
            <form action="customer_passwordforgot.php" method="post">
                <input type="text" name="email" placeholder="email"><br>
                <input class="button" type="submit" value="verstuur">
            </form>
        </div>
<a href="customer_recoverpassword.php">Heeft u al een code?</a>

<?php
include 'views/footer.php';
?>