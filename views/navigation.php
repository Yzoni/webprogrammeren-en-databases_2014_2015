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
            <?php
            if (is_customer_logged_in() == TRUE) {
                echo "<a href=\"customer.php\">Mijn gegevens</a><div><ul></ul><li><a href =\"customer_edit_info.php\"\></a></li></div>";
            }
            ?>
    </ul>
</div>
</li>
</ul>
</nav>