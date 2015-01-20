<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$endamount = 5;
$startamount = ($page - 1) * $endamount;
$products = Product::getAllProducts((array_key_exists("id", $_GET) ? $_GET["id"] : null), $startamount);
$totalamount = Product::countProducts((array_key_exists("id", $_GET) ? $_GET["id"] : null));
$totalpages = ceil($totalamount / $endamount);
?>

<div class="wrappercontent">
    <div class="pageswitchwrapper">
        <span>Pagina: </span>
        <?php
        // Get previous page
        if ($page <= 1) {
            $previouspage = $page;
        } else {
            $previouspage = $page - 1;
        }
        
        // Set previous button
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            echo "<a href=\"products.php?id=" . $_GET["id"] . "&page=" . $previouspage . "\">< vorige</a>";
        } else {
            echo "<a href=\"products.php?page=" . $previouspage . "\">< vorige</a>";
        }

        echo " | ";
        
        // Print numbers in case of productypetid
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            for ($i = 1; $i <= $totalpages; $i++) {
                echo "<a href='products.php?id=" . $_GET["id"] . "&page=" . $i . "'>" . $i . "</a> ";
            }
            // Print numbers no productypetid
        } else {
            for ($i = 1; $i <= $totalpages; $i++) {
                echo "<a href='products.php?page=" . $i . "'>" . $i . "</a> ";
            }
        }
        
        echo " | ";
        
        // Get next page
        if ($page < $totalpages) {
            $nextpage = $page + 1;
        } else {
            $nextpage = $page;
        }
        // Set next button
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            echo "<a href=\"products.php?id=" . $_GET["id"] . "&page=" . $nextpage . "\"> volgende ></a>";
        } else {
            echo "<a href=\"products.php?page=" . $nextpage . "\">volgende > </a>";
        }

        ?>


        
        <select onchange=getSortedProducts(this.value)>
            <option value="alphabetic"> A - Z </option>
            <option value="price-desc"> Prijs hoog - laag </option>
            <option value="price-asc"> Prijs laag - hoog </option>            
        </select>


    </div>
        <?php
        foreach ($products as $product) {
            $product->displayBox();
        }
        ?>
</div>
    <?php
    include 'views/footer.php';
    ?>
