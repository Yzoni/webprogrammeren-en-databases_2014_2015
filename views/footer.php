<footer> <p>Copyright Fruyt.nl &#169;</p>

   <?php
    if (is_admin_logged_in() == TRUE) {
        echo "<a href=\"admin_login.php?fn=logout\">admin loguit</a>";
    } else {
        echo "<a href=\"admin_login.php\">admin login</a>";
    }
    ?>


</footer>
</div>

</body>

</html>