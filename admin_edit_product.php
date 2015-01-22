<?php
require_once 'classes.php';
security_check_admin();
// creates the product product
if (!isset($_GET['id']) || $_GET['id'] <= 0) {
    echo "No ID given";
    exit();
}
$product = new Product($_GET['id']);
if (isset($_POST['name'])) {
    $product->name = $_POST['name'];
    $product->typeid = $_POST['producttype'];
    $product->description = $_POST['description'];
    $product->price = $_POST['price'];
    $product->stock = $_POST['stock'];
    if (isset($_FILES['image'])) {
        $product->image = fopen($_FILES['image']['tmp_name'], 'rb');
    } else {
        NULL;
    }
    $status = $product->edit();
    if ($status) {
        $display->addMessage("success", "Product aangepast");
    } else {
        $display->addMessage("error", "Er ging iets fout bij het aanpassen van dit product");
    }
}
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
<h2 class="contenttitle">Product wijzigen: </h2>         
</div>
<?php
$product->displayEditForm();

include 'views/footer.php';
?>

