<nav>
    <ul>
        <li>
            <a href="index.php">Home</a>
            <a href="products.php">Producten</a>
            <div>
                <ul>
                    <?php
                    $producttypes = ProductType::getAllProductTypes();
                    foreach ($producttypes as $producttype) {
                        echo "<li><a href=\"view_producttype.php?id=$producttype->id\">$producttype->name <span class=\"arrow\">&#xf101;</span></a></li>";
                    }
                    ?>
                </ul>
            </div>
        </li>
        <li>
            <a href="#">Bestellingen</a>
        </li>
    </ul>
</nav>