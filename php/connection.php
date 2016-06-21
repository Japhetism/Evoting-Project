<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/22/16
 * Time: 6:24 PM
 */
function Connection($host, $username='root', $password, $dbname) {

    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true);
    try {
        $dbh = 'mysql:host=' .$host . '; dbname=' . $dbname;
        return new PDO($dbh, $username, $password, $options);
    }
    catch(PDOException $e) {
        return $e->getMessage();
    }

}
$password="eminence";
$dbname="oluwaranti";

$connection1 = Connection('localhost','root',$password,$dbname);
