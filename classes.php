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
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == 1) {
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
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == 1) {
        // Logged in
        return true;
    } else {
        // Not logged in        
        header("location: index.php");
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
    if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] == 1) {
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
    if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] == 1) {
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
        $query = $db->prepare("UPDATE ProductTypes SET name = :name WHERE id = :id");
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
            $query->fetch();
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

    static function countProducts($type = null) {
        global $db;
        if ($type) {
            $query = $db->prepare("SELECT * FROM Products WHERE typeid = :typeid");
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
     * @return object with subobjects as products
     */
    static function getAllProducts($type = null, $startamount = 0, $endamount = 6, $special = 0) {
        global $db;
        if ($type) {
            $query = $db->prepare("SELECT * FROM Products WHERE typeid = :typeid ORDER BY name LIMIT :startamount, :endamount");
            $query->bindParam(':startamount', $startamount, PDO::PARAM_INT);
            $query->bindParam(':endamount', $endamount, PDO::PARAM_INT);
            $query->bindParam(':typeid', $type, PDO::PARAM_INT);
        } elseif ($special == 1) {
            $query = $db->prepare("SELECT * FROM Products WHERE special = 1 ORDER BY name");
        } else {
            $query = $db->prepare("SELECT * FROM Products ORDER BY name LIMIT :startamount, :endamount");
            $query->bindParam(':startamount', $startamount, PDO::PARAM_INT);
            $query->bindParam(':endamount', $endamount, PDO::PARAM_INT);
        }
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $result;
    }

    static function search($word) {
        global $db;
        $query = $db->prepare("SELECT * FROM Products WHERE name LIKE :word ORDER BY name");
        $str = '%' . $word . '%';
        $query->bindParam(':word', $str);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $result;
    }

    static function getSortedProducts($sort) {
        global $db;
        switch ($sort) {
            case alphabetic :
                $sortingQuery = "SELECT * FROM Products ORDER BY name ASC";
                break;
            case price-desc :
                $sortingQuery = "SELECT * FROM Products ORDER BY price DESC"; 
                break;
            case price-asc :
                $sortingQuery = "SELECT * FROM Products ORDER BY price ASC";
                break;
        }        
        $query = $db->prepare($sortingQuery);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $result;
    }

    static function create($typeid, $name, $description, $stock, $price, $special, $image = null) {
        global $db;
        $query = $db->prepare("INSERT INTO Products (typeid, name, description, stock, price, special, image) VALUES (:typeid, :name, :description, :stock, :price, :special, :image)");
        $query->bindParam(':typeid', $typeid, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':stock', $stock, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':special', $special, PDO::PARAM_INT);
        $query->bindParam(':image', $image, PDO::PARAM_LOB);
        return $query->execute();
    }

    function edit() {
        global $db;
        $query = $db->prepare("UPDATE Products SET typeid = :typeid, name = :name, description = :description, stock = :stock, price = :price, special = :special, image = :image WHERE id = :id");
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

    static function resizeImage($image) {
        list($width) = getimagesize($image);
        $height = round($width / (5 / 16));
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

    function delete() {
        global $db;
        $query = $db->prepare("DELETE FROM Products WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':id', $this->id, PDO::PARAM_STR);
        $query->execute();
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
     * Checks if the username and hashed password can be be found in the database
     * If it can be found set session customer logged in and set a session 
     * customer id. If it can not be found point head to function credentialsfalse
     *
     * @param string $email Email of the user
     * @param string $password Plain password of the user
     * 
     */
    static function login($email, $password) {
        global $db;
        global $passwordsalt;

        $password = hash("sha256", $password . $passwordsalt);

        $query = $db->prepare("SELECT * FROM Customers WHERE email = :email AND password = :password");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Customer");
        if ($result) {
            session_start();
            $_SESSION['customer_logged_in'] = 1;
            $_SESSION['customer_id'] = $result[0]->id;
            header('Location: index.php');
            exit();
        } else {
            header('Location: customer_login.php?fn=credentialsfalse');
            exit();
        }
    }

    static function create($email, $password, $streetaddress, $streetnumber, $zip, $firstname, $lastname, $gender) {
        global $db;
        global $passwordsalt;

        $password = hash("sha256", $password . $passwordsalt);

        try {
            $query = $db->prepare("INSERT INTO Customers (email, password, streetaddress, streetnumber, zip, firstname, lastname, gender) VALUES (:email, :password, :streetaddress, :streetnumber, :zip, :firstname, :lastname, :gender)");
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':streetaddress', $streetaddress, PDO::PARAM_STR);
            $query->bindParam(':streetnumber', $streetnumber, PDO::PARAM_STR);
            $query->bindParam(':zip', $zip, PDO::PARAM_STR);
            $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_BOOL);
            $query->execute();
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
        $query = $db->prepare("UPDATE Customers SET email = :email, zip = :zip, gender = :gender, streetaddress = :streetaddress, streetnumber = :streetnumber, firstname = :firstname, lastname = :lastname  WHERE id = :id");
        $query->bindParam(':email', $this->email, PDO::PARAM_STR);
        $query->bindParam(':streetaddress', $this->streetaddress, PDO::PARAM_STR);
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
                $query = $db->prepare("UPDATE Customers SET password=:newpassword WHERE id = :id AND password = :oldpassword");
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

    function changePasswordAdmin($newpassword, $newpassword2) {
        global $db;
        global $passwordsalt;
        if ($newpassword != "" && $newpassword == $newpassword2) {
            $newpassword = hash("sha256", $newpassword . $passwordsalt);

            try {
                $query = $db->prepare("UPDATE Customers SET password=:newpassword WHERE id = :id");
                $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
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

    static function passwordRecovery($email) {
        global $db;
        $headers = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=iso-8859-1";
        $headers[] = "From: Sender Name <noreply@fruyt.nl>";
        $headers[] = "Reply-To: Recipient Name {$email}";
        $headers[] = "Subject: Wachtwoordherstel fruyt.nl";
        $headers[] = "X-Mailer: PHP/" . phpversion();

        $customer = new Customer($email);
        $newpassword = hash("sha256", time());
        $customer->changePasswordAdmin($newpassword, $newpassword);
        $deliverd = mail($customer->email, "Wachtwoordherstel fruyt.nl", "Nieuwe wachtwoord is: " . $newpassword, implode("\r\n", $headers));
        if ($deliverd) {
            echo "true";
        } else {
            echo "not deliverd";
        }
    }

    /*
      http://stackoverflow.com/questions/712392/send-email-using-the-gmail-smtp-server-from-a-php-page
      static function sendMail() {
      require_once "Mail.php";

      $from = '';
      $to = '';
      $subject = 'Hi!';
      $body = "Hi,\n\nHow are you?";

      $headers = array(
      'From' => $from,
      'To' => $to,
      'Subject' => $subject
      );

      $smtp = Mail::factory('smtp', array(
      'host' => 'ssl://smtp.gmail.com',
      'port' => '465',
      'auth' => true,
      'username' => '',
      'password' => ''
      ));

      $mail = $smtp->send($to, $headers, $body);

      if (PEAR::isError($mail)) {
      echo('<p>' . $mail->getMessage() . '</p>');
      } else {
      echo('<p>Message successfully sent!</p>');
      }
      }
     */
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
            $query = $db->prepare("UPDATE Admins SET password=:newpassword WHERE id = :id AND password=:oldpassword");
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
            $query = $db->prepare("INSERT INTO Admins (username, password) VALUES (:username, :password)");
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

        $query = $db->prepare("SELECT * FROM Admins WHERE username = :username AND password = :password");
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

}

class showMessage {

    public $messages = array();

    public function addMessage($type, $message) {
        $this->messages[] = array($type, $message);
    }

    public function showMessages() {
        foreach ($this->messages as $message) {
            if ($message[0] == "error") {
                echo "<span class=\"message\"><span id=\"error\">ERROR: </span> " . $message[1] . "</span>";
            } elseif ($message[0] == "success") {
                echo "<span class=\"message\"><span id=\"success\">GELUKT: </span> " . $message[1] . "</span>";
            } elseif ($message[0] == "notice") {
                echo "<span class=\"message\"><span id=\"success\">NOTICE: </span> " . $message[1] . "</span>";
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

    // tryOrder tries to remove the the items of the order from the database.
    // If tryOrder fails the user will be informed.
    static function tryOrder($products, $quantities, $names) {
        global $db;
        $updateQuery = "UPDATE Products SET stock=:value WHERE id=:id";
        $_SESSION['errorProducts'] = Array();
        for ($i = 0; $i < sizeof($products); $i++) {
            $query = $db->query("SELECT stock FROM Products WHERE id=$products[$i]");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $row = $query->fetch();
            $stock = $row['stock'];
            $prodID = $products[$i];
            $ProdQuantity = $stock - $quantities[$i];

            $query =  $db->prepare($updateQuery);
            $query->bindParam(':value', $ProdQuantity);
            $query->bindParam(':id', $prodID);
            if(!(($stock - $quantities[$i]) >= 0) || !$query->execute()) {
                    array_push($_SESSION['errorProducts'], $names[$i]);
                    $_SESSION['dbPullSuccess'] = false;
            }
            if($i == (sizeof($products) - 1) && !isset($_SESSION['dbPullSuccess'])) {
                $_SESSION['dbPullSuccess'] = true;
            }
        }
    }
    // executes order
    static function executeOrder($userID,
                        $productIDs,
                        $quantities,
                        $prices,
                        $names,
                        $payment_method) {
        global $db;
        $query = $db->prepare("INSERT INTO Orders (customerid, payment_method) VALUES (:userID, :payment_method)");
        $query->bindParam(':userID', $userID, PDO::PARAM_INT);
        $query->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
        $query->execute();

        $result = $db->query("SELECT MAX(id) FROM Orders WHERE customerid=$userID");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $resultArray = $result->fetch();
        $inserted_id = end($resultArray);

        foreach ($productIDs as $index => $order_product) {
            $query = $db->prepare("INSERT INTO Orders_Products (OrderID, productID, quantity,product_name,price) VALUES (:OrderID, :productID,:quantity, :product_name,:price)");
            $query->bindParam(":OrderID", $inserted_id, PDO::PARAM_INT);
            $query->bindParam(":productID", $order_product, PDO::PARAM_INT);
            $query->bindParam(":quantity", $quantities[$index], PDO::PARAM_STR);
            $query->bindParam(":price", $prices[$index], PDO::PARAM_INT);
            $query->bindParam(":product_name", $names[$index], PDO::PARAM_STR);
            $query->execute();
        }
    }

    static function getProductNames($IDarray) {
        global $db;
        $namesArray = Array();
        foreach ($IDarray as $ProductID) {
            $query = $db->query("SELECT name FROM Products WHERE id=$ProductID LIMIT 1");
            $query->setFetchMode(PDO::FETCH_NUM);
            $resultArray = $query->fetch();
            $productName = end($resultArray);
            array_push($namesArray, $productName);
        }
        return $namesArray;
    }

    static function getProductPrices($IDarray) {
        global $db;
        $pricesArray = Array();
        foreach ($IDarray as $ProductID) {
            $query = $db->query("SELECT price FROM Products WHERE id=$ProductID LIMIT 1");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $resultArray = $query->fetch();
            $productPrice = end($resultArray);
            array_push($pricesArray, $productPrice);
        }
        return $pricesArray;
    }

    static function show_list_orders() {
        global $db;
        global $customer;
        $query = $db->prepare("SELECT id FROM Orders WHERE customerid=:id");
        $query->bindParam(':id', $customer->id, PDO::PARAM_INT);
        $query->execute();
        $ordersArray = $query->fetchAll();
        for ($i = 0; $i < sizeof($ordersArray); $i++) {
            echo "<form method='post' action='customer_orders.php'>"
            . "<input type='submit' name='order_number' value=" . $ordersArray[$i][0] . ">"
            . "</form>";
        }
    }

    static function show_order($orderID) {
        global $db;
        $date = Order::show_date($orderID);
        echo "<table>";
        echo "<tr>";
        echo "<td> factuurnummer: $orderID <br> $date</td>";
        echo "</tr>";
        Order::show_company_Info();
        Order::show_customer_info($orderID);
        Order::show_order_table($orderID);
        echo "</table>";
    }

    static function show_company_Info() {
        echo "<td>";
        echo "<h3>BedrijfsInformatie</h3> <br>";
        echo "Adres: fruytlaan 904 1234AB <br>";
        echo "Tel: 0201235813 <br>";
        echo "KvK: <br>";
        echo "</td>";
    }

    static function show_date($orderID) {
        global $db;
        $query = $db->query("SELECT date FROM Orders WHERE id=$orderID");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $dateArray = $query->fetch();
        echo "datum: " . end($dateArray);
    }

    static function show_customer_info($orderID) {
        global $db;
        global $customer;
        echo "<td>";
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

    static function show_order_table($orderID) {
        global $db;
        $query = $db->query("SELECT quantity, product_name, price FROM Orders_Products WHERE OrderID=$orderID");
        $query->setfetchMode(PDO::FETCH_ASSOC);

        echo "<tr>";
        echo "<th>";
        echo "Hoeveelheid:";
        echo "</th>";
        echo "<th>";
        echo "Productnaam:";
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
            echo $row['quantity'];
            echo "</td>";
            echo "<td>";
            echo $row['product_name'];
            echo "</td>";
            echo "<td>";
            echo $row['price'];
            echo "</td>";
            echo "<td>";
            $subtotal = $row['price'] * $row['quantity'];
            echo $subtotal;
            echo "</td>";
            echo "<tr>";
            $total += $subtotal;
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "Totaal: $total";
        echo "</td>";
        echo "</tr>";
    }
    
    static function printError() {
        echo "Van de volgende producten zijn helaas niet de gewenste aantallen "
        . "beschikbaar <br>";
        foreach($_SESSION['errorProducts'] as $errorProduct) {
            echo "- $errorProduct <br>";
        }
        echo "klik <a href='shopping_cart.php'> hier </a> om uw bestelling aan te "
        . "passen. of <a href='products.php'> hier </a> om verder te gaan met"
        . "winkelen";
    }
}
