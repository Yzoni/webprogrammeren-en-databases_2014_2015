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
                    echo "<span class=\"adminloggedin\">INGELOGD ALS BEHEERDER</span>";
                } else {
                    if (is_customer_logged_in()) {
                        echo "<a href=\"customer_login.php?fn=logout\" class=\"button\" id=\"login\"><span>&#xf055;</span> | Uitloggen</a>";
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
                    <span class="iconfont">&#xf07a;</span><span class="winkelwagen"> &euro;0,00 | <a href="#"> afrekenen</a></span>
                </div>
            </div>