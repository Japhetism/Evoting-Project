<?php
include_once("../php/connection.php");
session_start();
$myemail=$election_id =$result1 ="";
if(isset($_SESSION['login_user'])){
    $myemail = $_SESSION['login_user'];
}else{
    header("Location:index.php");
}
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
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function contestants(id){
            window.location = "viewContestantProfile.php?key=" + id;
        }
    </script>
</head>
<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="maindashboard.php">&nbsp E-voting</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $myemail;?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Edit profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav side-nav sidebar">
                <h4><span class="fa fa-th-large"></span> Dashboard</h4>
                <li>
                    <a href="maindashboard.php" style="font-weight:bolder;"><i class="fa fa-fw fa-th"></i>My Elections<i style="margin-left:50px;"class="fa fa-caret-down"></i></a>
                    <ul class="nav nav-second-level">
                           <li class="inactive">
							<a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Created Election</a>
						   </li>
                           <li class="inactive">
                            <a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Joined Election<i style="margin-left:5px;"class="fa fa-caret-down"></i></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a class="active active2"href="#">View Contestants</a>
                                </li>
                                <li>
                                    <a class="active2" href="registercandidate.php">Register As A Contestant</a>
                                </li>
                                <li>
                                    <a class="inactive"href="#">View Profile (Contestants only)</a>
                                </li>
                                <li>
                                    <a class="inactive"href="#">Vote</a>
                                </li>
                            </ul>
                             <!-- /.nav-third-level -->
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li >
                    <a class="inactive" href="#"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
                </li>
                <li>
                    <a class="inactive" href="#"><i class="fa fa-fw fa-plus-square"></i>Join an Election</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>


    <div id="page-wrapper">

        <!-- /#page-wrapper -->
            <!-- Page Heading -->
<div class = "container-fluid">
    <div class = "row">
        <?php
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

                    echo "<div class = 'col-xs-12 col-md-2 col-md-offset-1' style='background-image: url($contestant_picture_name);'>" .
                        "<a href='#' onclick='contestants($key)'>".
                        "<img src=$contestant_picture_name alt= $contestant_picture_name width='100%' height='100%'>" .
                        "</a>".
                        "<br>". $result3[0]["fname"]." ". $result3[0]["lname"].
                        "<br>Contesting for " .$result4[0]["post"].

                        "<br><a href='#' onclick='contestants($key)'>View Profile</a>".

                     "</div>";
                }
            }else{
                    echo "<h1>"."Contestants are yet to register for this election."."</h1>";
                }

        ?>

    </div>
</div>
            </div>
    </div>

<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- custom js -->
<script src="../js/file.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>
</html>