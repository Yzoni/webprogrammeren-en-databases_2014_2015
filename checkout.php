<?php
require_once 'classes.php';

// If a customer tries to checkout without being logged in, a session variable
// named loginFalse will be created, and the customer will be redirected to
// the login page. After a succesfull login the variable loginFalse will be set
// to false and the customer will be redirected to the checkout page.
if(!is_customer_logged_in()) {
    $_SESSION['loginFalse'] = 1;
    header('Location: customer_login.php');
}
include 'views/header.php';
include 'views/navigation.php';
?>
<div class="wrappercontent">
<?php

// After a logged in customer has succeeded in selecting a payment method, and 
// has confirmed to want to pay, a form called 'checkout_complete' will be 
// submitted. After checkout_complete has been submitted, Order::tryOrder will 
// be called to try to pull the given product quantities from the database. 
// Order::tryOrder creates a session variable called dbPullSucces. dbPullSucces 
// will be true if the pull from the database has succeeded, and false if it has
// failed. If dbPullSuccess is false an error message will be printed and the 
// script will exit.
if (isset($_POST['checkout_complete'])) {
    Order::tryOrder($_SESSION['products'], 
                    $_SESSION['quantities'],
                    Order::getProductNames($_SESSION['products']));
    if(!$_SESSION['dbPullSuccess']) {
        Order::printError();
        include 'views/footer.php';
        exit();
    }

// If Order::tryOrder has succeeded in pulling the data from the database, then
// Order::executeOrder will insert all the information about the order into
// the database (that information will be: customer id, the ordered products,
// quantities, and payment method; the date and order id are automatically 
// created when the order is inserted into the database.
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
    echo '<a href="customer_orders.php" class="button"><span>&#xf115;'
    . '</span>factuuroverzicht</a><br><br>';
    echo '<a href="products.php" class="button"><span>&#xf14d;'
    . '</span>verder winkelen</a>';
// The nested else if statements below are used to check the value of the
// selected payment method so that the script knows to which external page 
// it has to redirect in case that the user has selected to pay electronically.
// After clicking on the button created by these statements, checkout_complete
// will be submitted. (if checkout_complete is submitted, the script will try
// to pull the data from the database).
} else if(isset($_POST['payment']) && $_POST['payment'] == "acceptgiro") {
    echo "<h2 class='contenttitle'>Betalen via acceptgiro</h2>"
    . "Klik op de button om uw bestelling te voltooien.<br>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'>"
    . "<span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "bitcoin") {
    echo "<h2 class='contenttitle'>Betalen via BitCoin</h2>"
    . "Klik op de button om uw betaling te voltooien.<br>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'>"
    . "<span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "ideal") {
    echo "<h2 class='contenttitle'>Betalen via iDeal</h2>"
    . "Klik op de button om uw betaling te voltooien.<br>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'>"
    . "<span>&#xf09d;</span>betaling voltooien</button>"
    . "</form>";    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "paypal") {
    echo "<h2 class='contenttitle'>Betalen via Paypal</h2>"
    . "Klik op de button om uw betaling te voltooien.<br>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'>"
    . "<span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];
} else if (isset($_POST['payment']) && $_POST['payment'] == "rembours") {
    echo "<h2 class='contenttitle'>Betalen onder rembours</h2>"
    . "Klik op de button om uw bestelling te voltooien.<br>"
    . "<form method='post' action='checkout.php'>"
    . "<button type='submit' name='checkout_complete' class='button'>"
    . "<span>&#xf155;</span>betaling voltooien</button>"
    . "</form>";
    $_SESSION['payment'] = $_POST['payment'];
} else {
    echo '  <h2 class="contenttitle">Selecteer betaalwijze:</h2>
            <form method="post" action="checkout.php">
            <input type="radio" name="payment" value="acceptgiro">
            <span class="stockicon">&#xf199;</span>Acceptgiro<br>
            <input type="radio" name="payment" value="bitcoin">
            <span class="stockicon">&#xf15a;</span>Bitcoin <br>
            <input type="radio" name="payment" value="ideal">
            <span class="stockicon">&#xf05a;</span>Ideal <br>
            <input type="radio" name="payment" value="paypal">
            <span class="stockicon">&#xf1ed;</span>Paypal <br>
            <input type="radio" name="payment" value="rembours">
            <span class="stockicon">&#xf0d6;</span>Rembours<br>
            <br>
            <button type="submit" class="button">
            <span>&#xf155;</span>betaalwijze bevestigen</button>
            </form>';
    }
?>
</div>
<?php
include 'views/footer.php';
?>
