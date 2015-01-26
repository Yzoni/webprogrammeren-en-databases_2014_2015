<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';

if(!is_customer_logged_in()) {
    echo "U moet <a href='customer_login.php'>ingelogd </a> "
    . "zijn om deze pagina te bekijken.";
    include 'views/footer.php';
    exit();
}

if(!isset($_POST['order_number'])) {
    Order::show_list_orders();
} else {
    Order::showOrders($_POST['order_number']);
}
?>

<?php
include 'views/footer.php';
?>