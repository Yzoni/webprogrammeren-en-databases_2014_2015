<?php

require once 'classes.php';

include 'views/header.php';
include 'views/navigation.php';
?>

<div class="shopping_cart">
    <p>
    	<br>
    	winkelwagentje 			
    </p>
    <br>

    <div class="line"> </div>
	<div class="ww_con">
		<p class="ww_article">sinaasappels / perssinaasappels</p>
		<a href="#" class="ww_icon"><span class="icon">&#xf129;</span></p>
		<p class="ww_quantity">1 kilo</p>
		<p class="ww_icon"><span class="icon">&#xf153;</span></p>
		<p class="ww_price">EUR 2.20,-</p>
		<a href="#" class="icon">&#xf040;</a>
		<a href="#" class="icon">&#xf00d;</a>
	</div>
    <div class="line"> </div>

    <form action="#">
    	<input type="submit" value="betalen" id="pay">
    </form>

	<ul style="list-style-type:none" >
       	<li> 
        	<div class="shopping_cart_delivery_time">
            	<span class="icon">&#xf135;levertijd: 1 dag </span>
        	</div>        
        </li>
        <li>
        	<div class="shopping_cart_price_total">    
    		    <span class="icon">&#xf153;  totaal: 205.20</span> 
    		</div>               
        </li>
    </ul>
</div>

<?php
include 'views/footer.php';
?>
