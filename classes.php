<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'config.php';

function is_admin_logged_in() {
    session_start();
    if ($_SESSION['admin_logged_in'] && $_SESSION['admin_logged_in'] == 1) {
        //we zijn ingelogd
        return true;
    } else {
        header('Location: http://www.2woorden9letters.nl');
        exit();
        // niet ingelogd
    }
}

function is_customer_logged_in() {
    session_start();
    if ($_SESSION['customer_logged_in'] && $_SESSION['customer_logged_in'] == 1) {
        //we zijn ingelogd
        return true;
    } else {
        return false;
        // niet ingelogd
    }
}

/*
 * Class ProductType
 *
 * what the class does
 *
 */

class ProductType {

    public $id;
    public $name;

    /*
     * Function getAllProductTypes
     *
     * gets all productTypes from the database and fetches it all into 1 big object with subobject of the class "productType"
     *
     * @return (object) object with subobjects as ProductType
     */

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

    /*
     * Function getAllProductTypes
     *
     * gets all productTypes from the database and fetches it all into 1 big object with subobject of the class "productType"
     *
     * @return (object) object with subobjects as ProductType
     */

    static function getAllProductTypes() {
        global $db;
        $query = $db->prepare("SELECT * FROM ProductTypes");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "ProductType");
        return $result;
    }

    static function create($id) {
        global $db;
        $query = $db->prepare("INSERT INTO ProductTypes (id) VALUES (:id)");
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
    }

    static function edit($id, $newname) {
        global $db;
        $query = $db->prepare("UPDATE ProductTypes SET name = :newname WHERE name = :oldname");
        $query->bindParam(':oldname', $oldname, PDO::PARAM_STR);
        $query->bindParam(':newname', $newname, PDO::PARAM_STR);
        $query->execute();
    }

    static function delete($id) {
        global $db;
        $query = $db->prepare("DELETE FROM ProductTypes WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
    }

}

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

    function displayBox() {
        $output = include 'views/Product_displayBox.php';
        return $output;
    }

    static function getAllProducts($type = null) {
        global $db;
        if ($type) {
            $query = $db->prepare("SELECT * FROM Products WHERE typeid = :typeid");
            $query->bindParam(':typeid', $type, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        } else {
            $query = $db->prepare("SELECT * FROM Products");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        }
        return $result;
    }

    static function create($typid, $name, $description, $image = null, $stock, $price) {
        global $db;
        $query = $db->prepare("INSERT INTO Products (typid, name, description, image, stock, price) VALUES (:typid, :name, :description, :image, :stock, :price)");
        $query->bindParam(':typeid', $typeid, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->bindParam(':stock', $stock, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->execute();
    }

    static function edit() {
        //TO DO EDIT PRODUCT
    }

    static function delete($id) {
        global $db;
        $query = $db->prepare("DELETE FROM Products WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
    }

}

class Customer {

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $gender;

    function __construct($id = null) {
        if ($id) {
            global $db;
            $query = $db->prepare("SELECT * FROM Customers WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $query->fetch();
        }
    }

    function displayBox() {
        $output = include 'views/Customer_displayBox.php';
        return $output;
    }

    static function login($email, $password) {
        global $db;
        global $passwordsalt;

        $password = hash("sha256", $password . $passwordsalt);

        $query = $db->prepare("SELECT * FROM Customers WHERE email = :email AND password = :password");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Customer");
        if ($result == FALSE) {
            header('Location: http://www.2woorden9letters.nl');
            exit();
        } else {
            session_start();
            $_SESSION['customer_logged_in'] = 1;
            header('Location: /index.php');
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
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function edit($oldvar, $newvar) {
        global $db;
        $query = $db->prepare("UPDATE Customers SET :newvar WHERE :oldvar");
        $query->bindParam(':oldvar', $oldvar, PDO::PARAM_STR);
        $query->bindParam(':newvar', $newvar, PDO::PARAM_STR);
        $query->execute();
        return true;
    }

    function changePassword($email, $oldpassword, $newpassword) {
        global $db;
        global $passwordsalt;

        $oldpassword = hash("sha256", $oldpassword . $passwordsalt);
        $newpassword = hash("sha256", $newpassword . $passwordsalt);

        try {
            $query = $db->prepare("UPDATE Customer SET password=:newpassword WHERE email=:email oldpassword=:oldpassword");
            $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':oldpassword', $oldpassword, PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getAllCustomers() {
        global $db;
        $query = $db->prepare("SELECT * FROM Customers");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Customer");
        return $result;
    }

    static function logout() {
        $_SESSION['customer_logged_in'] = 0;
        session_destroy();
    }

}

class Admin {

    public $id;
    public $username;
    public $password;
    public $description;

    function __construct($id = null) {
        if ($id) {
            global $db;
            $query = $db->prepare("SELECT * FROM Admins WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $query->fetch();
        }
    }

    function displayBox() {
        $output = include 'views/Customer_displayBox.php';
        return $output;
    }

    function changePassword($username, $oldpassword, $newpassword) {
        global $db;
        global $passwordsalt;

        $oldpassword = hash("sha256", $oldpassword . $passwordsalt);
        $newpassword = hash("sha256", $newpassword . $passwordsalt);

        try {
            $query = $db->prepare("UPDATE Admin SET password=:newpassword WHERE username=:username oldpassword=:oldpassword");
            $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $query->bindParam(':username', $newpassword, PDO::PARAM_STR);
            $query->bindParam(':oldpassword', $newpassword, PDO::PARAM_STR);
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
            header('Location: http://www.2woorden9letters.nl');
            exit();
        } else {
            session_start();
            $_SESSION['admin_logged_in'] = 1;
            header('Location: /admin.php');
            exit();
        }
    }

    static function logout() {
        $_SESSION['admin_logged_in'] = 0;
        session_destroy();
    }

    function addProduct() {
        
    }

}

class Order {

    public $id;
    public $customerid;
    public $customer;
    public $products;
    public $date;

    function addProduct($id, $quantity) {
        
    }

    function deleteProduct($id, $quantity) {
        
    }

    static function getAllOrders($customerid = null) {
        
    }

}
