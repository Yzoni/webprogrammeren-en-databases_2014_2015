<?php
require_once 'classes.php';
security_check_admin();

$customer = new Customer($_GET['id']);
$_SESSION['customer'] = $customer;

if (isset($_POST['order_number'])) {
    $orderID = $_POST['show_order'];
    show_order($orderID);
    include 'views/footer.php';
    exit();
}

include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
    <h2 class="contenttitle">Gegevens van <?php echo ($customer->gender == 1 ? "dhr. " : "mevr. ") . $customer->lastname . ":" ?></h2>
    <?php $customer->displayCustomerDetails(); ?>
    <a href="admin_list_customers.php" class="button"><span>&#xf137;</span> terug naar alle klanten</a>
    <?php
    echo "<a href=\"admin_confirm_delete_customer.php?id=$customer->id\" class=button_delete><span class=\"icon\">"
    . "&#xf00d;</span> verwijder klant</a>";
    ?>
    <h2 class="contenttitle">Bestellingen door deze klant:</h2>
    
    <?php
    global $db;
    $query = $db->prepare("SELECT * FROM Orders "
            . "WHERE customerid = :id ORDER BY id DESC");
    $query->bindParam(':id', $customer->id, PDO::PARAM_INT);
    $query->execute();
    $ordersArray = $query->fetchAll();
    ?>

    <table>
        <thead>
            <tr>
                <th>Datum</th>
                <th>Order</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < sizeof($ordersArray); $i++) {
                echo "<tr>";
                echo "<td>" . $ordersArray[$i][2] . "</td>";
                echo "<td>" . "<form method=\"post\" action=\"customer_orders.php\"><input type=\"submit\" name=\"order_number\" value=\"" . $ordersArray[$i][0] . "\"></form></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'views/footer.php';
?>

