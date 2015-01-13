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

<div id= "manager_panel">
<a href = "admin_editcategory.php" class = "button" id = "manager_button"><span>&#xF040;</span> | categorie wijzigen</a>
<a href = "admin_addcategory.php" class = "button" id = "manager_button"><span>&#xF067;</span> | categorie toevoegen</a>
<a href = "admin_editproduct.php" class = "button" id = "manager_button"><span>&#xF040;</span> | product wijzigen</a>
<a href = "admin_editproduct.php" class = "button" id = "manager_button"><span>&#xf067;</span> | product toevoegen</a>
</div>

<?php
include 'views/footer.php';
?>