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
    $image = (isset($_FILES['image']) ? fopen($_FILES['image']['tmp_name'], 'rb') : "");
    $status = Product::create($typeid, $name, $description, $stock, $price, $image);
    if ($status) {
        $display->addMessage("success", "Product toegevoegd");
    } else {
        $display->addMessage("error", "Er ging iets fout bij het toevoegen van dit product");
    }
}
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
<h2 class="contenttitle">Product toevoegen: </h2>
<form action="admin_add_product.php" method="POST" enctype="multipart/form-data">     
    <div class="links_fruit">        
        <input type="text" name="name" placeholder="naam" id="name"> <br>
        <select name="producttype">
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
    </div>
    <div class="rechts_fruit">
        <input type="text" name="price" placeholder="prijs per stuk" id="price"> <br>
        <input type="text" name="stock" placeholder="voorraad" id="stock"><br>
        <input type="file" name="image" id="uploadImg">
    </div>
    <button type="submit" class="button"><span>&#xf0fe;</span>toevoegen</button>  
</form>	       		      
</div>
<?php
include 'views/footer.php';
?>

