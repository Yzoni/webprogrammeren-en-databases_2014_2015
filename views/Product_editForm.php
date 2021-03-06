<form action="admin_edit_product.php?id=<?php echo $this->id; ?>" method="post" enctype="multipart/form-data">  
     <div class="links_fruit">        
        <input type="text" name="name" placeholder="naam" id="name" value="<?php echo $this->name ?>"> <br>
        <select name="producttype" class="select_category">
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
        Toon op homepage: <input value="<?php $this->special ?>" type="checkbox" name="special" <?php echo ($this->special == 1 ? "checked": "") ?>><br>
        <input type="file" name="image" class="upload_image">
    </div>
    <button type="submit" id="submit" class="button"><span>&#xf0c7;</span>opslaan</button> 
</form>	     		
