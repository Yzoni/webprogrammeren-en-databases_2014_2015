<?php
require_once 'classes.php';
<<<<<<< HEAD
is_admin_logged_in();
if (isset($_POST['add_producttype']) && $_POST['add_producttype'] !='') {
=======
security_check_admin();
if (isset($_POST['add_producttype']) && $_POST['add_producttype'] != '') {
>>>>>>> c358c14b7befa84d28e6b2fffa77098983e50a26
    $name = $_POST['add_producttype'];
    ProductType::create($name);
}
include 'views/header.php';
include 'views/navigation.php';
?>
<h2 class="contenttitle">Categorie toevoegen: </h2>
<form action="admin_add_producttype.php" method="post">
    <input type="text" name="add_producttype" placeholder="nieuwe categorie" id="add_new_category"> 
    <input type="submit" value="opslaan" id="submit_button">		
</form>

<?php
include 'views/footer.php';
?>