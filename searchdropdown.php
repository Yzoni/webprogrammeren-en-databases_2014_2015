<?php
require_once 'classes.php';
//get the q parameter from URL
$q = array_key_exists("q", $_GET) ? $_GET["q"] : "";
$hint = "";
if (strlen($q) > 1) { // voor perfomance en in de praktijk typt een gebruiker meestal sowieso 2/3 characters 
    $products = Product::search($q);
    foreach ($products as $product) {
        $hint .= "<a href=\"view_product.php?id=" . $product->id . "\">" . $product->name . "  (" . $product->type->name . ")</a>";
    }
}
// Set output to "no suggestion" if no hint was found
// or to the correct value 
if ($hint == "") {
    $response = "no suggestion";
} else {
    $response = $hint;
}

//output the response
echo $response;
?>