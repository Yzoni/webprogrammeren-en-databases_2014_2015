<?php
require_once 'classes.php';

if (isset($_GET['id']) && is_admin_logged_in()) {
    $customer = new Customer($_GET["id"]);
} else {
    header("Location: 404page.php");
    exit();
}

if (isset($_GET['confirm']) && $_GET['confirm'] == "y" && is_admin_logged_in()) {
    $customer->delete();
    header('Location: admin_list_customers.php');
}

include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
    <h2 class="contenttitle">Weet u zeker dat u het account van <?php echo ($customer->gender == 1 ? "dhr. " : "mevr. ") . $customer->lastname ?> wilt verwijderen?</h2>

    <form action="admin_confirm_delete_type.php" method="get">
        <?php
        echo "<a class = \"button_delete\" href=\"admin_confirm_delete_customer.php?id=" . $customer->id . "&confirm=y\"><span>&#xf1f8;</span>verwijderen</a>";
        echo "<a class = \"button\" href = \"admin_list_customers.php\"><span>&#xf0e2;</span>annuleer</a>";
        ?>
    </form>
</div>
<?php
include 'views/footer.php';
?>
