<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>

<div class="wrappercontent">
<?php
$products = Product::getAllProducts();
foreach ($products as $product) {
    $product->displayBox();
}
?>
</div>
<?php
include 'views/footer.php';
?>