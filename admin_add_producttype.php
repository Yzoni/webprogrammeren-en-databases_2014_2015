<?php
require_once 'classes.php';
is_admin_logged_in();
if (isset($_POST['add_producttype']) && $_POST['add_producttype'] !='') {
    $name = $_POST['add_producttype'];
    ProductType::create($name);
}
include 'views/header.php';
include 'views/navigation.php';
?>
	<p>
		<br>
		<a href="fruyt.nl/managerpanel" > <font color="#006666"> Managerpanel</font></a> / categorie toevoegen 			
	</p>
	<form action="admin_add_producttype.php" method="post">
		<input type="text" name="add_producttype" placeholder="nieuwe categorie" id="add_new_category"> 
		<input type="submit" value="opslaan" id="submit_button">		
	</form>

<?php 
include 'views/footer.php';
?>