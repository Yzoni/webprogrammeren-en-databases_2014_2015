<footer>Copyright Fruyt.nl &#169;

    <?php
    if (is_customer_logged_in() == FALSE) {
        if (is_admin_logged_in() == TRUE) {
            echo "<a href=\"admin_login.php?fn=logout\">beheerder loguit</a>";
        } else {
            echo "<a href=\"admin_login.php\">beheerder login</a>";
        }
    }
    ?>


</footer>
</div>

</body>

</html>
