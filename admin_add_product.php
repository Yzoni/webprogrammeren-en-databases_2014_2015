<?php
require_once 'classes.php';
include_once 'views/header.php';
include_once 'views/navigation.php';

if (!empty($_POST)) {
    $name = strip_tags($_POST['name']);
    $typeid = strip_tags($_POST['typeid']);
    $description = strip_tags($_POST['description']);
    $price = strip_tags($_POST['price']);
    $stock = strip_tags($_POST['stock']);
    $image = NULL;
    echo $name, $typeid;
    Product::create($typeid, $name, $description, $image, $stock, $price);
} else {
    echo '<form action="admin_add_product.php" method="post">     
    <div class="links_fruit">        
        <input type="text" name="name" placeholder="naam" id="name" > <br>
        <input type="text" name="typeid" placeholder="categorie" id="category" >
        <br>		    
        <div class="beschrijving_product">
            <textarea name="description" id="description_fruit" placeholder=" beschrijving" cols="50" rows="10"></textarea>    
        </div>
    </div>
    <div class="rechts_fruit">
        <input type="text" name="price" placeholder="prijs per stuk" id="price"> <br>
        <input type="text" name="stock" placeholder="voorraad" id="stock"><br>
        <input type="file" name="image" placeholder="plaatje" id="uploadImg">
    </div>
    <input type="submit" value="opslaan" id="submit">  
</form>';
}
include_once 'views/footer.php';
?>