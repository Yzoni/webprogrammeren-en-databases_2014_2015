<div class="box">
    <p class="title"><span><?php echo $this->type->name; ?>/</span> 
        <a class="productpagelink" href="product.html"><?php echo $this->name; ?></a>
    </p>
    <img class="image" src="data:image/png;base64,<?php echo base64_encode( $this->image ); ?>"/>
    <p class="stock"><span>&#xf00c;</span><?php echo $this->stock; ?> op voorraad</p>
    <a href="#" class="button"><span>&#xf055;</span> | voeg toe</a>
</div>