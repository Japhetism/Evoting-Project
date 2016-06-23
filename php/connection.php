<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/22/16
 * Time: 6:24 PM
 */
$servername = "127.0.0.1";
$username = "";
$password = "";

try {
    $connection1 = new PDO("mysql:host=$servername;dbname=dbname", $username, $password);
    // set the PDO error mode to exception
    $connection1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}