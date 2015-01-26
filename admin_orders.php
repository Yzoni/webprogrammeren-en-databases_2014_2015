<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
<h2 class="contenttitle">Alle orders</h2>
<?php
if(!is_admin_logged_in()) {
    echo "U dient ingelogd te zijn als <a href='admin_login.php'> beheerder </a>" .
    "om deze pagina te bekijken.";
    include 'views/footer.php';
    exit();
}

if(!isset($_POST['order_number'])) {
    Admin::show_order_list();
} else {
    Admin::show_order($_POST['order_number']);
}
?>

</div>

<?php
include 'views/footer.php';
?>
