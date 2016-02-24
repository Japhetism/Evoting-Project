<?php
include('../php/connection.php');
include_once('../php/session.php');
include_once('../php/database.php');
$string="";
$election_id=$_SESSION['election_id_view'];
$allPosts=getAllPosts($election_id);
//for each post,get contestant
$postCon=$display=$string_array=array();
$superIndex=array();
$image_dir="../images/contestants/";
for($i=0;$i<count($allPosts);$i++){
    $postCon[$allPosts[$i]['post']]=getAllContestants($allPosts[$i]['post_id']);
    array_push($superIndex,$allPosts[$i]['post']);
}
for($japhet=0;$japhet<count($postCon);$japhet++){
    $post_name=$superIndex[$japhet];
    if(!empty($postCon[$post_name])){
        $string='<div class = "row"><h1>'.$post_name.'</h1>';
        for($length=0;$length<count($postCon[$post_name]);$length++){
            $display=$postCon[$post_name][$length];
            //$display holds a contestant detail
            $image=$image_dir.$display['picture_name'];
            $string.='<div class = "col-xs-6 col-sm-4">
                        <input type="radio" name='.$post_name.' value='.$display['contestant_id'].'>
                        <img src='.$image.' width=50% height=50%><br>'.contestantName($display['user_id']).'';

            $string.='</div>';
        }
        $string.='</div>';
        array_push($string_array,$string);
    }else{
        //no contestant for the post post_name
    }

}
?>