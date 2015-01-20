<?php
session_start();
if(!isset($GLOBALS['printAddedProd'])) {
    global $printAddedProd;
    $GLOBALS['printAddedProd'] = 0;
}
if(!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}
require_once 'classes.php';

$product = new Product($_GET["id"]);
// If the arrays which will store the products and quantities are not set, then
// create those arrays. A for loop can be used to loop through both arrays.
if (!isset($_SESSION['products']) && !isset($_SESSION['quantities'])) {
    $_SESSION['products'] = array();
    $_SESSION['quantities'] = array();
}

// If the user has entered a quantity which is greater than zero, this if
// statement will add the product and given quantity to the arrays "products"
// and "quantities". Both arrays are stored in the $_SESSION array.
if(isset($_POST['quantity']) && floatval($_POST['quantity'] > 0)){
    $GLOBALS['printAddedProd'] = 1;
    $quantity = floatval($_POST['quantity']);
    $productId = $product->id;
    
    // array_search and the if statement below will check if there has
    // already been added a quantity of the same type of product in the shopping
    // cart. If there has not, then a new array item will be added, if there has
    // then the old quantity is updated.
    $indexId = array_search($productId, $_SESSION['products']);
    if(!is_numeric($indexId)) {
        array_push($_SESSION['products'], $productId);
        array_push($_SESSION['quantities'], $quantity);

    } else {
        $_SESSION['quantities'][$indexId] += $quantity;
    }
    $_SESSION['total'] += ($product->price * $quantity);
} else {
        $GLOBALS['printAddedProd'] = 0;
}

include 'views/header.php';
include 'views/navigation.php';

$product = new Product($_GET["id"]);

?>
<div class="description">

    <div>
        <br>
        <a href="products.php?id=<?php echo $product->type->id ?>
        "class="category"><?php echo $product->type->name; ?></a> / 
            <?php echo $product->name; ?>
        <?php
        if (is_admin_logged_in()) {
            echo "<a href=\"admin_edit_product.php?id=$product->id\">"
                . "<span class=\"icon\">&#xF040; </span></a>";
        }
        ?>
    </div>

    <br>
    <hr>
    
    <br>
    <span class="descrText"> <?php echo $product->description; ?></span>
    <img class="descrImg" src="data:image/png;base64,
        <?php echo base64_encode($product->image); ?>"/>
    <br>
    <hr>
    
    <br>

    <p>
    <ul class="infoList">


        <li>
            <span class="prodInfoTxt">
                <span class="icon-ok">&#xf00c;</span>
                <?php echo $product->stock; ?> op voorraad
            </span>
            <form class="inputForm" action="" method="POST">
                
                <?php
                if (is_admin_logged_in() == false) {
                    echo 'aantal: <input type="text" class="inputBox" '
                    . 'name="quantity">';
                    echo '<input class="voegToe" type ="submit" '
                    . 'value= "&#xf0fe;'
                    . ' | voeg toe">';
                }
                ?>
            </form>
        </li>
        <br>
        <br>

        <li>
            <span class="prodInfoTxt"> 
                <span class="icon">&#xf135; </span>
                levertijd: 1 dag
            </span>
        </li>
        <br>
        <br>

        <li>
            <span class="prodInfoTxt">
                <span class="icon">&#xf153; </span>
                prijs per kg:  <?php echo $product->price; ?>
            </span>
        </li>
        </p>
        <br>
        <br>
    </ul>

    <div id="addedProduct">
                <?php
                // if a product has been added to the shopping cart this 
                // if statement will be executed to notify which product, and 
                // quantity has been added.
                if($GLOBALS['printAddedProd']) {
                    echo "U heeft toegevoegd aan uw Winkelwagen: " . 
                        $product->name . " " .
                        $_POST['quantity'] . " kg" . "<br>";
                    unset($_POST['quantity']);
                    echo '<meta http-equiv="refresh" content="5">';
                    $GLOBALS['printAddedProd'] = 0;
                }
                ?>
    </div>
    <br>
    <br>

    <p>
        <br>
        <a href="products.php?id=<?php echo $product->type->id ?>" 
           class="button"> &#xf053; | terug naar: 
               <?php echo $product->type->name; ?> </a>
    </p>
</div>

<?php
include 'views/footer.php';
?>
