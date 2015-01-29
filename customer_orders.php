<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
    <h2 class="contenttitle">Uw orders</h2>
    <?php
    if (!is_customer_logged_in() && !$_SESSION['admin_logged_in'] == 1) {
        echo "U moet <a href='customer_login.php'>ingelogd </a> "
        . "zijn om deze pagina te bekijken.";
        include 'views/footer.php';
        exit();
    }
    ?>
    <?php
    global $db;
    $query = $db->prepare("SELECT * FROM Orders WHERE customerid = :id");
    $query->bindParam(':id', $customer->id, PDO::PARAM_INT);
    $query->execute();
    $ordersArray = $query->fetchAll();
    if (!isset($_POST['order_number'])) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Order nummer</th>
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
        <?php
    } else {
        Order::show_order($_POST['order_number']);
        if(isset($_SESSION['admin_logged_in']) && 
                $_SESSION['admin_logged_in'] == 1) {
            global $db;
            $query = $db->query("SELECT customerid FROM Orders WHERE "
                    . "id=" . $_POST['order_number']);
            $row = $query->fetch();
            $customerID = $row['customerid'];
            echo "<a href='admin_view_customer.php?id=$customerID' "
                    . "class='button'>"
            . "<span>&#xf137;</span>terug naar klant</a>";            
        } else {
            echo "<a href='customer_orders.php' class='button'>"
            . "<span>&#xf137;</span>uw orders</a>";
        }
    }
    ?>
</div>
<?php
include 'views/footer.php';
?>
