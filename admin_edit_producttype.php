<?php
require_once 'classes.php';
is_admin_logged_in();
if (!isset($_GET['id']) || $_GET['id'] <= 0) {
    echo "No ID given";
    exit();
}
$producttype = new ProductType($_GET["id"]);
include 'views/header.php';
include 'views/navigation.php';
?>
<p>
    <br>
    <a href="admin.php" > <font color="#006666"> Managerpanel</font></a> / categorie wijzigen 			
</p>
<form action="admin_edit_producttype.php" method="post">
    <?php echo $producttype->displayEditForm(); ?>
</form>

<?php
include 'views/footer.php';
?>