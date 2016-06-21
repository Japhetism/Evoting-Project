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
function shit()
{
    global $connection1;
    $getElectionDetails=$connection1->prepare("SELECT * FROM election WHERE election_id=''");
    $getElectionDetails->execute();
    $getElectionDetails->setFetchMode(PDO::FETCH_ASSOC);
    $election_details1=$getElectionDetails->fetchAll();
    return $election_details1;

}
$myemail= "mummy@gmail.com";
$admin_photo = "SELECT fname, lname, picture_name FROM users WHERE user_id=1";
$result_admin = mysqli_query($connection2,$admin_photo);
$row1 = mysqli_fetch_assoc($result_admin);

print_r($row1);