<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
<?php
if (isset($_GET["id"]) && $_GET["id"] > 0){
    $producttype = new ProductType($_GET["id"]);
    $products = Product::getAllProducts($producttype->id);
}else{
    $products = Product::getAllProducts();
}
foreach ($products as $product) {
    $product->displayBox();
}
?>
</div>
<?php
include 'views/footer.php';
?>