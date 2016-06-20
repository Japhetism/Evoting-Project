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

function nonsense()
{
    global $connection1;
    $post_query=$connection1->prepare("SELECT post_id,post_key,post FROM posts WHERE election_id=''");
    $post_query->execute();
    $post_query->setFetchMode(PDO::FETCH_ASSOC);
    $allPosts=$post_query->fetchAll();
    return $allPosts;
}
