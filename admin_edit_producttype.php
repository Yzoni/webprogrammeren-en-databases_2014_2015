<?php
require_once 'classes.php';
security_check_admin();
if (!isset($_GET['id']) || $_GET['id'] <= 0) {
    echo "No ID given";
    exit();
}
$producttype = new ProductType($_GET["id"]);
if (isset($_POST['name'])) {
    $oldname = $producttype->name;
    $producttype->name = $_POST['name'];
    $status = $producttype->edit();
}
include 'views/header.php';
include 'views/navigation.php';
?>
<h2 class="contenttitle">Categorie wijzigen: </h2>
<?php
$producttype->displayEditForm();
// Check if name is succesfully changed
if (isset($status) && $producttype->name != $oldname) {
    echo "<p>Veranderen van categorienaam gelukt!</p>";
}
include 'views/footer.php';
?>