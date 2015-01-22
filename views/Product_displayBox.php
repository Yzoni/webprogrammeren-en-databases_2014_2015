<div class="box">
    <p class="title">
        <?php
        if (is_admin_logged_in()) {
            echo "<a href=\"admin_edit_product.php?id=$this->id\"><span class=\"icon\">&#xF040; </span></a>";
        }
        ?>
        <span><?php echo $this->type->name; ?> / </span> 
        <a class="productpagelink" href="view_product.php?id=<?php echo $this->id; ?>"> <?php echo $this->name; ?></a>
    </p>


    <?php
    if (is_null($this->image)) {
        echo "<a href=\"view_product.php?id=" . $this->id . "\"><div class=\"image\"> </div></a>";
    } else {
        echo "<a href=\"view_product.php?id=" . $this->id . "\"><img class=\"image\" src = \"data:image/png;base64," . base64_encode($this->image) . "\"/></a>";
    }
    ?>
    <p class="stock"><?php echo ($this->stock > 0 ? "<span class=\"stockicongreen\">&#xf00c;" : "<span class=\"stockiconred\">&#xf00d") ?></span><?php echo $this->stock; ?> op voorraad</p>
    <?php echo "<p class=\"price\">&#8364;" . $this->price . "/kg</p>"; ?>

</div>
