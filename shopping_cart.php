<?php

require_once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';
?>


    <p>
    	<br>
    	Winkelwagentje 			
    </p>
    <br>

    <div class="line"> </div>
<?php



if(isset($_SESSION["products"])){   
    $total = 0;
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
        $total += $subtotal;
        

        echo '<div class="customer_Cart">';
        echo '<div class="shopping_cart"> Winkelwagentje </div>';

        echo '<div class="name">' . $productName. '</div>';
        echo '<div class="quantity">Hoeveelheid : '.$quantity.'</div>';
        echo '<div class="subtotal">' .$subtotal. 'euro </div>';

        echo '</div>';
            
        // echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
                 
                   
           
        

           // echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj->product_name.'" />';
           // echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
           // echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$obj->product_desc.'" />';
           // echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
       
            
        }
        	
        echo '<div class="shopping_cart_price_total">' .  "Total :" . $total . "euro" . '</div>';
        echo '<div class="shopping_cart_delivery_time"> <span class="icon">&#xf135;levertijd: 1 dag </span> </div>';
} else{
    echo 'Your Cart is empty'; 
}

echo '<div class="line"> </div>';
include 'views/footer.php';
?>
