<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fruyt.nl</title>
        <link rel="stylesheet" type="text/css" href="style.css">
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
                        echo "<a href=\"customer_register.php\" class=\"button\" id=\"register\"><span>&#xf055;</span> | registreren</a>";
                        echo "<a href=\"customer_login.php\" class=\"button\" id=\"login\"><span>&#xf084;</span> | inloggen</a>";
                    }
                }
                ?>
            </div>
        </header>
        <div class="wrapper">
            <div class="wrapperhead">
                <div class="wrapperheadcontent">
                    <span class="iconfont">&#xf07a;</span><span class="winkelwagen"> &euro;
                        <?php
                        $pay_link = "";
                        if (is_customer_logged_in()) {
                            $order_nav = Order::getLatestOrder($_SESSION['customer_id']);
                            if ($order_nav) {
                                echo $order_nav->getTotalPrice();
                                $pay_link = "customer_view_order.php?id=".$order_nav->id;
                            } else {
                                echo "0,00";
                            }
                            echo " | <a href=\"$pay_link\"> afrekenen</a>";
                        }
                        ?></span>
                </div>
            </div>