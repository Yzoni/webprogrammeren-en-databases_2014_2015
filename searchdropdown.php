<?php
require_once 'classes.php';
//get the q parameter from URL
$q = array_key_exists("q", $_GET) ? $_GET["q"] : "";
$hint = "";
if (strlen($q) > 1) {
    $products = Product::search($q);
    foreach ($products as $product) {
        $hint .= "<a href=\"view_product.php?id=" . $product->id . "\">" . $product->name . "  (" . $product->type->name . ")</a>";
    }
}

if ($hint == "") {
    $response = "no suggestion";
} else {
    $response = $hint;
}

echo $response;
?>