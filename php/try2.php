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
$election_id_check_query="SELECT * FROM election WHERE election_id=1";
$election_id_check= mysqli_query($connection2,$election_id_check_query);
$election_details= mysqli_fetch_row($election_id_check);
print_r(getElectionDetails(1));