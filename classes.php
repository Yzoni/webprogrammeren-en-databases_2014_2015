<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'config.php';

class ProductType {
    public $id;
    public $name;
    
    function __construct($id = null) {
        if($id){
            global $db;
            $query = $db->prepare("SELECT * FROM ProductTypes WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->setFetchMode(PDO::FETCH_INTO, $this);
            $query->execute();
            $query->fetch();
        }
        
        //$this->products = Product::getAllProducts($this->id);
    }
    
    static function getAllProductTypes(){
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
    
    function __construct($id = null) {
        if($id){
            global $db;
            $query = $db->prepare("SELECT * FROM ProductTypes WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $query->fetch(PDO::FETCH_INTO, $this);
        }
        $this->type = new ProductType($this->typeid);
    }
    
    function displayBox(){
        $output = include 'views/Product_displayBox.php';
        return $output;
    }
    
    static function getAllProducts($type = null){
        global $db;
        if($type){
            $query = $db->prepare("SELECT * FROM Products WHERE typeid = :typeid");
            $query->bindParam(':typeid', $type, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        }else{
            $query = $db->prepare("SELECT * FROM Products");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        }
        return $result;
    }
}
