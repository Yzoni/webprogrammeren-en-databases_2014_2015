<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fruyt.nl</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="style_shopping_cart.css">
        <link rel="icon" type="image/png" href="images/fruyt_icon.png">
        <script type="text/javascript" src="js/search.js"></script>
    </head>
    <body>
        <header>
            <div>
                <a href="index.php" class="logo">fruyt .nl</a>
                <?php
                if (is_admin_logged_in()) {
                    echo "<h2 class=\"welcome-header\">Ingelogd als beheerder</h2>";
                } else {
                    if (is_customer_logged_in()) {
                        $customer = new Customer($_SESSION["customer_id"]);
                        echo "<a href=\"customer_login.php?fn=logout\" class=\"button\" id=\"login\"><span>&#xf055;</span> | Uitloggen</a><h2 class=\"welcome-header\">Welkom, $customer->firstname &nbsp;&nbsp;</h2>";
                    } else {
                        echo "<a href=\"customer_register.php\" class=\"button\" id=\"register\"><span>&#xf14a;</span>registreren</a>";
                        echo "<a href=\"customer_login.php\" class=\"button\" id=\"login\"><span>&#xf084;</span>inloggen</a>";
                    }
                }
                ?>
            </div>
        </header>
        <div class="messagewrapper">
            <?php
            $display->showMessages();
            ?>
        </div>
        <div class="wrapper">
            <div class="wrapperhead">
                <div class="wrapperheadcontent">
                    <input placeholder="Zoek product" type="text" name="search" id="search" onkeyup="showResult(this.value)">
                    <a href="shopping_cart.php" id="cartLink" class="button">
                        <span class="iconfont">&#xf07a;</span><span class="winkelwagen"> &euro;
                            <?php
                            if (isset($_SESSION['total'])) {
                                echo $_SESSION['total'];
                            } else {
                                echo 0;
                            }
                            ?> 
                        </span>
                    </a>
                </div>
            </div>
