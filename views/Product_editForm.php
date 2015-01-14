<form action="admin_edit_producttype.php?id=<?php echo $this->id; ?>" method="post">
    <input type="text" name="name" placeholder="nieuwe categorie" id="add_new_category" value="<?php echo $this->name; ?>"> 
    <input type="submit" value="opslaan" id="submit_button">
</form>