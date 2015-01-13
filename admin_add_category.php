<?php
require_once 'classes.php';
// is_admin_logged_in();
if (isset($_POST['add_category'])) {
    $category = $_POST['add_category'];
    ProductType::create($category);
}
include 'views/header.php';
include 'views/navigation.php';
?>
	<p>
		<br>
		<a href="fruyt.nl/managerpanel" > <font color="#006666"> Managerpanel</font></a> / categorie toevoegen 			
	</p>
	<form action="admin_add_category.php" method="get">					
		<input type="text" name="add_category" placeholder="nieuwe categorie" id="add_new_category"> 
		<input type="submit" value="opslaan" id="submit_button">		
	</form>	

<?php
include 'views/footer.php';
?>