<div class="box">
    <p class="title">
        <?php
        if (is_admin_logged_in()) {
            echo "<a href=\"admin_edit_producttype.php?id=$this->id\"><span class=\"icon\">&#xF040; </span></a>";
        }
        ?>
        <span><?php echo $this->type->name; ?>/</span> 
        <a class="productpagelink" href="view_product.php?id=<?php echo $this->id; ?>"><?php echo $this->name; ?></a>
    </p>
    <a href="view_product.php?id=<?php echo$this->id; ?>"><img class="image" src="data:image/png;base64,<?php echo base64_encode($this->image); ?>"/></a>
    <p class="stock"><span><?php echo ($this->stock > 0 ? "&#xf00c;" : "&#xf00d")?></span><?php echo $this->stock; ?> op voorraad</p>
    <?php
    if (is_admin_logged_in() == false) {
        echo $this->price."/Kg";
    }
    ?>
</div>