<?php

require_once 'classes.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
is_admin_logged_in();


require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>

<p>
    <br>
    <a href="fruyt.nl/managerpanel" > <font color="#006666"> Managerpanel</font></a> / product toevoegen 			
</p>
<form action="#">					
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
        <input type="text" name="quantity" placeholder="hoeveelheid" id="quantity"><br>
        <input type="text" name="stock" placeholder="voorraad" id="stock"><br>
        <input type="file" name="photo" placeholder="foto uploaden" id="photo">
    </div>					
    <input type="submit" value="opslaan" id="submit">		
</form>	
<?php

include 'views/footer.php';
?>