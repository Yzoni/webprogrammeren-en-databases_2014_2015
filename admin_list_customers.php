<?php
require_once 'classes.php';
security_check_admin();
include 'views/header.php';
include 'views/navigation.php';
$customers = Customer::getAllCustomers();
?>

<div class="wrappercontent">
    <h2 class="contenttitle">Mijn klanten</h2>
    <table>
        <thead>
            <tr>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($customers as $customer) {
                echo "<tr>";
                echo "<td>" . $customer->firstname . "</std>";
                echo "<td>" . $customer->lastname . "</td>";
                echo "<td>" . $customer->email . "</td>";
                echo "<td> <a href=\"admin_view_customer.php?id=" . $customer->id . "\" class=\"button_rechts\"><span class=\"icon\">&#xF129;</span>details</a></td";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'views/footer.php';
?>

