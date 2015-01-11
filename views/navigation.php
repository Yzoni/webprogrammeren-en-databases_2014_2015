<nav>
    <ul>
        <li>
            <a href="index.php">Home</a>
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
            <a href="#">Bestellingen</a>
        </li>
    </ul>
</nav>