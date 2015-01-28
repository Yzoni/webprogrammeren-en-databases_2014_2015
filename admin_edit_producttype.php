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

include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
    <h2 class="contenttitle">Categorie wijzigen / verwijderen: </h2>
    <?php
    $producttype->displayEditForm();
    echo "<a href=\"admin_confirm_delete_type.php?id=$producttype->id\" class=button_delete>"
    . "<span class=\"icon\">&#xf00d;</span> verwijder productcategorie</a>";
    ?>
</div>
<?php
include 'views/footer.php';
?>
