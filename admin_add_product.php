<?php
require_once 'classes.php';
security_check_admin();
// creates the product product
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $typeid = $_POST['producttype'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    (isset($_POST['special']) ? $special = 1 : $special = 0);
    $allowedimagetypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
    $detectedimagetype = ($_FILES['image']['tmp_name']!="" ? exif_imagetype($_FILES['image']['tmp_name']) : "");
    if (in_array($detectedimagetype, $allowedimagetypes) && $_FILES["image"]["size"] < 2000000) {
        $image = ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE ? fopen($_FILES['image']['tmp_name'], 'rb') : null);
    } else if($detectedimagetype==""){
        $display->addMessage("notice", "Ondanks dat u geen afbeelding heeft geupload is het toch... ");
        $image = null;
    } else {
        $display->addMessage("error", "Afbeelding te groot of bestand is geen jpg of png");
    }
    if (empty($name) || empty($price)) {
        $display->addMessage("error", "Productnaam of prijs zijn niet ingevuld");
    } else {
        $status = Product::create($typeid, $name, $description, $stock, $price, $special, $image);
        if ($status) {
            $display->addMessage("success", "Product toegevoegd");
        } else {
            $display->addMessage("error", "Er ging iets fout bij het toevoegen van dit product");
        }
    }
}
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
    <h2 class="contenttitle">Product toevoegen: </h2>
    <form action="admin_add_product.php" method="POST" enctype="multipart/form-data">     

        <input type="text" name="name" placeholder="naam" id="name"> <br>
        <select name="producttype" class="select_category">
            <?php
            $producttypes_form = ProductType::getAllProductTypes();
            foreach ($producttypes_form as $producttype_form) {
                echo "<option value=\"$producttype_form->id\">$producttype_form->name</option>";
            }
            ?>
        </select>
        <br>		    
        <div class="beschrijving_product">
            <textarea name="description" id="description_fruit" placeholder=" beschrijving" cols="50" rows="10"></textarea>    
        </div>
        <input type="text" name="price" placeholder="prijs per stuk" id="price"> <br>
        <input type="text" name="stock" placeholder="voorraad" id="stock"><br>
        Toon op homepage: <input value="1" type="checkbox" name="special"><br>
        <input type="file" name="image" class="upload_image"><br>
        <button type="submit" class="button"><span>&#xf0fe;</span>toevoegen</button>  
    </form>	       		      
</div>
<?php
include 'views/footer.php';
?>

