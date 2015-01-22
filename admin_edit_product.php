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
    (isset($_POST['special']) ? $special = 1 : $special = 0);
    $product->special = $special;
    if ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
        $product->image = fopen($_FILES['image']['tmp_name'], 'rb');
    } else {
        $product->image = null;
    }
    if (empty($product->name) || empty($product->price)) {
        $display->addMessage("error", "Productnaam of prijs zijn niet ingevuld");
    } else {
        $status = $product->edit();
        if ($status) {
            $display->addMessage("success", "Product aangepast");
        } else {
            $display->addMessage("error", "Er ging iets fout bij het aanpassen van dit product");
        }
    }
}
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
<h2 class="contenttitle">Product wijzigen: </h2>         

<?php
$product->displayEditForm();
?>
</div>
<?php
include 'views/footer.php';
?>

