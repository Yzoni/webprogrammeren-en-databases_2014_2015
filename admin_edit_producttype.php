<?php
require_once 'classes.php';
is_admin_logged_in();
if (!isset($_GET['id']) || $_GET['id'] <= 0) {
    echo "No ID given";
    exit();
}
$producttype = new ProductType($_GET["id"]);
if (isset($_POST['name'])) {
    $producttype->name = $_POST['name'];
    $producttype->edit();
}
include 'views/header.php';
include 'views/navigation.php';
?>
<h2 class="contenttitle">Categorie wijzigen: </h2>
<?php
$producttype->displayEditForm();
include 'views/footer.php';
?>