<?php
require_once 'classes.php';
security_check_admin();
if (!isset($_GET['id']) || $_GET['id'] <= 0) {
    echo "No ID given";
    exit();
}

$producttype = new ProductType($_GET["id"]);
if (isset($_POST['name'])) {
    $producttype->name = $_POST['name'];
    $status = $producttype->edit();
    $display->addMessage("succes", "Categorie veranderd!");
}

if (isset($_GET['fn']) && $_GET['fn'] == "deleteproducttype" && is_admin_logged_in()) {
    $status = $producttype->delete();
    header("Location: products.php");
    if ($status) {
        $display->addMessage("success", "Product verwijderd");
    } else {
        $display->addMessage("error", "Fout bij het verwijderen van het product");
    }
}

include 'views/header.php';
include 'views/navigation.php';
?>
<h2 class="contenttitle">Categorie wijzigen / verwijderen: </h2>
<?php
$producttype->displayEditForm();
echo "<a href=\"admin_edit_producttype.php?id=$producttype->id&fn=deleteproducttype\" class=button>"
 . "<span class=\"icon\">&#xf00d; verwijder productcategorie </span></a>";
include 'views/footer.php';
?>
