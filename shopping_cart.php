<?php

require_once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';
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
if(isset($_SESSION["products"])){   
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
        

        echo '<div class="name">' . $productName. '</div>';
        echo '<div class="quantity">Hoeveelheid : '.$quantity.'</div>';
        echo '<div class="subtotal">' .$subtotal. 'euro </div>';

        echo '<br>';
            
        // echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';      
        }
        echo '<div class="shopping_cart_price_total">' .  "Total :" . 
                $_SESSION['total'] . " euro" . '</div>';
        echo '<div class="shopping_cart_delivery_time"> '
        . '<span class="icon">&#xf135;levertijd: 1 dag </span> </div>';
} else{
    echo 'Your Cart is empty'; 
}
echo '<div class="line"> </div>';
echo '</div>';

include 'views/footer.php';
?>
