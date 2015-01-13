<?php
require_once 'classes.php';
    $category = $_POST['add_category'];
    ProductType::create($category);
include 'views/header.php';
include 'views/navigation.php';
?>
	<p>
		<br>
		<a href="fruyt.nl/managerpanel" > <font color="#006666"> Managerpanel</font></a> / categorie toevoegen 			
	</p>
	<form action="admin_add_category.php">					
		<input type="text" name="add_category" placeholder="nieuwe categorie" id="add_category"> 
		<input type="submit" value="opslaan" id="submit">		
	</form>	

<?php
include 'views/footer.php';
?>