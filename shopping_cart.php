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
<?php

// if at least one product is stored in the products array, this if statement
// will be executed to print all the products which have been added to the array
if(isset($_SESSION["products"]) && sizeof($_SESSION["products"]) > 0){   
    $_SESSION['total'] = 0;
    // This foreach loop goes through all the items stored in the products array,
    // their associated quantities, names, and prices; calculates the total
    // and subtotal, and prints everything to the screen.

    echo "<table class='shopping_cart_table'>";
    echo "
	<thead>
            <tr>
                <th>Categorie</th>
                <th>Productnaam</th>
                <th>Kwantiteit</th>
                <th>Prijs</th>
		<th></th>
            </tr>
        </thead>";
	
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
        <tr>
        <td>
        category
        </td>
        <td>
        <a href='view_product.php?id=$productId' class='productpagelink'>$productName</a>
        </td>
        <td>
        $quantity kg
        </td>
        <td>
        &euro; $subtotal
        </td>
        <td width='32'>
        <a href='shopping_cart.php?deleteItem=$productId' class='button_delete'>verwijder</a>
        </td> 
        </tr>";
            
        // echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';      
        }
        echo "</table>";

        echo "<h2 class='totalprice'>totaalprijs: &euro;";
                $_SESSION['total'] . "<br>";
        echo "<span class=\"icon\">&#xf135;<span>levertijd: 1 dag<br></p>";
        echo "<a href='checkout.php' class='button_right'><span class='icon'>&#xf0d1;</span>bestelling afronden</a>";
} else{
    echo 'Uw winkelwagen is leeg'; 
}

echo '</div>';

include 'views/footer.php';
?>
