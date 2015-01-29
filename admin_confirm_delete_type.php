<?php
require_once 'classes.php';

if (isset($_GET['id']) && is_admin_logged_in()) {
    $producttype = new ProductType($_GET["id"]);
    $products = Product::getAllProducts($producttype->id);
} else {
    header("Location: 404page.php");
}

if (isset($_GET['confirm']) && $_GET['confirm'] == "y" && is_admin_logged_in()) {
    $status = $producttype->delete();
    foreach ($products as $product) {
        $product->delete();
    }
    header('Location: products.php');
}

include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
    <h2 class="contenttitle">Weet u zeker dat u de categorie <?php echo $producttype->name ?> EN de volgende producten wilt verwijderen?</h2>
    <?php
    $productscount = Product::countProducts($producttype->id);
    if ($productscount > 0) {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Product naam</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product->name . "</td>";
            echo "</tr>";
        }

        echo "<tbody>";
        echo "</table>";
    } else {
        echo "Deze categorie is leeg";
    }
    ?>

    <form action="admin_confirm_delete_type.php" method="get">
        <?php
        echo "<a class = \"button_delete\" href=\"admin_confirm_delete_type.php?id=" . $producttype->id . "&confirm=y\"><span>&#xf1f8;</span>verwijderen</a>";
        echo "<a class = \"button\" href = \"admin_edit_producttype.php?id=" . $producttype->id . "\"><span>&#xf0e2;</span>annuleer</a>";
        ?>
    </form>
</div>
<?php
include 'views/footer.php';
?>
