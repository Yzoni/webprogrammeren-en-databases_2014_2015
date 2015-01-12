<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'config.php';


function is_admin_logged_in(){
    session_start();
    if($_SESSION['admin_logged_in'] && $_SESSION['admin_logged_in'] == 1){
        //we zijn ingelogd
        return true;
    }else{
        header('Location: http://www.2woorden9letters.nl');
        exit();
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
    
    function register(){
        
    }

    function displayBox() {
        $output = include 'views/Customer_displayBox.php';
        return $output;
    }

    static function getAllCustomers() {
        global $db;
        $query = $db->prepare("SELECT * FROM Customers");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Customer");
        return $result;
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
    
    function changePassword($newpassword) {

    }
    
    static function create($username, $password){
        global $db;
        global $passwordsalt;
        
        $password = hash("sha256", $password.$passwordsalt);
        
        try {
            $query = $db->prepare("INSERT INTO Admins (username, password) VALUES (:username, :password)");
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
        
    }
    
    static function login($username, $password){
        global $db;
        global $passwordsalt;
        
        $password = hash("sha256", $password.$passwordsalt);
        
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
    
    static function logout(){
        session_destroy();
    }
}