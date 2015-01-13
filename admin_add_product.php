<?php is_admin_logged_in();

require_once 'classes.php';
include 'views/header.php;'


// assign the posted values to variables
$name = $_POST['name'];
$category = $_POST['category'];
$description = $_POST['description'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$stock = $_POST['stock'];
$image = $_FILES['image'];

// creates the product product
Product::create($name, $description, $image, $stock, $price, $price);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Product toevoegen </title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="style_toevoegen_product.css">
</head>
<body>
	<header>


		<span class="logo">FRUYT.nl</span>
		      <a href="register.html" class="button" id="register"><span>&#xf055;</span> | registreren</a>	  
		      	 <a href="login.html" class="button" id="login"><span>&#xf084;</span> | inloggen</a>
			    </header>
				<div class="wrapper">
					<nav>
								<ul>
												<li>
															 <a href="index.html">Home</a>
															       <a href="producten.html">Producten</a>
															       	     <div>
																         <ul>
																	     <li><a href="#">appels <span class="arrow">&#xf101;</span></a></li>
																	     	    		    	   <li><a href="#">ananas <span class="arrow">&#xf101;</span></a></li>
																					   	  		  	 <li><a href="#">bananen <span class="arrow">&#xf101;</span></a></li>
																									 			        </ul>
																													    </div>
																													        </li>
																														    <li>
																														        <a href="#">Bestellingen</a>
																															      </li>
																															         </ul>
																																   </nav>
																																     <p>
																																       <br>
																																         <a href="fruyt.nl/managerpanel" > <font color="#006666"> Managerpanel</font></a> / product toevoegen    
																																	    				 </p>
																																					   <form action="admin_add_product.php" enctype="multipart/form-data">     
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
																																																																								      	     		 		 <input type="text" name="stock" placeholder="voorraad" id="stock"><br>
																																																																													 		    		 <input type="file" name="image" placeholder="foto uploaden" id="photo">
																																																																																	 		    		 </div>		   	        
																																																																																					 				  <input type="submit" value="opslaan" id="submit">  
																																																																																									  	 	       </form>	       		      
																																																																																											       
																																																																																											        <footer> <p>Copyright Fruyt.nl &#169;</p></footer>
																																																																																													 </div>

</body>

</html>


<?php
    include 'views/footer.php';
?>