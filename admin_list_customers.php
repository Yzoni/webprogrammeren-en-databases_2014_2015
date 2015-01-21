<?php
require_once 'classes.php';
security_check_admin();
include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
    <h2 class="contenttitle">Mijn klanten</h2>
    <?php
    $customers = Customer::getAllCustomers();
    foreach ($customers as $customer) {
        $customer->displayBox();
    }
    ?>
</div>
<?php
include 'views/footer.php';
?>

