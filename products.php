<?php

require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';


$customers = Customer::getAllCustomers();
foreach ($customers as $customer) {
    $customer->displayBox();
}
$products = Product::getAllProducts();
foreach ($products as $product) {
    $product->displayBox();
}

include 'views/footer.php';

?>