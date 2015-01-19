<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$startamount = ($page - 1) * 5;
$products = Product::getAllProducts((array_key_exists("id", $_GET)?$_GET["id"]:null), $startamount);
$totalamount = Product::countProducts((array_key_exists("id", $_GET)?$_GET["id"]:null));
$totalpages = ceil($totalamount / 5);
?>

<div class="wrappercontent">
    <?php
    if (isset($_GET["id"]) && $_GET["id"] > 0) {
        for ($i = 1; $i <= $totalpages; $i++) {
            echo "<a href='products.php?id=" . $_GET["id"] . "&page=" . $i . "'>" . $i . "</a> ";
        }
    } else {
        for ($i = 1; $i <= $totalpages; $i++) {
            echo "<a href='products.php?page=" . $i . "'>" . $i . "</a> ";
        }
    }
    foreach ($products as $product) {
        $product->displayBox();
    }
    ?>
</div>
<?php
include 'views/footer.php';
?>