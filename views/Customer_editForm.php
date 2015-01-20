
<form action="" method="POST">
    <input type="text" name="email" placeholder="emailadres" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php echo $this->email; ?>"><br>
    <?php if(is_admin_logged_in()!=true){// dont display current password when we are admin?>
    <input type="password" name="oldpassword" placeholder="Huidig wachtwoord"><br />
    <?php } ?>
    <input type="password" name="password" placeholder="Nieuw wachtwoord" id="pass1" onkeyup="checkPass();
            return false;">
    <span id="confirmMessage"></span><br>
    <input type="password" name="password2" placeholder="Nieuw wachtwoord (nogmaals)" id="pass2" onkeyup="checkPass();
            return false;">
    <span id="confirmMessage"></span><br>
    <select name="gender" >
        <option value="true" <?php echo ($this->gender == 1 ? "selected" : ""); ?>>Dhr.</option>
        <option value="false" <?php echo ($this->gender == 0 ? "selected" : ""); ?>>Mevr.</option>
    </select>
    <input type="text" name="firstname" placeholder="voornaam" id="person" value="<?php echo $this->firstname; ?>"><br>
    <input type="text" name="lastname" placeholder="achternaam" id="person" value="<?php echo $this->lastname; ?>"><br>
    <input type="text" name="zip" placeholder="postcode" pattern="[0-9]{4}[a-zA-Z]{2}$" id="info" value="<?php echo $this->zip; ?>"><br>
    <input type="text" name="streetaddress" placeholder="straatnaam" id="info" value="<?php echo $this->streetaddress; ?>"><br>
    <input type="text" name="streetnumber" placeholder="huisnummer" id="info" value="<?php echo $this->streetnumber; ?>"><br>
    <button type="submit" class="button"><span>&#xf040;</span>wijzigen</button>

</form>
