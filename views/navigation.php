<nav>
    <ul>
        <li>
            <a href="index.php">Home</a>
            <a href="products.php">Producten</a>
            <div>
                <ul>
                    <?php
                    $producttypes_nav = ProductType::getAllProductTypes();
                    foreach ($producttypes_nav as $producttype_nav) {
                        echo "<li>";
                        if(is_admin_logged_in()){
                            echo "<a href=\"admin_edit_producttype.php?id=$producttype_nav->id\"><span class=\"icon\">&#xF040; </span></a>";
                        }
                        echo "<a href=\"products.php?id=$producttype_nav->id\">$producttype_nav->name <span class=\"arrow\">&#xf101;</span></a></li>";
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
</li>
</ul>
</nav>