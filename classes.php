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
    static function getAllProducts($type = null, $start_amount = 0) {
        global $db;
        if ($type) {
            $query = $db->prepare("SELECT * FROM Products WHERE typeid = :typeid ORDER BY name LIMIT :startamount, 5");
            $query->bindParam(':startamount', $start_amount, PDO::PARAM_INT);
            $query->bindParam(':typeid', $type, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        } else {
            $query = $db->prepare("SELECT * FROM Products ORDER BY name LIMIT :startamount, 5");
            $query->bindParam(':startamount', $start_amount, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        }
        return $result;
    }

    static function create($typeid, $name, $description, $image = null, $stock, $price) {
        global $db;
        $query = $db->prepare("INSERT INTO Products (typeid, name, description, image, stock, price) VALUES (:typeid, :name, :description, :image, :stock, :price)");
        $query->bindParam(':typeid', $typeid, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_LOB);
        $query->bindParam(':stock', $stock, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->execute();
    }

    function edit() {
        global $db;
        $query = $db->prepare("UPDATE Products SET typeid = :typeid, name = :name, description = :description, image = :image, stock = :stock, price = :price WHERE id = :id");
        $query->bindParam(':typeid', $this->typeid, PDO::PARAM_INT);
        $query->bindParam(':name', $this->name, PDO::PARAM_STR);
        $query->bindParam(':description', $this->description, PDO::PARAM_STR);
        $query->bindParam(':image', $this->image, PDO::PARAM_LOB);
        $query->bindParam(':stock', $this->stock, PDO::PARAM_STR);
        $query->bindParam(':price', $this->price, PDO::PARAM_STR);
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);
        $query->execute();
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
            if (is_int($id)) {
                // Get customer by id
                $query = $db->prepare("SELECT * FROM Customers WHERE id = :id");
            } else {
                // Get customer by email
                $query = $db->prepare("SELECT * FROM Customers WHERE email = :id");
            }
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
            echo $e->getMessage();
            exit();
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
        if ($result == FALSE) {
            header('Location: admin_login.php?fn=credentialsfalse');
            exit();
        } else {
            session_start();
            $_SESSION['admin_logged_in'] = 1;
            header('Location: index.php');
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

class showMessage{
    public $messages = array();
    public function addMessage($type, $message){
        $this->messages[] = array($type, $message);
    }
    public function showMessages(){
        foreach($this->messages as $message){
            if($message[0] == "error"){
                echo "<p>ERROR".$message[1]."</p>";
            }else{
                echo "<p>BERICHT:".$message[1]."</p>";
            }
        }
        return true;
    }
}

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

}