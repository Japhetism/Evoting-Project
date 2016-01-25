<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/22/16
 * Time: 6:24 PM
 */
     function Connection($type,$host,$username='root',$password,$dbname ){

        if($type==='PDO'){
            $dbh = "mysql:host =" .$host . "; $dbname =" . $dbname;
            try {
//                print 'No be PDO connection error o';
                return new PDO($dbh, $username, $password);
            }
            catch(PDOException $e) {
                return $e->getMessage();

            }

        }elseif($type==='mysqli'){
            try{
                return mysqli_connect($host,$username,$password,$dbname);

            }catch (mysqli_sql_exception $a){
                return $a->getMessage();
            }

        }else{
            print 'neither PDO not mysqli connection successful';

        }
    }

$connection1= Connection('PDO','localhost','root','eminence','eVoting');
$connection1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$connection2=  Connection('mysqli','localhost','root','eminence','eVoting');