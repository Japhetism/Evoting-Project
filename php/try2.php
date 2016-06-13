<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/29/16
 * Time: 3:22 PM
 */
include ('connection.php');
include_once('csv.php');
include_once('database.php');
include_once('function.php');
//$e=getAllMembers('users',['*'],['user_id','=',1])[0];
//print_r(getAllMembers('users', array('email'), array('status', '=', 1), 1));
$super = [
    0 => [
        'id' => 1,
        'nam' => 'gab'
    ],
    1 => [
        'id' => 2,
        'nam' => 'ken'
    ],
    3 => [
        'id' => 3,
        'nam' => 'jaf'
    ],
    4 => [
        'id' => 4,
        'nam' => 'adek'
    ],
];
//$admin_query = "SELECT
//                    election.election_name,users.fname AS admin_fname,users.lname AS admin_lname
//                FROM
//                    election
//                LEFT JOIN
//                    users
//                ON
//                    election.user_id = users.user_id
//                WHERE
//                    election_id = 1";
//$admin = $connection1->prepare($admin_query);
//$admin->execute();
//$admin->setFetchMode(PDO::FETCH_ASSOC);
//$admin = $admin->fetchAll()[0];
//print_r($admin);
sendEmail('gabrieloyetunde@gmail.com','Gabriel','Testing','goo');
//print_r(getAllMembers('users',['*'],['user_id','=',1])[0]);
?>
