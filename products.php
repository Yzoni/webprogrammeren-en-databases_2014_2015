<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

if (isset($_GET["sort"])) {
    $sort = $_GET["sort"];
} else {
    $sort = "named";
}

function checkSort($sort) {
    if ($sort == "named") {
        return "name DESC";
    } elseif ($sort == "namea") {
        return "name ASC";
    } elseif ($sort == "priced") {
        return "CAST(price as decimal) DESC";
    } elseif ($sort == "pricea") {
        return "CAST(price as decimal) ASC";
    } else {
        return "name ASC";
    }
}

$sortorder = checkSort($sort);

if (array_key_exists("amount", $_GET)) {
    $endamount = intval($_GET["amount"]);
} else {
    $endamount = 6;
}

$startamount = ($page - 1) * $endamount;
$products = Product::getAllProducts((array_key_exists("id", $_GET) ? $_GET["id"] : null), $sortorder, $startamount, $endamount, 0);
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
            echo "<a href=\"products.php?id=" . $_GET["id"] . "&page=" . $previouspage . "&sort=" . $sort . "&amount=" . $endamount . "\" class=\"button\"><span>&#xf137;</span>vorige</a>";
        } else {
            echo "<a href=\"products.php?page=" . $previouspage . "&sort=" . $sort . "&amount=" . $endamount ."\" class=\"button\"><span>&#xf137;</span>vorige</a>";
        }

        // Print numbers in case of producttypeid
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            for ($i = 1; $i <= $totalpages; $i++) {
                // Give current page id "currentpage"
                if (isset($_GET["page"])) {
                    if ($_GET["page"] == $i) {
                        echo "<a id=\"currentpage\" href='products.php?id=" . $_GET["id"] . "&page=" . $i . "&sort=" . $sort . "&amount=" . $endamount ."'>" . $i . "</a> ";
                    } else {
                        echo "<a href='products.php?id=" . $_GET["id"] . "&page=" . $i . "&sort=" . $sort . "&amount=" . $endamount ."'>" . $i . "</a> ";
                    }
                } else {
                    // In case of no page in get
                    echo ($i == 1 ? "<a id=\"currentpage\" href='products.php?id=" . $_GET["id"] . "&page=" . $i . "&sort=" . $sort . "&amount=" . $endamount ."'>" . $i . "</a> " : "<a href='products.php?id=" . $_GET["id"] . "&page=" . $i . "'>" . $i . "</a> ");
                }
            }
            // Print numbers no productypetid
        } else {
            for ($i = 1; $i <= $totalpages; $i++) {
                if (isset($_GET["page"])) {
                    // Give current page id "currentpage"
                    if ($_GET["page"] == $i) {
                        echo "<a id=\"currentpage\" href='products.php?page=" . $i . "&sort=" . $sort . "&amount=" . $endamount ."'>" . $i . "</a> ";
                    } else {
                        echo "<a href='products.php?page=" . $i . "&sort=" . $sort . "&amount=" . $endamount ."'>" . $i . "</a> ";
                    }
                } else {
                    //In case of no page in get
                    echo ($i == 1 ? "<a id=\"currentpage\" href='products.php?page=" . $i . "&sort=" . $sort . "&amount=" . $endamount ."'>" . $i . "</a> " : "<a href='products.php?page=" . $i . "&sort=" . $sort . "'>" . $i . "</a> ");
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
            echo "<a href=\"products.php?id=" . $_GET["id"] . "&page=" . $nextpage . "&sort=" . $sort . "&amount=" . $endamount ."\" class=\"button\"><span>&#xf138;</span>volgende</a>";
        } else {
            echo "<a href=\"products.php?page=" . $nextpage . "&sort=" . $sort . "&amount=" . $endamount ."\" class=\"button\"><span>&#xf138;</span>volgende</a>";
        }
        ?>
        <div class="dropdownproducts">
            <form method="GET" action="">
                <input type="hidden" name="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : ""); ?>" />
                <select id="select_amount" class="selecter" name="amount" onchange="form.submit()">
                    <option value="6"> Items per pagina </option>    
                    <option value="4" <?php echo ((isset($_GET['amount'])&&$_GET['amount']=="4") ? "selected" : ""); ?>> 4 producten </option>
                    <option value="6"> 6 producten </option> 
                    <option value="8" <?php echo ((isset($_GET['amount'])&&$_GET['amount']=="8") ? "selected" : ""); ?>> 8 producten </option>            
                </select>
                <select id="select_order" class="selecter" name="sort" onchange="form.submit()">
                    <option value="namea"> Sorteer op</option>    
                    <option value="namea"> A - Z </option>
                    <option value="priced" <?php echo ((isset($_GET['sort'])&&$_GET['sort']=="priced") ? "selected" : ""); ?>> Prijs hoog - laag </option>
                    <option value="pricea" <?php echo ((isset($_GET['sort'])&&$_GET['sort']=="pricea") ? "selected" : ""); ?>> Prijs laag - hoog </option>            
                </select>
            </form>
        </div>
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
