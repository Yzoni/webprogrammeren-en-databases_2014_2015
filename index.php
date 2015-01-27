<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>

<div class = "wrappercontent">
    <h2>Uitgelichte producten</h2>
    <?php
    $special = 1; //voor hoofdpagina
    $products = Product::getAllProducts(null, "name", 0, 5, $special);
    foreach ($products as $product) {
        $product->displayBox();
    }
    ?>

</div>

<?php
include 'views/footer.php';
?>
            
