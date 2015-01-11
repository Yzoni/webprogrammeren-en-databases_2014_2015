<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
try {
    $db = new PDO('mysql:host=localhost;dbname=fruyts;charset=utf8', 'yorick', 'j5uwvKsh');
} catch (PDOException $e) {
    echo $e->getMessage();
}
$passwordsalt = "swagyoloenietsleuks";