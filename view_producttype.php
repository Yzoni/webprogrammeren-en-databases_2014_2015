<?php

require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';

$producttype = new ProductType($_GET["id"]);

$products = Product::getAllProducts($producttype->id);
foreach ($products as $product) {
    $product->displayBox();
}

include 'views/footer.php';

?>