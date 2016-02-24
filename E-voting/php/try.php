<?php
include ('connection.php');
include_once('database.php');
include_once('function.php');

$array= array('bad'=>'mus','gab'=>'riel');
$array1=array('1','h','ddf','fdsd','jhj','hd','14');

$allPosts=getAllPosts(1);


$postCon=$display=array();
$superIndex=array();
for($i=0;$i<count($allPosts);$i++){
    $postCon[$allPosts[$i]['post']]=getAllContestants($allPosts[$i]['post_id']);
    array_push($superIndex,$allPosts[$i]['post']);
}
//print_r($postCon);

for($japhet=0;$japhet<count($postCon);$japhet++){
    $post_name=$superIndex[$japhet];
    if(!empty($postCon[$post_name])){
        for($length=1;$length<2;$length++){
            $display=$postCon[$post_name][$length];
            print_r($display);
        }
    }else{
        //no contestant for the post post_name
    }
//
}