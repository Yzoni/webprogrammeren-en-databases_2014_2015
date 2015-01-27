<?php
require_once 'classes.php';
//get the q parameter from URL
$q = array_key_exists("q", $_GET) ? $_GET["q"] : "";
$hint = "";
if (strlen($q) > 1) {
    $products = Product::search($q);
    foreach ($products as $product) {
        $hint .= "<a href=\"view_product.php?id=" . $product->id . "\">" . replaceWithBold($product->name, $q) . "  (" . $product->type->name . ")</a>";
    }
}

if ($hint == "") {
    $response = "geen suggesties";
} else {
    $response = $hint;
}

echo $response;

function replaceWithBold($product, $search) {
    // strpos is case sensitive
    $productwithoutcase = strtolower($product);
    $searchwithoutcase = strtolower($search);
    
    $startpossearch = strpos($productwithoutcase, $searchwithoutcase);
    $endpossearch = strlen($search) + $startpossearch;
    
    $beforesearch = substr($product, 0, $startpossearch);
    $mid = substr($product, $startpossearch , strlen($search));
    $aftersearch = substr($product, $endpossearch);
    
    $boldsearch = "<span class=\"queryinword\">" . $mid . "</span>"; 
    
    return $beforesearch . $boldsearch . $aftersearch;  
}
?>
