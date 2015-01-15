<?php
require_once 'classes.php';
security_check_admin();
include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
<?php
$orders = Order::getAllOrders();
foreach ($orders as $order) {
    $order->displayRow();
}
?>
</div>
<?php
include 'views/footer.php';
?>