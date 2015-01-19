<?php

require_once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';

if(isset($_SESSION["products"])){
	echo '<form method="post" action="PAYMENT-GATEWAY">';
	$total = 0;
	$cart_items = 0;
	$currency = €;
}
?>


    <p>
    	<br>
    	Winkelwagentje 			
    </p>
    <br>

    <div class="line"> </div>
<?php

    for ($i = 0; i < size($_SESSION["products"]); $i++) {
    	$id = $_SESSION["products"][$i];
    	$quantity = $_SESSION["quantity"][$i]
    	$result = $db->query("SELECT name, price FROM Products WHERE id='$id' LIMIT 1");

    	//	$obj = $results->fetch_object();

    	$subtotal = ($result->price * $quantity);
        $total = ($total + $subtotal);     
        

        echo '<div class="customer_Cart">';
        echo '<div class="shopping_cart"> Winkelwagentje </div>';

        <br>

        echo '<div class="name">' .$result->name. '</div>';
        echo '<div class="quantity">Hoeveelheid : '.$quantity.'</div>';
        echo '<div class="subtotal">'.$currency .$subtotal. '</div>';

        echo '</div>';
            
        // echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
                 
                   
           
        

           // echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj->product_name.'" />';
           // echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
           // echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$obj->product_desc.'" />';
           // echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
        $cart_items ++;
            
        }
        	
        	
        echo '<div class="shopping_cart_price_total">'  Total : .$currency. $total.'</div>';
        echo '<div class="shopping_cart_delivery_time"> <span class="icon">&#xf135;levertijd: 1 dag </span> </div>'


	

    <form action="#">
    	<input type="submit" value="betalen" id="pay">    	
    </form>
      
}else{
	echo 'Your Cart is empty';
}

<div class="line"> </div>

include 'views/footer.php';
?>
