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
    echo '<h2 class="contenttitle">Betaling voldaan</h2>';
    echo 'klik <a href="customer_orders.php"> hier </a>';
    echo 'voor een overzicht van al uw facturen';
    // meest recente factuur opvragen en uitprinten
} else if(isset($_POST['payment']) && $_POST['payment'] == "acceptgiro") {
    echo "<h2 class='contenttitle'>Betalen via acceptgiro</h2>"
    . "Klik op de button om uw bestelling te voltooien.<br/>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'><span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "bitcoin") {
    echo "<h2 class='contenttitle'>Betalen via BitCoin</h2>"
    . "Klik op de button om uw betaling te voltooien.<br/>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'><span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "ideal") {
    echo "<h2 class='contenttitle'>Betalen via iDeal</h2>"
    . "Klik op de button om uw betaling te voltooien.<br/>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'><span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "paypal") {
    echo "<h2 class='contenttitle'>Betalen via Paypal</h2>"
    . "Klik op de button om uw betaling te voltooien.<br/>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'><span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "rembours") {
    echo "<h2 class='contenttitle'>Betalen onder rembours</h2>"
    . "Klik op de button om uw bestelling te voltooien.<br/>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'><span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];   
} else if (!is_customer_logged_in()) {
    echo "U dient eerst <a href='customer_login.php'> In te loggen </a>"
    . "of te <a href='customer_register.php'> registreren</a> om te kunnen "
    . "afrekenen.";
} else {
    echo '  <h2 class="contenttitle">Selecteer betaalwijze:</h2>
            <form method="post" action="checkout.php">
            <span class="stockicon">&#xf199;</span><input type="radio" name="payment" value="acceptgiro">Acceptgiro<br>
            <span class="stockicon">&#xf15a;</span><input type="radio" name="payment" value="bitcoin">Bitcoin <br>
            <span class="stockicon">&#xf05a;</span><input type="radio" name="payment" value="ideal">Ideal <br>
            <span class="stockicon">&#xf1ed;</span><input type="radio" name="payment" value="paypal">Paypal <br>
            <span class="stockicon">&#xf0d6;</span><input type="radio" name="payment" value="rembours">Rembours<br>
            <br>
            <button type="submit" class="button"><span>&#xf155;</span>betaalwijze bevestigen</button>
            </form>';
    }
?>
</div>
<?php
include 'views/footer.php';
?>
