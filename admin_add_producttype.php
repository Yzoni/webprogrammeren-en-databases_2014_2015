<?php
require_once 'classes.php';
security_check_admin();
if (isset($_POST['add_producttype']) && $_POST['add_producttype'] != '') {
    $name = $_POST['add_producttype'];
    ProductType::create($name);
}
include 'views/header.php';
include 'views/navigation.php';
?>
<h2 class="contenttitle">Categorie toevoegen: </h2>
<form action="admin_add_producttype.php" method="post">
    <input type="text" name="add_producttype" placeholder="nieuwe categorie" id="add_new_category"> 
    <button type="submit" class="button"><span>&#xf0fe;</span> | login</button>		
</form>

<?php
include 'views/footer.php';
?>
