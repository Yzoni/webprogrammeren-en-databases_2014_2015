<?php
require_once 'classes.php';
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fruyt.nl</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="style_index.css">
    </head>
    <body>
        <header>
            <div>
                <a href="index.html" class="logo">fruyt .nl</a>
                <a href="register.html" class="button" id="register"><span>&#xf055;</span> | registreren</a>			
                <a href="login.html" class="button" id="login"><span>&#xf084;</span> | inloggen</a>
            </div>
        </header>
        <div class="wrapper">
            <div class="wrapperhead">
                <div class="wrapperheadcontent">
                    <span class="iconfont">&#xf07a;</span><span class="winkelwagen"> &euro;0,00 | afrekenen</span>
                </div>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                        <div>
                            <ul>
                                <?php
                                $producttypes = ProductType::getAllProductTypes();
                                foreach ($producttypes as $producttype) {
                                    echo "<li><a href=\"#\">$producttype->name <span class=\"arrow\">&#xf101;</span></a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#">Bestellingten</a>
                    </li>
                </ul>
            </nav>
            <?php
                $products = Product::getAllProducts();
                foreach ($products as $product) {
                    $product->displayBox();
                }
            ?>
            <footer> <p>Copyright Fruyt.nl &#169;</p></footer>
        </div>

    </body>

</html>