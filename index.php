<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
    
?>

<div class = "wrappercontent">
    <i><h2>Uitgelichte producten...</h2></i>
    <?php
    $special = 1;
    $products = Product::getAllProducts(null, 0, 5, $special);
    foreach ($products as $product) {
        $product->displayBox();
    }
    ?>

</div>

<?php
include 'views/footer.php';
?>
            