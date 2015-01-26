<?php
session_start();
require_once 'classes.php';
if (!isset($GLOBALS['printAddedProd'])) {
    global $printAddedProd;
    $GLOBALS['printAddedProd'] = 0;
}
if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}

$product = new Product($_GET["id"]);
if (isset($_GET['fn']) && $_GET['fn'] == "deleteproduct" && is_admin_logged_in()) {
    $previousproducttype = $product->type->id;
    $status = $product->delete();
    header("Location: products.php?id=" . $previousproducttype);
    if ($status) {
        $display->addMessage("success", "Product verwijderd");
    } else {
        $display->addMessage("error", "Fout bij het verwijderen van het product");
    }
}

$product = new Product($_GET["id"]);
// If the arrays which will store the products and quantities are not set, then
// create those arrays. A for loop can be used to loop through both arrays.
if (!isset($_SESSION['products']) &&
        !isset($_SESSION['quantities']) &&
        !isset($_SESSION['subtotal'])) {
    $_SESSION['products'] = array();
    $_SESSION['quantities'] = array();
    $_SESSION['subtotal'] = array();
}

// If the user has entered a quantity which is greater than zero and less than the stocklevel, 
// this if statement will add the product and given quantity to the arrays "products"
// and "quantities". Both arrays are stored in the $_SESSION array.
if (isset($_POST['quantity'])) {
    $GLOBALS['printAddedProd'] = 1;
    $quantity = floatval($_POST['quantity']);
    $productId = $product->id;



// !!!BUG ADDING TOO MUCH STOCK TO CART IF DONE IN MULTIPLE TIMES !!!

    
    // array_search and the if statement below will check if there has
    // already been added a quantity of the same type of product in the shopping
    // cart. If there has not, then a new array item will be added, if there has
    // then the old quantity is updated.
    $indexId = array_search($productId, $_SESSION['products']);
    if (!is_numeric($indexId)) {
        array_push($_SESSION['products'], $productId);
        array_push($_SESSION['quantities'], $quantity);
        array_push($_SESSION['subtotal'], ($product->price * $quantity));
    } else {
        $_SESSION['quantities'][$indexId] += $quantity;
        array_push($_SESSION['subtotal'], ($product->price * $quantity));
    }
    $_SESSION['total'] += ($product->price * $quantity);
} else {
    $GLOBALS['printAddedProd'] = 0;
}

include 'views/header.php';
include 'views/navigation.php';
?>


<script>

    function validQuantity() {
        var quantity = document.forms["addToCart"]["quantity"].value;
        var stock = "<?php echo $product->stock ?>";
        if (stock == 0){
            alert("Dit product hebben wij momenteel niet op voorraad");
            return false;
        }    
        if (isNaN(quantity)) {
            alert("U dient cijfers in te vullen");
            return false;
        }        
        if (quantity > stock || quantity <= 0) {
            alert("Vul alstublieft een getal in tussen de 0 en " + stock + " a.u.b. ,\
            meer hebben wij op dit moment niet op voorraad.");
            return false;
        }
    }
</script>

<div class="wrappercontent">
    <div class="contenthead">
        <a href="products.php?id=<?php echo $product->type->id ?>
           "class ="category_product"><?php echo $product->type->name; ?></a> / 
           <?php echo $product->name; ?>
           <?php
           if (is_admin_logged_in()) {
               echo "<div class=\"adminbuttonwrap\">";
               echo "<a href=\"view_product.php?id=$product->id&fn=deleteproduct\" class=\"button_delete\">"
               . "<span class=\"icon\">&#xf00d;</span>verwijder product</a>";
               echo "<a href=\"admin_edit_product.php?id=$product->id\" class=\"button_right\">"
               . "<span class=\"icon\">&#xF040;</span>wijzig product</a>";
               echo "</div>";
           }
           ?>
    </div>
    <div class="hrline"></div>
    <div class="descriptionwrap">
        <div class="descrText"> <?php echo $product->description; ?></div>
        <img class="descrImg" height="114" width="320" src="data:image/png;base64,
             <?php echo base64_encode($product->image); ?>"/>
    </div>
    <div class="hrline"></div>
    <div class="underdescription">
        <ul class="infoList">  
            <li>
                <p class="ProdInfoTxt">
                    <?php
                    echo ($product->stock > 0 ? "<span class=\"stockicongreen\">&#xf00c;" : "<span class=\"stockiconred\">&#xf00d</span>");
                    echo $product->stock;
                    ?> 
                    op voorraad
                </p>
            </li>

            <li>
                <span class="ProdInfoTxt"><p> 
                        <span class="stockicon">&#xf135; </span>
                        levertijd: 1 dag </p>
                </span>
            </li>
            <li>
                <span class="ProdInfoTxt">  <p>      
                        <span class="stockicon">&#xf153; </span> 
                        prijs per kg: 
                        <?php echo $product->price; ?> euro</p>
                </span>
            </li>
        </ul>

        <div class=addToCart>
            <form name="addToCart" class="inputForm" action="" onsubmit="return validQuantity();" method="POST">
                <input type="text" class="inputBox" name="quantity" placeholder="Hoeveelheid (kg)">            
                <button type="submit" class="button"> <span>&#xf0fe;</span>voeg toe 
                </button>
            </form>
        </div>

        <div id="addedProduct">
            <?php
// if a product has been added to the shopping cart this 
// if statement will be executed to notify which product, and 
// quantity has been added.
            if ($GLOBALS['printAddedProd']) {
                echo "U heeft toegevoegd aan uw Winkelwagen: " .
                $product->name . " " .
                $_POST['quantity'] . " kg" . "<br>";
                unset($_POST['quantity']);
                $GLOBALS['printAddedProd'] = 0;
            }
            ?>

        </div>
        <p>
            <a id="backtocategory" href="products.php?id=<?php echo $product->type->id ?>" 
               class="button"><span>&#xf137;</span>terug naar: 
                <?php echo $product->type->name; ?> </a>
        </p>
    </div>
</div>

<?php
include 'views/footer.php';
?>
