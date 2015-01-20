<?php

require_once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';

if (isset($_GET['deleteItem']) && sizeof($_SESSION['products']) > 0) {
    $productIndex = $_GET['deleteItem'];
    $i = array_search($productIndex, $_SESSION['products']);
    $subtotal = $_SESSION['subtotal'][$i];
    $_SESSION['total'] -= $subtotal;
    unset($_SESSION['products'][$i]);
    unset($_SESSION['quantities'][$i]);
    unset($_GET['deleteItem']);
    unset($_SESSION['subtotal'][$i]);
    echo '<meta http-equiv="refresh" content="0.1">;';
}

?>

<div class="shopping_cart">
    <p>
    	<br>
    	Winkelwagentje 			
    </p>
    <br>

    <div class="line"> </div>

<?php

// if at least one product is stored in the products array, this if statement
// will be executed to print all the products which have been added to the array
if(isset($_SESSION["products"]) && sizeof($_SESSION["products"]) > 0){   
    $_SESSION['total'] = 0;

    // This for loop goes through all the items stored in the products array,
    // their associated quantities, names, and prices; calculates the total
    // and subtotal, and prints everything to the screen.
    for ($i = 0; $i < sizeof($_SESSION["products"]); $i++) {
    	$productId = $_SESSION["products"][$i];
    	$quantity = $_SESSION["quantities"][$i];
        $sqlQuery = "SELECT name, price FROM Products WHERE id=$productId";
    	$result = $db->query($sqlQuery);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $resultArray = $result->fetch();
        $productName = $resultArray["name"];
        $productPrice = $resultArray["price"];
    	$subtotal = ($productPrice * $quantity);
        $_SESSION['total'] += $subtotal;
        
        echo "
        <table class='shopping_cart_table'>
        <tr>
        <td id ='cartImg'>
        Image
        </td>
        <td>
        $productName
        </td>
        <td>
        Hoeveelheid : $quantity kg
        </td>
        <td>
        <a href='shopping_cart.php?deleteItem=$productId' class='deleteItemLink' >
        Verwijder <span id='deleteItem'>&#xf00d; </span>
        </a>
        </td> 
        <td>
        &euro; $subtotal
        </td>
        </tr>
        </table> ";
            
        // echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';      
        }
        echo '<div class="line"> </div>' . '<br>';

        echo '<div class="shopping_cart_price_total">' .  "Totaal :" . 
                "<span class='icon'> &euro;</span> " .
                $_SESSION['total'] . " euro" . '</div>';
        echo '<div class="shopping_cart_delivery_time"> ' . '<br>'
        . '<span class="icon">&#xf135;levertijd: 1 dag </span> </div>';
} else{
    echo 'Uw winkelwagen is leeg'; 
}

echo '</div>';

include 'views/footer.php';
?>
