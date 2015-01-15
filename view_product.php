<?php
require_once 'classes.php';
include 'views/header.php';
include 'views/navigation.php';


$product = new Product($_GET["id"]);
?>
<div class="description">

    <div>
        <br>
        <a href="products.php?id=<?php echo $product->type->id ?>"class="category"><?php echo $product->type->name; ?></a> / <?php echo $product->name; ?>
        <?php
        if (is_admin_logged_in()) {
            echo "<a href=\"admin_edit_product.php?id=$product->id\"><span class=\"icon\">&#xF040; </span></a>";
        }
        ?>
    </div>

    <br>
    <hr>

    <table>
        <br>
        <tr>
            <td>
                <span class="descrText"> <?php echo $product->description; ?>
                </span>
            </td>
            <td>
                <img class="descrImg" src="data:image/png;base64,<?php echo base64_encode($product->image); ?>"/>
            </td>
        </tr>
    </table>

    <br>
    <hr>
    <br>

    <p>
    <ul class="infoList">


        <li>
            <span class="prodInfoTxt">
                <span class="icon-ok">&#xf00c;</span>
                <?php echo $product->stock; ?> op voorraad
            </span>
            <form class="inputForm" action="#">
                
                <?php
                if (is_admin_logged_in() == false) {
                    echo "Aantal: <input type=\"text\" class=\"inputBox\" name=\"aantal \">";
                    echo "<input class=\"voegToe\" type =\"submit\" value= \"&#xf055; | voeg toe\">";
                }
                ?>
            </form>
        </li>
        <br>
        <br>

        <li>
            <span class="prodInfoTxt"> 
                <span class="icon">&#xf135; </span>
                levertijd: 1 dag
            </span>
        </li>
        <br>
        <br>

        <li>
            <span class="prodInfoTxt">
                <span class="icon">&#xf153; </span>
                prijs per kg:  <?php echo $product->price; ?>
            </span>
        </li>
        </p>
    </ul>

    <br>
    <br>

    <p>
        <br>
        <a href="view_producttype.php?id=<?php echo $product->type->id ?>" class="backProd"> &#xf053; | terug naar: <?php echo $product->type->name; ?> </a>
    </p>
</div>

<?php
include 'views/footer.php';
?>
            