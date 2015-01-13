<?php

require_once 'classes.php';

// creates the product product
if (isset($_POST['name']) && $_POST['category']) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $stock = $_POST['stock'];
    $image = $_FILES['image'];
    Product::create($name, $description, $image, $stock, $price, $price);
}

include 'views/header.php';
include 'views/navigation.php';
?>

<form action="admin_add_product.php" enctype="multipart/form-data">     
    <div class="links_fruit">        
        <input type="text" name="name" placeholder="naam" id="name" > <br>
        <input type="text" name="category" placeholder="categorie" id="category" >
        <br>		    
        <div class="beschrijving_product">
            <textarea name="description" id="description_fruit" placeholder=" beschrijving" cols="50" rows="10"></textarea>    
        </div>
    </div>
    <div class="rechts_fruit">
        <input type="text" name="price" placeholder="prijs per stuk" id="price"> <br>
        <input type="text" name="stock" placeholder="voorraad" id="stock"><br>
        <input type="file" name="image" placeholder="foto uploaden" id="photo">
    </div>		   	        
    <input type="submit" value="opslaan" id="submit">  
</form>	       		      

    <?php
include 'views/footer.php';
?>
