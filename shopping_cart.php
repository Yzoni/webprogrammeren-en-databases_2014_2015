<?php

require_once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';

if (isset($_GET['deleteItem'])) {
    $productId = $_GET['deleteItem'];
    $i = array_search($productId, $_SESSION['products']);
    if($i === 0) {
        $subtotal = $_SESSION['subtotal'][$i];
        $_SESSION['total'] -= $subtotal;        
        array_shift($_SESSION['products']);
        array_shift($_SESSION['quantities']);
        array_shift($_SESSION['subtotal']);
        unset($_GET['deleteItem']);
        unset($_SESSION['dbPullSuccess']);
        echo '<meta http-equiv="refresh" content="0.1">';
    } else if ($i > 0) {
        $subtotal = $_SESSION['subtotal'][$i];
        $_SESSION['total'] -= $subtotal;
        unset($_SESSION['products'][$i]);
        unset($_SESSION['quantities'][$i]);
        unset($_SESSION['subtotal'][$i]);
        unset($_GET['deleteItem']);
        echo '<meta http-equiv="refresh" content="0.1">';
    } else if (sizeof($_SESSION['products']) == 0) {
        $_SESSION['total'] = 0;
        unset($_GET['deleteItem']);
    }
}
?>

<div class="wrappercontent">
    <h2 class="contenttitle">Winkelwagentje </h2>
    <div class="hrline"></div>

<?php

// if at least one product is stored in the products array, this if statement
// will be executed to print all the products which have been added to the array
if(isset($_SESSION["products"]) && sizeof($_SESSION["products"]) > 0){   
    $_SESSION['total'] = 0;
    // This foreach loop goes through all the items stored in the products array,
    // their associated quantities, names, and prices; calculates the total
    // and subtotal, and prints everything to the screen.

    echo "<table class='shopping_cart_table'>";
    foreach ($_SESSION['products'] as $index => $productId) {
    	$productId;
    	$quantity = $_SESSION['quantities'][$index];
        $sqlQuery = "SELECT name, price FROM Products WHERE id=$productId";
    	$result = $db->query($sqlQuery);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $resultArray = $result->fetch();
        $productName = $resultArray["name"];
        $productPrice = $resultArray["price"];
    	$subtotal = ($productPrice * $quantity);
        $_SESSION['total'] += $subtotal;
        echo "
        <thead>
            <tr>
                <th>Categorie</th>
                <th>Productnaam</th>
                <th>Kwantiteit</th>
                <th>Prijs</th>
		<th>Verwijderen</th>
            </tr>
        </thead>
	<p>
        <tr>
        <td>
        category
        </td>
        <td>
        $productName
        </td>
        <td>
        $quantity kg
        </td>
        <td>
        &euro; $subtotal
        </td>
        <td>
        <a href='shopping_cart.php?deleteItem=$productId' class='button_delete'>
        <span>&#xf00d;</span>verwijder</a>
        </td> 
        </tr>
	</p>";
            
        // echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';      
        }
        echo "</table>";

        echo '<div class="shopping_cart_price_total">' .  "Totaal :" . 
                "<span class='icon'> &euro;</span> " .
                $_SESSION['total'] . " euro" . '</div>';
        echo '<div class="shopping_cart_delivery_time"> ' . '<br>'
        . '<span class="icon">&#xf135;levertijd: 1 dag </span> </div>';
        echo "<a href=\"checkout.php\" class=\"button_right\"><span class=\"icon\">&#xF0d1;</span>bestelling afronden</a>";
} else{
    echo 'Uw winkelwagen is leeg'; 
}

echo '</div>';

include 'views/footer.php';
?>
