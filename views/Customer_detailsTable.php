<table class="adminview">
    <tr>
        <th>Voornaam</th>
        <td ><?php echo $this->firstname ?></td>
    </tr>
    <tr>
        <th>Achternaam</th>
        <td><?php echo $this->lastname ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $this->email ?></td>
    </tr>
    <tr>
        <th>Adres</th>
        <td><?php echo $this->streetaddress . $this->streetnumber ?></td>
    </tr>
    <tr>
        <th>Postcode</th>
        <td><?php echo $this->zip?></td>
    </tr>
</table>
