<form action="admin_edit_product.php?id=<?php echo $this->id; ?>" method="post">  
     <div class="links_fruit">        
        <input type="text" name="name" placeholder="naam" id="name" value="<?php echo $this->name ?>"> <br>
        <select name="producttype">
            <?php
            $producttypes_form = ProductType::getAllProductTypes();
            foreach ($producttypes_form as $producttype_form) {
                echo "<option value=\"$producttype_form->id\" ".($this->typeid==$producttype_form->id ? "selected" : "").">$producttype_form->name</option>";
            }
            ?>
        </select>
        <br>		    
        <div class="beschrijving_product">
            <textarea name="description" id="description_fruit" placeholder=" beschrijving" cols="50" rows="10" ><?php echo $this->description ?></textarea>    
        </div>
    </div>
    <div class="rechts_fruit">
        <input type="text" name="price" placeholder="prijs per kg" id="price" value="<?php echo $this->price ?>"> <br>
        <input type="text" name="stock" placeholder="voorraad" id="stock" value="<?php echo $this->stock ?>"><br>
        <input type="file" name="image" placeholder="plaatje" id="uploadImg">
    </div>
    <input type="submit" value="opslaan" id="submit">  
</form>	     		