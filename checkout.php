<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
<?php

if(!is_customer_logged_in()) {
    echo "U moet <a href='customer_login.php'>ingelogd </a> "
    . "zijn om deze pagina te bekijken.";
    include 'views/footer.php';
    exit();
}

if (isset($_POST['checkout_complete'])) {
    Order::tryOrder($_SESSION['products'], 
                    $_SESSION['quantities'],
                    Order::getProductNames($_SESSION['products']));
    if(!$_SESSION['dbPullSuccess']) {
        Order::printError();
        include 'views/footer.php';
        exit();
    }

    Order::executeOrder($_SESSION['customer_id'],
                    $_SESSION['products'],
                    $_SESSION['quantities'],
                    Order::getProductPrices($_SESSION['products']),
                    Order::getProductNames($_SESSION['products']),
                    $_SESSION['payment']);
    unset($_SESSION['products']);
    unset($_SESSION['quantities']);
    unset($_SESSION['subtotal']);
    unset($_SESSION['payment']);
    unset($_SESSION['total']);
    echo '<h2 class="contenttitle">Betaling voldaan.</h2>';
    echo 'klik <a href="customer_orders.php"> hier </a>';
    echo 'voor een overzicht van al uw facturen';
    // meest recente factuur opvragen en uitprinten
} else if(isset($_POST['payment']) && $_POST['payment'] == "acceptgiro") {
    echo "<h2 class='contenttitle'>Betalen via acceptgiro</h2>"
    . "<form method='post' action='checkout.php'>"
    . "<input type='submit' name='checkout_complete' value='hier'>"
    . "</form>"
    . "om een acceptgiro te versturen naar uw postadres.";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "bitcoin") {
    echo "klik "
    . "<form method='post' action='checkout.php'>"
    . "<input type='submit' name='checkout_complete' value='hier'>"
    . "</form>"
    . "om te betalen met bitcoins.";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "ideal") {
    echo "klik "
    . "<form method='post' action='checkout.php'>"
    . "<input type='submit' name='checkout_complete' value='hier'>"
    . "</form>"
    . "om te betalen met ideal.";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "paypal") {
    echo "klik "
    . "<form method='post' action='checkout.php'>"
    . "<input type='submit' name='checkout_complete' value='hier'>"
    . "</form>"
    . "om te betalen met paypal.";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "rembours") {
    echo "klik "
    . "<form method='post' action='checkout.php'>"
    . "<input type='submit' name='checkout_complete' value='hier'>"
    . "</form>"
    . "om te betalen onder rembours.";
    $_SESSION['payment'] = $_POST['payment'];   
} else if (!is_customer_logged_in()) {
    echo "U dient eerst <a href='customer_login.php'> In te loggen </a>"
    . "of te <a href='customer_register.php'> registreren</a> om te kunnen "
    . "afrekenen.";
} else {
    echo '  <h2 class="contenttitle">Selecteer betaalwijze:</h2>
            <br>
            <form method="post" action="checkout.php">
            <input type="radio" name="payment" value="acceptgiro"><span class="stockicon">&#xf199;</span>Acceptgiro<br>
            <input type="radio" name="payment" value="bitcoin"><span class="stockicon">&#xf15a;</span>Bitcoin <br>
            <input type="radio" name="payment" value="ideal"><span class="stockicon">&#xf05a;</span>Ideal <br>
            <input type="radio" name="payment" value="paypal"><span class="stockicon">&#xf1ed;</span>Paypal <br>
            <input type="radio" name="payment" value="rembours"><span class="stockicon">&#xf0d6;</span>Rembours<br>
            <br>
            <button type="submit" class="button"><span>&#xf0d1;</span>bestelling afronden</button>
            </form>';
    }
?>
</div>
<?php
include 'views/footer.php';
?>
