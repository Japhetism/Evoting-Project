<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/22/16
 * Time: 6:24 PM
 */
function Connection($type, $host, $username='root', $password, $dbname) {
    if($type==='PDO') {
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true);
        try {
            $dbh = 'mysql:host=' .$host . '; dbname=' . $dbname;
            return new PDO($dbh, $username, $password, $options);
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }
    elseif($type==='mysqli') {
        try{
            return mysqli_connect($host, $username, $password, $dbname);

        }
        catch (mysqli_sql_exception $a) {
            return $a->getMessage();
        }

    }
    else {
         die('No connection to Database');
    }
}
$password="eminence";
$dbname="oluwaranti";

$connection1 = Connection('PDO','localhost','root',$password,$dbname);
$connection2 =  Connection('mysqli','localhost','root',$password,$dbname);