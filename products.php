<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
<<<<<<< HEAD
$sortorder = "name";
if (isset($_GET["sortorder"])) {
    $sortorder = $_GET["sortorder"];
} 

$endamount = 5;
$startamount = ($page - 1) * $endamount;
$products = Product::getAllProducts((array_key_exists("id", $_GET) ? $_GET["id"] : null), $sortorder, $startamount);
=======
$endamount = 10;
$startamount = ($page - 1) * $endamount;
$products = Product::getProducts((array_key_exists("id", $_GET) ? $_GET["id"] : null), $startamount, $endamount);
>>>>>>> 8184faf7027736524c6e78a88bc84f9d6832ecda
$totalamount = Product::countProducts((array_key_exists("id", $_GET) ? $_GET["id"] : null));
$totalpages = ceil($totalamount / $endamount);
?>

<div class="wrappercontent">
    <div class="pageswitchwrapper">
        <?php
        // Get previous page
        if ($page <= 1) {
            $previouspage = $page;
        } else {
            $previouspage = $page - 1;
        }

        // Set previous button
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            echo "<a href=\"products.php?id=" . $_GET["id"] . "&page=" . $previouspage . "\" class=\"button\"><span>&#xf137;</span>vorige</a>";
        } else {
            echo "<a href=\"products.php?page=" . $previouspage . "\" class=\"button\"><span>&#xf137;</span>vorige</a>";
        }

        // Print numbers in case of producttypeid
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            for ($i = 1; $i <= $totalpages; $i++) {
                // Give current page id "currentpage"
                if (isset($_GET["page"])) {
                    if ($_GET["page"] == $i) {
                        echo "<a id=\"currentpage\" href='products.php?id=" . $_GET["id"] . "&page=" . $i . "'>" . $i . "</a> ";
                    } else {
                        echo "<a href='products.php?id=" . $_GET["id"] . "&page=" . $i . "'>" . $i . "</a> ";
                    }
                } else {
                    // In case of no page in get
                    echo ($i == 1 ? "<a id=\"currentpage\" href='products.php?id=" . $_GET["id"] . "&page=" . $i . "'>" . $i . "</a> " : "<a href='products.php?id=" . $_GET["id"] . "&page=" . $i . "'>" . $i . "</a> ");
                }
            }
            // Print numbers no productypetid
        } else {
            for ($i = 1; $i <= $totalpages; $i++) {
                if (isset($_GET["page"])) {
                    // Give current page id "currentpage"
                    if ($_GET["page"] == $i) {
                        echo "<a id=\"currentpage\" href='products.php?page=" . $i . "'>" . $i . "</a> ";
                    } else {
                        echo "<a href='products.php?page=" . $i . "'>" . $i . "</a> ";
                    }
                } else {
                    //In case of no page in get
                    echo ($i == 1 ? "<a id=\"currentpage\" href='products.php?page=" . $i . "'>" . $i . "</a> " : "<a href='products.php?page=" . $i . "'>" . $i . "</a> ");
                }
            }
        }


        // Get next page
        if ($page < $totalpages) {
            $nextpage = $page + 1;
        } else {
            $nextpage = $page;
        }
        // Set next button
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            echo "<a href=\"products.php?id=" . $_GET["id"] . "&page=" . $nextpage . "\" class=\"button\"><span>&#xf138;</span>volgende</a>";
        } else {
            echo "<a href=\"products.php?page=" . $nextpage . "\" class=\"button\"><span>&#xf138;</span>volgende</a>";
        }
        ?>

        <form method="GET" action="products.php">
            <select class="select_order" name="sortorder" onchange="form.submit()">
                <option> Kies de volgorde </option>    
                <option value="name"> A - Z </option>
                <option value="price"> Prijs hoog - laag </option>
                <option value="price"> Prijs laag - hoog </option>            
            </select>
        </form>
<<<<<<< HEAD
=======
        
        
        <?php 
        if (isset($_GET['select_order'])){
            $sorting_order = $_GET['select_order'];
            Product::getProducts($sorting_order);
        } else {
            echo ' huilen dit';
        } 
       
        ?> 
        
 


>>>>>>> 8184faf7027736524c6e78a88bc84f9d6832ecda
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
