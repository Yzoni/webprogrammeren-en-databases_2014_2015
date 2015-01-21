<?php
require_once 'classes.php';
security_check_admin();

$customer = new Customer($_GET['id']);

if (isset($_GET['fn']) && $_GET['fn'] == "deletecustomer" && is_admin_logged_in()) {
    $status = $customer->delete();
    header("Location: admin_list_customers.php");
    if ($status) {
        $display->addMessage("success", "Klant verwijderd");
    } else {
        $display->addMessage("error", "Fout bij het verwijderen van deze klant");
    }
}

include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
    <h2 class="contenttitle">Gegevens van <?php echo ($customer->gender == 1 ? "dhr. " : "mevr. ") . $customer->lastname . ":"?></h2>
    <?php $customer->displayCustomerDetails(); ?>
    <a href="admin_list_customers.php" class="button"><span>&#xf137;</span> terug naar alle klanten</a>
    <?php
    echo "<a href=\"admin_view_customer.php?id=$customer->id&fn="
    . "deletecustomer\" class=button_delete><span class=\"icon\">"
    . "&#xf00d;</span> verwijder klant</a>";
    ?>
    <h2 class="contenttitle">Bestellingen door deze klant:</h2>
    <p>>view van lijst met bestellingen<</p>
</div>

<?php
include 'views/footer.php';
?>

