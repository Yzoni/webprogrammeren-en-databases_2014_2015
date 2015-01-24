<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';


$word = $_GET['s'];
$products = Product::search($word);


?>

<div class="wrappercontent">
    <?php
    foreach ($products as $product) {
        $product->displayBox();
    }
    ?>
</div>
<?php
include 'views/footer.php';
?>
