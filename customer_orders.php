<?php
require_once 'classes.php';
security_check_customer();
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="formwrapper">
    <h2>Mijn bestellingen: </h2>
    <?php 
    if($order = Order::getLatestOrder($_SESSION['customer_id'])){ // en soort combi tussen if en variabele set?>
    Mijn winkelkarretje: <a href="customer_view_order.php?id=<?php echo $order->id; ?>">staat hier om de hoek</a><Br/><br/><br/>
    <?php } ?><br/>
    <h2>Geschiedenis: </h2>
    <?php $orders = Order::getAllOrders($_SESSION['customer_id']);
    foreach($orders as $order){
        ($order->paid==1) ? $order->displayRow() : "";
    }
    ?>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>
<?php
include 'views/footer.php';
?>