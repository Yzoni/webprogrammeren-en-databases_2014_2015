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

                <p><br>managerpanel</p>			
			<div class="manager_panel">
			<a href="categorie_wijzigen.html" class="manager_button"><span>&#xF040;</span> | categorie wijzigen</a>
			<a href="categorie_toevoegen.html" class="manager_button"><span>&#xF067;</span> | categorie toevoegen</a>
			<a href="product_wijzigen.html" class="manager_button"><span>&#xF040;</span> | product wijzigen</a>
			<a href="product_toevoegen.html" class="manager_button"><span>&#xf067;</span> | product toevoegen</a>
			</div>

<?php
include 'views/footer.php';
?>
