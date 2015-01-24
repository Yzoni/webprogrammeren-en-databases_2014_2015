<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';

if(is_customer_logged_in() && !isset($_POST['order_number'])) {
    Order::show_list_orders();
}

if(is_customer_logged_in() && isset($_POST['order_number'])) {
    Order::show_order($_POST['order_number']);
}
?>

<?php
include 'views/footer.php';
?>