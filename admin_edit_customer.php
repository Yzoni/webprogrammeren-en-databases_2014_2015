<?php
require_once 'classes.php';
security_check_admin();
if (isset($_POST['email'])) {  
    $customer = new Customer($_GET['id']);
    $customer->email = ($_POST['email']!="") ? $_POST['email'] : $customer->email;
    $customer->changePasswordAdmin($_POST['password'], $_POST['password2']);
    $customer->zip = ($_POST['zip']!="") ? $_POST['zip'] : $customer->zip;
    $customer->streetnumber = ($_POST['streetnumber']!="") ? $_POST['streetnumber'] : $customer->streetnumber;
    $customer->streetaddress = ($_POST['streetaddress']!="") ? $_POST['streetaddress'] : $customer->streetnumber;
    $customer->firstname = ($_POST['firstname']!="") ? $_POST['firstname'] : $customer->firstname;
    $customer->lastname = ($_POST['lastname']!="") ? $_POST['lastname'] : $customer->lastname;
    $customer->gender = ($_POST['gender']=="true") ? true : false;
    $customer->edit();
}

include 'views/header.php';
include 'views/navigation.php';
$customer = new Customer($_GET['id']);
?>
<div class="formwrapper">
    <h2>Wijzig gegevens: </h2>
    <?php $customer->displayEditForm();?>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>
<?php
include 'views/footer.php';
?>