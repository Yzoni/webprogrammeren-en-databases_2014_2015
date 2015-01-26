<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">

<?php
if(!is_customer_logged_in()) {
    echo "U moet <a href='customer_login.php'>ingelogd </a> "
    . "zijn om deze pagina te bekijken.";
    include 'views/footer.php';
    exit();
}

if(!isset($_POST['order_number'])) {
    Order::show_list_orders();
} else {
    Order::show_order($_POST['order_number']);
}
?>
<h2 class="contenttitle">Uw orders</h2>

</div>
<?php
include 'views/footer.php';
?>
