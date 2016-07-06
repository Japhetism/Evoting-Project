<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 7/6/16
 * Time: 10:28 AM
 */
include_once('../php/connection.php');
include_once('../php/function.php');
include_once('../php/database.php');

//get all elections yet to receive reminder
//extract those that will start in at least two hours time but not yet ended (2 step authentication which may not be necessary)
//get the email of those joined to the election
//send reminder