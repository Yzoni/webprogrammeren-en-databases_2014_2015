<?php

require_once 'config.php';

/**
 * Function is_admin_logged_in
 *
 * Checks if an admin is logged in
 *
 * @return bool
 */
function is_admin_logged_in() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['admin_logged_in']) && 
            $_SESSION['admin_logged_in'] == 1) {
        // Logged in
        return true;
    } else {
        // Not logged in       
        return false;
    }
}

/**
 * Function security_check_admin
 *
 * Checks if an admin is logged in and if not head to index
 *
 * @return bool|exit
 */
function security_check_admin() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['admin_logged_in']) && 
            $_SESSION['admin_logged_in'] == 1) {
        // Logged in
        return true;
    } else {
        // Not logged in        
        header("location: products.php");
        exit();
    }
}

/**
 * Function is_customer_logged_in
 *
 * Checks if an customer is logged in
 *
 * @return bool
 */
function is_customer_logged_in() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['customer_logged_in']) && 
            $_SESSION['customer_logged_in'] == 1) {
        // Logged in
        return true;
    } else {
        // Not logged in         
        return false;
    }
}

/**
 * Function security_check_customer
 *
 * Checks if an customer is logged in and if not head to index
 *
 * @return bool
 */
function security_check_customer() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['customer_logged_in']) && 
            $_SESSION['customer_logged_in'] == 1) {
        // Logged in
        return true;
    } else {
        // Not logged in  
        header("location: index.php");
        exit();
    }
}

/**
 * Class ProductType
 *
 * Handles the product categories
 *
 */
class ProductType {

    public $id;
    public $name;

    function __construct($id = null) {
        if ($id) {
            global $db;
            $query = $db->prepare("SELECT * FROM ProductTypes WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->setFetchMode(PDO::FETCH_INTO, $this);
            $query->execute();
            $query->fetch();
        }
    }

    /**
     * Function getAllProductTypes
     *
     * Gets all productTypes from the database and fetches it all into 1 big 
     * object with subobject of the class "productType"
     *
     * @return object with subobjects as ProductType
     */
    static function getAllProductTypes() {
        global $db;
        $query = $db->prepare("SELECT * FROM ProductTypes ORDER BY name");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "ProductType");
        return $result;
    }

    /**
     * Function create
     *
     * Inserts a new producttype in the database
     * 
     * @param string $name Name of the new productype
     */
    static function create($name) {
        global $db;
        $query = $db->prepare("INSERT INTO ProductTypes (name) VALUES (:name)");
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
    }

    /**
     * Function create
     *
     * Outputs the the productype edit form to the user
     * 
     * @return file Contents of the edit form view
     */
    function displayEditForm() {
        $output = include 'views/ProductType_editForm.php';
        return $output;
    }

    /**
     * Function edit
     *
     * Updates the productype name in the database
     */
    function edit() {
        global $db;
        $query = $db->prepare("UPDATE ProductTypes SET name = :name "
                . "WHERE id = :id");
        $query->bindParam(':name', $this->name, PDO::PARAM_STR);
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);
        $status = $query->execute();
        if ($status) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function delete
     *
     * Deletes a producttype from the database
     */
    function delete() {
        global $db;
        $query = $db->prepare("DELETE FROM ProductTypes WHERE id = :id");
        $query->bindParam(':id', $this->id, PDO::PARAM_STR);
        $query->execute();
    }

}

/**
 * Class Product
 *
 * Handles the seperate products
 */
class Product {

    public $id;
    public $typeid;
    public $type;
    public $name;
    public $description;
    public $image;
    public $stock;
    public $price;
    public $quantity;

    function __construct($id = null) {
        if ($id) {
            global $db;
            $query = $db->prepare("SELECT * FROM Products WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->setFetchMode(PDO::FETCH_INTO, $this);
            $query->execute();
            $status = $query->fetch();
            if ($status == false) {
                header('Location: 404page.php');
            }
        }
        $this->type = new ProductType($this->typeid);
    }

    /**
     * Function getAllProductTypes
     *
     * Displays one productbox to the user
     *
     * @return file 
     */
    function displayBox() {
        $output = include 'views/Product_displayBox.php';
        return $output;
    }

    /**
     * Function countProducts
     *
     * Counts rows of products
     *
     * @param int $type specifies if only a specific type should be counted
     * @return file 
     */
    static function countProducts($type = null) {
        global $db;
        if ($type) {
            $query = $db->prepare("SELECT * FROM Products "
                    . "WHERE typeid = :typeid");
            $query->bindParam(':typeid', $type, PDO::PARAM_INT);
        } else {
            $query = $db->prepare("SELECT * FROM Products");
        }
        $query->execute();
        $result = $query->rowCount();
        return $result;
    }

    /**
     * Function getAllProducts
     *
     * Gets all products from the database and fetches it all into 1 big 
     * object with subobject of the class "products"
     *
     * @param int $type producttype (categorie)
     * @param string $sortorder specifies sorting method
     * @param int $sortorder specifies sorting method
     * @param int $startamount specifies lowerlimit
     * @param int $endamount amount of products per page upperlimit
     * @param int(bool) $special sets if products should marked as special 
     * (frontpage)
     * @return object with subobjects as products
     */
    static function getAllProducts($type = null, 
            $sortorder = "name ASC", 
            $startamount = 0, 
            $endamount = 8, 
            $special = 0) {
        global $db;
        if ($type) {
            $query = $db->prepare("SELECT * FROM Products "
                    . "WHERE typeid = :typeid ORDER BY $sortorder "
                    . "LIMIT :startamount, :endamount");
            $query->bindParam(':startamount', $startamount, PDO::PARAM_INT);
            $query->bindParam(':endamount', $endamount, PDO::PARAM_INT);
            $query->bindParam(':typeid', $type, PDO::PARAM_INT);
        } else if ($special == 1) {
            $query = $db->prepare("SELECT * FROM Products WHERE special = 1");
        } else {
            $query = $db->prepare("SELECT * FROM Products "
                    . "ORDER BY $sortorder LIMIT :startamount, :endamount");
            $query->bindParam(':startamount', $startamount, PDO::PARAM_INT);
            $query->bindParam(':endamount', $endamount, PDO::PARAM_INT);
        }
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $result;
    }

    /**
     * Function search
     *
     * Searches the product table for the input query with on two sides of the query a  wildcard
     * 
     * @param int the query word
     * @return bool
     */
    static function search($word) {
        global $db;
        $query = $db->prepare("SELECT * FROM Products WHERE name "
                . "LIKE :word ORDER BY name");
        $str = '%' . $word . '%';
        $query->bindParam(':word', $str);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $result;
    }

    /**
     * Function create
     *
     * Creates the product details
     * 
     * @return bool
     */
    static function create($typeid, 
            $name, 
            $description, 
            $stock, 
            $price, 
            $special, 
            $image = null) {
        global $db;
        $query = $db->prepare("INSERT INTO Products (typeid, name, description, "
                . "stock, price, special, image) "
                . "VALUES (:typeid, :name, :description, :stock, :price, "
                . ":special, :image)");
        $query->bindParam(':typeid', $typeid, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':stock', $stock, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':special', $special, PDO::PARAM_INT);
        $query->bindParam(':image', $image, PDO::PARAM_LOB);
        return $query->execute();
    }

    /**
     * Function edit
     *
     * Updates the product details
     * 
     * @return bool
     */
    function edit() {
        global $db;
        $query = $db->prepare("UPDATE Products SET typeid = :typeid, "
                . "name = :name, description = :description, stock = :stock, "
                . "price = :price, special = :special, image = :image "
                . "WHERE id = :id");
        $query->bindParam(':image', $this->image, PDO::PARAM_LOB);
        $query->bindParam(':typeid', $this->typeid, PDO::PARAM_INT);
        $query->bindParam(':name', $this->name, PDO::PARAM_STR);
        $query->bindParam(':description', $this->description, PDO::PARAM_STR);
        $query->bindParam(':stock', $this->stock, PDO::PARAM_STR);
        $query->bindParam(':price', $this->price, PDO::PARAM_STR);
        $query->bindParam(':special', $this->special, PDO::PARAM_INT);
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $query->execute();
    }

    /**
     * Function resizeImage
     *
     * Resizes an image to specific aspect ratio. It does not crop so the image 
     * will be stretched. *Uses imagick module.*
     *
     * NOTE: This function is not used by default. It needs to be uncomemnted in
     * admin_edit_product and 
     * admin_add_product to enable it.
     * 
     * @param image file
     * @param int width of new image
     * @param int height of new image
     * @return image or false
     */
    static function resizeImage($image, $height, $width) {
        list($width) = getimagesize($image);
        $height = round($width / ($height / $width));
        $resizedimage = new Imagick($image);
        $status = $resizedimage->scaleImage($height, $width);
        if ($status) {
            return $resizedimage;
        } else {
            return false;
        }
    }

    function displayEditForm() {
        $output = include 'views/Product_editForm.php';
        return $output;
    }

    /**
     * Function delete
     *
     * Delete a whole product row
     * 
     * @return bool
     */
    function delete() {
        global $db;
        $query = $db->prepare("DELETE FROM Products WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':id', $this->id, PDO::PARAM_STR);
        $status = $query->execute();
        return $status;
    }

}

/**
 * Class Customer
 *
 * Handles the customer actions
 */
class Customer {

    public $id;
    public $firstname;
    public $lastname;
    public $streetaddress;
    public $streetnumber;
    public $zip;
    public $email;
    public $gender;

    function __construct($id = null) {
        if ($id) {
            global $db;
            $query = $db->prepare("SELECT * FROM Customers WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->setFetchMode(PDO::FETCH_INTO, $this);
            $query->execute();
            $query->fetch();
        }
    }

    function displayBox() {
        $output = include 'views/Customer_displayBox.php';
        return $output;
    }

    function displayCustomerDetails() {
        $output = include 'views/Customer_detailsTable.php';
        return $output;
    }

    function displayEditForm() {
        $output = include 'views/Customer_editForm.php';
        return $output;
    }

    /**
     * Function login
     *
     * Checks if the username and hashed password can be be found in 
     * the database. If it can be found set session customer logged in and set a 
     * session customer id. If it can not be found point head to function 
     * credentialsfalse
     *
     * @param string $email Email of the user
     * @param string $password Plain password of the user
     * 
     */
    static function login($email, $password) {
        global $db;
        global $passwordsalt;

        $password = hash("sha256", $password . $passwordsalt);

        $query = $db->prepare("SELECT * FROM Customers "
                . "WHERE email = :email AND password = :password");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Customer");
        if ($result) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['customer_logged_in'] = 1;
            $_SESSION['customer_id'] = $result[0]->id;
            if (isset($_SESSION['loginFalse']) && 
                    $_SESSION['loginFalse'] == 1) {
                $_SESSION['loginFalse'] == 0;
                header('Location: checkout.php');
            } else {
                header('Location: products.php');
            }
            exit();
        } else {
            header('Location: customer_login.php?fn=credentialsfalse');
            exit();
        }
    }

    /**
     * Function create
     *
     * Create a new customer. Before inserting the variable in the database the 
     * password + salt is hashed with sha256.
     *
     * @param string $email Email of the user
     * @param string $password Plain password of the user
     * @param string $streetaddress Streetname
     * @param string $streetnumber Integer in street + optional letter(s)
     * @param string $zip Zip code
     * @param string $firstname First name of user
     * @param string $lastname Last name of user
     * @param bool $gender 1 for male and 0 for female
     * 
     */
    static function create($email, 
            $password, 
            $streetaddress, 
            $streetnumber, 
            $zip, 
            $firstname, 
            $lastname, 
            $gender) {
        global $db;
        global $passwordsalt;

        $password = hash("sha256", $password . $passwordsalt);

        try {
            $query = $db->prepare("INSERT INTO Customers (email, password, "
                    . "streetaddress, streetnumber, zip, firstname, lastname, "
                    . "gender) VALUES (:email, :password, :streetaddress, "
                    . ":streetnumber, :zip, :firstname, :lastname, :gender)");
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':streetaddress', $streetaddress, PDO::PARAM_STR);
            $query->bindParam(':streetnumber', $streetnumber, PDO::PARAM_STR);
            $query->bindParam(':zip', $zip, PDO::PARAM_STR);
            $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_BOOL);
            $query->execute();
            if(isset($_SESSION['loginFalse']) && $_SESSION['loginFalse'] == 1) {
                Customer::login($email, $password);
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function checkMailOccurrance($email) {
        global $db;
        $query = $db->prepare("SELECT * FROM Customers WHERE email = :email");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function edit() {
        global $db;
        $query = $db->prepare("UPDATE Customers SET email = :email, "
                . "zip = :zip, gender = :gender, "
                . "streetaddress = :streetaddress, "
                . "streetnumber = :streetnumber, "
                . "firstname = :firstname, "
                . "lastname = :lastname  WHERE id = :id");
        $query->bindParam(':email', $this->email, PDO::PARAM_STR);
        $query->bindParam(':streetaddress', $this->streetaddress, 
                PDO::PARAM_STR);
        $query->bindParam(':streetnumber', $this->streetnumber, PDO::PARAM_STR);
        $query->bindParam(':zip', $this->zip, PDO::PARAM_STR);
        $query->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
        $query->bindParam(':gender', $this->gender, PDO::PARAM_BOOL);
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);
        $query->execute();
        return true;
    }

    /**
     * Function delete
     *
     * Deletes a customer from the database
     */
    function delete() {
        global $db;
        $query = $db->prepare("DELETE FROM Customers WHERE id = :id");
        $query->bindParam(':id', $this->id, PDO::PARAM_STR);
        $query->execute();
    }

    function changePassword($oldpassword, $newpassword, $newpassword2) {
        global $db;
        global $passwordsalt;
        if ($newpassword != "" && $newpassword == $newpassword2) {
            $oldpassword = hash("sha256", $oldpassword . $passwordsalt);
            $newpassword = hash("sha256", $newpassword . $passwordsalt);

            try {
                $query = $db->prepare("UPDATE Customers "
                        . "SET password=:newpassword "
                        . "WHERE id = :id AND password = :oldpassword");
                $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
                $query->bindParam(':oldpassword', $oldpassword, PDO::PARAM_STR);
                $query->bindParam(':id', $this->id, PDO::PARAM_INT);
                $query->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }

    static function getAllCustomers() {
        global $db;
        $query = $db->prepare("SELECT * FROM Customers");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Customer");
        return $result;
    }

    /**
     * Function logout
     *
     * Sets session to false and destroy
     */
    static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['customer_logged_in'] = 0;
        session_destroy();
    }

}

/**
 * Class Admin
 *
 * Handles the admin actions
 */
class Admin {

    public $id;
    public $username;
    public $password;
    public $description;

    function __construct($id = null) {
        if ($id) {
            global $db;
            $query = $db->prepare("SELECT * FROM Admins WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $query->fetch();
        }
    }

    function displayBox() {
        $output = include 'views/Customer_displayBox.php';
        return $output;
    }

    function changePassword($oldpassword, $newpassword) {
        global $db;
        global $passwordsalt;

        $oldpassword = hash("sha256", $oldpassword . $passwordsalt);
        $newpassword = hash("sha256", $newpassword . $passwordsalt);

        try {
            $query = $db->prepare("UPDATE Admins SET password=:newpassword "
            . "WHERE id = :id AND password=:oldpassword");
            $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $query->bindParam(':id', $this->id, PDO::PARAM_INT);
            $query->bindParam(':oldpassword', $oldpassword, PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function create($username, $password) {
        global $db;
        global $passwordsalt;

        $password = hash("sha256", $password . $passwordsalt);

        try {
            $query = $db->prepare("INSERT INTO Admins (username, password) "
            . "VALUES (:username, :password)");
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function login($username, $password) {
        global $db;
        global $passwordsalt;

        $password = hash("sha256", $password . $passwordsalt);

        $query = $db->prepare("SELECT * FROM Admins "
                . "WHERE username = :username AND password = :password");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Admin");
        if ($result) {
            session_start();
            $_SESSION['admin_logged_in'] = 1;
            header('Location: index.php');
            exit();
        } else {
            header('Location: admin_login.php?fn=credentialsfalse');
            exit();
        }
    }

    static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['admin_logged_in'] = 0;
        session_destroy();
    }

// show_order_list() prints a table to the screen which will contain all the
// orders which are stored in the database. It stores each order in a
// multidimensional array called 'orders' which is stored in the session array.
    static function show_order_list() {
        global $db;
        $i = 0;
        $_SESSION['orders'] = Array();
        $query = $db->query("SELECT id, customerid, date "
                . "FROM Orders ORDER BY id DESC");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while (true) {
            if ($row = $query->fetch()) {
                $_SESSION['orders'][$i]['orderNumber'] = $row['id'];
                $_SESSION['orders'][$i]['customerID'] = $row['customerid'];
                $_SESSION['orders'][$i]['date'] = $row['date'];
            } else {
                break;
            }
            $i += 1;
        }
        echo "<table>";
        echo "<th>Ordernummer</th>";
        echo "<th>Klantnummer</th>";
        echo "<th>Datum</th>";
        foreach ($_SESSION['orders'] as $order) {
            echo "<tr>";
            echo "<td>";
            echo "<form method='post' action='admin_orders.php'>"
            . "<input type='submit' name='order_number' value="
            . $order['orderNumber'] . ">"
            . "</form>";
            echo "</td>";
            echo "<td>" . $order['customerID'] . "</td>";
            echo "<td>" . $order['date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

// when given the orderID as parameter, show_order prints all the information
// about that order to the screen.
    static function show_order($orderID) {
        global $db;
        $date = Order::show_date($orderID);
        echo "<table class='order'>";
        echo "<tr>";
        echo "<td> factuurnummer: $orderID</td><td>$date</td>";
        echo "</tr>";
        Order::show_company_Info();
        Admin::show_customer_info($orderID);
	echo "</table>";
	echo "<table>";
        Order::show_order_table($orderID);
        echo "</table>";
        echo "<a href='admin_orders.php' class='button'>"
        . "<span>&#xf137;</span>terug naar orders</a>";
    }

// when given the orderID, show_customer_info prints all the information about
// the customer who made that order to the screen.
    static function show_customer_info($orderID) {
        global $db;
        $sqlQuery = "SELECT customerid FROM Orders WHERE id=$orderID";
        $query = $db->query($sqlQuery);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $row = $query->fetch();

        $customerID = $row['customerid'];
        $sqlQuery = "SELECT * FROM Customers WHERE id=$customerID";
        $query = $db->query($sqlQuery);
        $row = $query->fetch();
        echo "<td>";
        echo "<h3>Klantgegevens:</h3> <br>";
        echo "klantnummer: " . $customerID . "<br>";
        echo "voornaam: " . $row[6] . "<br>";
        echo "achternaam: " . $row[7] . "<br>";
        echo "adres: " . $row[8] . " ";
        echo $row[5] . "<br>";
        echo "postcode: " . $row[3] . "<br>";
        echo "email: " . $row[1] . "<br>";
        echo "</td>";
    }

}

class showMessage {

    public $messages = array();

    public function addMessage($type, $message) {
        $this->messages[] = array($type, $message);
    }

    public function showMessages() {
        foreach ($this->messages as $message) {
            if ($message[0] == "error") {
                echo "<span class=\"message\">"
                . "<span id=\"error\">ERROR: </span> " 
                . $message[1] . "</span>";
            } elseif ($message[0] == "success") {
                echo "<span class=\"message\">"
                . "<span id=\"success\">GELUKT: </span> " 
                . $message[1] . "</span>";
            } elseif ($message[0] == "notice") {
                echo "<span class=\"message\">"
                . "<span id=\"success\">NOTICE: </span> " 
                . $message[1] . "</span>";
            }
        }
        return true;
    }

}

// Initialize messages
$display = new showMessage();

/**
 * Class Order
 *
 * Handles the orders and billing
 */
class Order {

    public $id;
    public $customerid;
    public $customer;
    public $products;
    public $date;

// tryOrder tries to remove the the items of an order from the database.
// If tryOrder fails the user will be informed.
    static function tryOrder($products, $quantities, $names) {
        global $db;
        $updateQuery = "UPDATE Products SET stock=:value WHERE id=:id";
        $_SESSION['errorProducts'] = Array();
        for ($i = 0; $i < sizeof($products); $i++) {
            $query = $db->query("SELECT stock FROM Products "
            . "WHERE id=$products[$i]");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $row = $query->fetch();
            $stock = $row['stock'];
            $prodID = $products[$i];
            $ProdQuantity = $stock - $quantities[$i];

            $query = $db->prepare($updateQuery);
            $query->bindParam(':value', $ProdQuantity);
            $query->bindParam(':id', $prodID);
            if (!(($stock - $quantities[$i]) >= 0) || !$query->execute()) {
                array_push($_SESSION['errorProducts'], $names[$i]);
                $_SESSION['dbPullSuccess'] = false;
            }
            if ($i == (sizeof($products) - 1) && 
                    !isset($_SESSION['dbPullSuccess'])) {
                $_SESSION['dbPullSuccess'] = true;
            }
        }
    }

// executeOrder inserts the order into the database
    static function executeOrder($userID, 
            $productIDs, 
            $quantities, 
            $prices, 
            $names, 
            $payment_method) {
        global $db;
        $query = $db->prepare("INSERT INTO Orders (customerid, payment_method) "
                . "VALUES (:userID, :payment_method)");
        $query->bindParam(':userID', $userID, PDO::PARAM_INT);
        $query->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
        $query->execute();

        $result = $db->query("SELECT MAX(id) FROM Orders WHERE "
                . "customerid=$userID");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $resultArray = $result->fetch();
        $inserted_id = end($resultArray);

        foreach ($productIDs as $index => $order_product) {
            $query = $db->prepare("INSERT INTO Orders_Products "
                    . "(OrderID, productID, quantity,product_name,price) "
                    . "VALUES (:OrderID, :productID,:quantity, "
                    . ":product_name,:price)");
            $query->bindParam(":OrderID", $inserted_id, PDO::PARAM_INT);
            $query->bindParam(":productID", $order_product, PDO::PARAM_INT);
            $query->bindParam(":quantity", $quantities[$index], PDO::PARAM_STR);
            $query->bindParam(":price", $prices[$index], PDO::PARAM_INT);
            $query->bindParam(":product_name", $names[$index], PDO::PARAM_STR);
            $query->execute();
        }
    }

// when given an array of productID's getProductNames returns an array
// containing the product names of those id's
    static function getProductNames($IDarray) {
        global $db;
        $namesArray = Array();
        foreach ($IDarray as $ProductID) {
            $query = $db->query("SELECT name FROM Products "
            . "WHERE id=$ProductID LIMIT 1");
            $query->setFetchMode(PDO::FETCH_NUM);
            $resultArray = $query->fetch();
            $productName = end($resultArray);
            array_push($namesArray, $productName);
        }
        return $namesArray;
    }
// when given an array of productID's getProductPrices returns an array
// containing the product prices of those id's
    static function getProductPrices($IDarray) {
        global $db;
        $pricesArray = Array();
        foreach ($IDarray as $ProductID) {
            $query = $db->query("SELECT price FROM Products "
            . "WHERE id=$ProductID LIMIT 1");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $resultArray = $query->fetch();
            $productPrice = end($resultArray);
            array_push($pricesArray, $productPrice);
        }
        return $pricesArray;
    }
// shows a list of all the orders that a customer has made
    static function show_list_orders() {
        global $db;
        global $customer;
        $query = $db->prepare("SELECT id FROM Orders WHERE "
                . "customerid=:id ORDER BY id DESC");
        $query->bindParam(':id', $customer->id, PDO::PARAM_INT);
        $query->execute();
        $ordersArray = $query->fetchAll();
        for ($i = 0; $i < sizeof($ordersArray); $i++) {
            echo "<form method='post' action='customer_orders.php'>"
            . "<input type='submit' "
            . "name='order_number' value=" . $ordersArray[$i][0] . ">"
            . "</form>";
        }
    }
// shows a single order
    static function show_order($orderID) {
        global $db;
        $date = Order::show_date($orderID);
        echo "<table class='order'>";
        echo "<tr>";
        echo "<td> Factuurnummer: $orderID </td>";
	echo "<td>$date</td>";
        Order::show_company_Info();
        Order::show_customer_info($orderID);
        echo "</tr>";
	echo "</table>";
	echo "<table>";
        Order::show_order_table($orderID);
        echo "</table>";
    }
// shows the information about the company
    static function show_company_Info() {
        echo "<td class='company_info'>";
        echo "<h3>Bedrijfsinformatie</h3> <br>";
        echo "Adres: Fruytlaan 904 1234AB <br>";
        echo "Tel: 0201235813 <br>";
        echo "KvK: 21345589<br>";
        echo "</td>";
    }
// when given the orderID show_date shows the date and time that order has been
// made.
    static function show_date($orderID) {
        global $db;
        $query = $db->query("SELECT date FROM Orders WHERE id=$orderID");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $dateArray = $query->fetch();
        echo "datum: " . end($dateArray);
    }

// when given the orderID, show_customer_info shows the information about the
// customer who has made that order.
    static function show_customer_info($orderID) {
        global $db;
        global $customer;
        if (!isset($customer)) {
            $customer = $_SESSION['customer'];
        }
        echo "<td class='customer_info'>";
        echo "<h3>Klantgegevens:</h3> <br>";
        echo "klantnummer: " . $customer->id . "<br>";
        echo "voornaam: " . $customer->firstname . "<br>";
        echo "achternaam: " . $customer->lastname . "<br>";
        echo "adres: " . $customer->streetaddress . " ";
        echo $customer->streetnumber . "<br>";
        echo "postcode: " . $customer->zip . "<br>";
        echo "email: " . $customer->email . "<br>";
        echo "</td>";
    }
// when given the orderID show_order_table prints a table of the order to the
// screen.
    static function show_order_table($orderID) {
        global $db;
        $query = $db->query("SELECT quantity, product_name, "
                . "price FROM Orders_Products WHERE OrderID=$orderID");
        $query->setfetchMode(PDO::FETCH_ASSOC);

        echo "<tr>";
        echo "<th>";
        echo "Productnaam:";
        echo "</th>";
        echo "<th>";
        echo "Hoeveelheid:";
        echo "</th>";
        echo "<th>";
        echo "Prijs:";
        echo "</th>";
        echo "<th>";
        echo "Subtotaal:";
        echo "</th>";

        $total = 0;
        $subtotal = 0;
        while ($row = $query->fetch()) {
            echo "<tr>";
            echo "<td>";
            echo $row['product_name'];
            echo "</td>";
            echo "<td>";
            echo $row['quantity'];
            echo "</td>";
            echo "<td>";
            echo "<span class='iconfont'>&#xf153; </span>" . $row['price'];
            echo "</td>";
            echo "<td>";
            $subtotal = $row['price'] * $row['quantity'];
            echo "<span class='iconfont'>&#xf153; </span>" . $subtotal;
            echo "</td>";
            echo "<tr>";
            $total += $subtotal;
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "Totaal: <span class='iconfont'>&#xf153; </span>" . $total;
        echo "</td>";
        echo "</tr>";
    }
// If pulling data from the database has failed, printError will print which
// products have failed from being pulled from the database.
    static function printError() {
        echo "Van de volgende producten zijn helaas niet de gewenste aantallen "
        . "beschikbaar: <br>";
        foreach ($_SESSION['errorProducts'] as $errorProduct) {
            echo "- $errorProduct <br>";
        }
        echo "klik <a href='shopping_cart.php'> hier "
        . "</a> om uw bestelling aan te "
        . "passen of <a href='products.php'> hier </a> om verder te gaan met "
        . "winkelen.";
    }

}
