<?php
require_once 'classes.php';
security_check_customer();
$order = new Order($_GET['id']);
$order->security_check();
if(isset($_GET['pay']) && $_GET['pay']=="true"){
    $order->pay();
}
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="formwrapper">
    <h2>Mijn bestelling: </h2>
    <?php $order = new Order($_GET['id']);
    $totalprice = 0;
    foreach($order->productids as $productholder){
        $product = new Product($productholder->productid);
        $thisprice = floatval($productholder->quantity) * floatval($product->price);
        $totalprice = $totalprice + $thisprice;
        echo $productholder->quantity." KG ".$product->name." met een prijs/kg van ".$product->price." euro, Kost u: ".$thisprice." euro<br />";
    }
    ?><br/>
    Subtotaal: <?php echo number_format($totalprice, 2, ",","."); ?> piek<br/>
    Inclusief je moeder aan btw (6% op voedingsmiddelen): <?php echo $totalprice*1.06; ?> piek
    <br />
    <br/>
    <br/>
    <?php if($order->paid == 0){ ?>
    <a href="customer_view_order.php?id=<?php echo $order->id;?>&pay=true" class="button pay"><span></span> | Pay zeh bills</a>
    <?php }else{ ?>
    You have paid this order!
    <?php } ?>
</div>
<script type="text/javascript" src="js/checkpassword.js"></script>
<?php
include 'views/footer.php';
?>