<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fruyt.nl</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="style_shopping_cart.css">
        <link rel="icon" type="image/png" href="images/fruyt_icon.png">
        <script src="js/search.js" type="text/javascript"></script>
        <script src="js/noentertextbox.js" type="text/javascript"></script>
        <!--  FANCY NICHE ANDROID 5.0 CHROME KLEUR S-->
        <meta name="theme-color" content="#006666">
        <script>
            document.onkeypress = stopRKey;
        </script>
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
                        echo "<a href=\"customer_login.php?fn=logout\" class=\"button\" id=\"login\"><span>&#xf00d;</span>uitloggen</a><h2 class=\"welcome-header\">Welkom, $customer->firstname &nbsp;&nbsp;</h2>";
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
                    <form> 
                        <div class="searchform">
                            <input id="searchbox" type="text" placeholder="Zoek producten" onkeyup="showResult(this.value)" autocomplete="off"> 
                            <div id="searchdropdown" class="searchdropdown"></div></div>
                    </form> 

                    <?php
                    if (!is_admin_logged_in()) {
                        echo "<a href=\"shopping_cart.php\" class=\"winkelwagen\">";
                        echo "<span>&#xf07a;</span>winkelwagentje &euro;";
                        if (isset($_SESSION['total'])) {
                            echo $_SESSION['total'];
                        } else {
                            echo 0;
                        }
                        echo "</span></a>";
                    }
                    ?> 
                </div>
            </div>
