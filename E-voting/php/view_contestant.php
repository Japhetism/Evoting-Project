<?php
include_once("connection.php");
//session_start();
$election_id =$result1 ="";
include_once('session.php');
    if(isset($_GET["key"])) {
        $key=$_GET['key'];
        $election_id = substr($key,9,strlen($key)-17);
        $_SESSION["election_id_view"] = $election_id;

    }
    if(empty($_SESSION["election_id_view"])){
        header("Location:maindashboard.php");
    }

        $election_id_here = $_SESSION["election_id_view"];

        $sql2= $connection1->prepare("SELECT user_id FROM users WHERE email ='$myemail'");
        $sql2->execute();
        $result2= $sql2->setFetchMode(PDO::FETCH_ASSOC);
        $result2 = $sql2->fetchAll();
        $user_id = $result2[0]["user_id"];

        $sql= $connection1->prepare("SELECT * FROM joined WHERE election_id ='$election_id_here' AND user_id ='$user_id'");
        $sql->execute();
        $result= $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();

        if(empty($result)){
            header("Location:maindashboard.php");
        }

        $sql1 = $connection1->prepare("SELECT * FROM contestants WHERE election_id ='$election_id_here'");
        $sql1->execute();
        $result1 = $sql1->setFetchMode(PDO::FETCH_ASSOC);
        $result1 = $sql1->fetchAll();

        $images_dir = "../images/contestants/";

        $contestants_id = $picture_names =$contestants_user_ids=array();
        $contestants_post_id= array();

        if (!empty($result1)) {
            for($i=0;$i<count($result1);$i++){
                $contestants_id[$i]=$result1[$i]["contestant_id"];
                $picture_names[$i]= $images_dir . $result1[$i]["picture_name"];
                $contestants_user_ids[$i] = $result1[$i]["user_id"];
                $contestants_post_id[$i]= $result1[$i]["post_id"];
            }
        } else {
            echo "";
        }


        //to display the photo
        $con_photo = "";
         if(!empty($picture_names)){
                for($i=0;$i<count($picture_names);$i++) {

                    $sql4 = $connection1->prepare("SELECT post FROM posts WHERE post_id='$contestants_post_id[$i]'");
                    $sql4->execute();
                    $result4 = $sql4->setFetchMode(PDO::FETCH_ASSOC);
                    $result4 = $sql4->fetchAll();

                    $contestant_user_id= $contestants_user_ids[$i];
                    $sql3 =$connection1->prepare("SELECT fname, lname FROM users WHERE user_id='$contestant_user_id'");
                    $sql3->execute();
                    $result3 = $sql3->setFetchMode(PDO::FETCH_ASSOC);
                    $result3 = $sql3->fetchAll();

                    $contestant_picture_name="'".$picture_names[$i]."'";
                    $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$contestant_user_id.rand(10000,99999).rand(100,999);

                    $con_photo .= "<div class = 'col-xs-12 col-md-2 col-md-offset-1' style='background-image: url($contestant_picture_name);'>" .
                        "<a href='#' onclick='contestants($key)'>".
                        "<img src=$contestant_picture_name alt= $contestant_picture_name width='100px' height='100px'>" .
                        "</a>".
                        "<br>". $result3[0]["fname"]." ". $result3[0]["lname"].
                        "<br>Contesting for " .$result4[0]["post"].

                        "<br><a href='#' onclick='contestants($key)'>View Profile</a>".

                     "</div>";
                }
            }else{
                    $con_photo .= "";
                }
?>