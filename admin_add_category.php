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
	<form action="admin_add_category.php" method="post">					
		<input type="text" name="add_category" placeholder="nieuwe categorie" id="add_new_category"> 
		<input type="submit" value="opslaan" id="submit_button">		
	</form>	
	echo "$_POST['add_category']";

<?php
include 'views/footer.php';
?>