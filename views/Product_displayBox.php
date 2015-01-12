<div class="box">
    <p class="title"><span><?php echo $this->type->name; ?>/</span> 
        <a class="productpagelink" href="view_product.php?id=<?php echo $this->id; ?>"><?php echo $this->name; ?></a>
    </p>
    <a href="view_product.php?id=<?php echo $this->id; ?>"><img class="image" src="data:image/png;base64,<?php echo base64_encode($this->image); ?>"/></a>
    <p class="stock"><span>&#xf00c;</span><?php echo $this->stock; ?> op voorraad</p>
    <a href="#" class="button"><span>&#xf055;</span> | voeg toe</a>
</div>