<?php
require_once 'classes.php';
security_check_customer();

include 'views/header.php';
include 'views/navigation.php';
echo $_SESSION["customer_id"];
$customer = new Customer($_SESSION['customer_id']);
?>
<div class="formwrapper">
    <h2>Wijzig gegevens: </h2>
    <?php $customer->displayEditForm();?>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>
<?php
include 'views/footer.php';
?>