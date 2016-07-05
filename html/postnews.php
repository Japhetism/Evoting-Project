<?php
include_once('../php/session.php');
include_once('../php/post_news.php');
include_once('../php/photo.php');
include_once('../php/view_contestant.php');
include_once('../php/connection.php');

//get election key
$key = $_GET['key'];
$election_idd = unwrap($key);
//check if key is valid
$election_details = getElectionDetails($election_idd);
//redirect if election is not present
if(count($election_details) === 0)
{
   header("Location:maindashboard.php");
}else
{
  $election_id = $election_details[0]["election_id"];
  //check if the user is truly the admin of the election using the session email and the election id
  if($election_details[0]["user_id"] != user_id($myemail))
  {
     header("Location:maindashboard.php");
  }else
  {
    $date_diff = strtotime(date($election_details[0]["election_start_date"])) - strtotime(date("Y-m-d"));
    $_SESSION['election_id'] = $key;
  }

    $_SESSION['adek_link'] = 'postnews.php?key='. $_SESSION['election_key'];
    $_SESSION['adek_status'] = 'Admin';
}


?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <script type="text/javascript">
        function news(id){
            window.location = "editnews.php?under=" +id;
        }
    </script>
    <script type="text/javascript">
        function contestants(id){
            window.location = "viewContestantProfile.php?key=" + id;
        }
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Election Details</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <style type="text/css"> 
        .panel-primary img{
            width: 50px;
            height: 50px;
            padding: 8px;
            margin: none;
        }
        .panel-success>.panel-heading{
            color: #fff
        }
        .panel-heading {
            padding: 10px 15px;
            border: none;
        }
        .panel-title {
            font-size: 12px;
            border: none;
        }
        .panel-title, .panel-title .pull-right {
            line-height: 20px;
        }
        h4 {
            font-weight: 500;
            color: #242a30;
            border:  none;
            line-height: none;
        }
        .registered-users-list {
            margin: 7.5px;
            padding: 0;
            list-style-type: none;
        }
        .registered-users-list>li {
            width: 25%;
            float: left;
            padding: 7.5px;
            color: #333;
        }
        .panel-heading{
            opacity: 0.8;
        }
        .panel-title{
            font-size: 15px;
            text-align: left;
            font-weight: bold;

        }
        .panel-primary>.pa{

        }
        .panel-primary{
            border: none;
        }
        .panel-body{
            background-color: rgba(230, 230, 230, 0.2 );
        }
        #page-wrapper{
            background-color: rgba(51,122,183,0.1);
        }
        .me{
            overflow: hidden;
            text-overflow: ellipsis;

        }
        .btn-primary{
            border-color: rgb(255, 255, 255);
            border: 1px;
            background-color: #337ab7;
        }
        tr{
            background: rgba(0,0,0,0.1);
            width:30%;
        }
        th{
            color:black;
            opacity: 0.8;
            width:30%;
        }
        .table>thead>tr>th{
            background: rgba(230,230,230,0.8)!important;
        }
        .img {
            margin-bottom:20px;
            width: 100%;
            padding-bottom: 5%;
            border: 1px solid #ccc;
            float: left;
            text-overflow: ellipsis;
            overflow: hidden;
            position: relative;
            /*box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 1px 1px;*/
        }
        .img img {
            width: 100%;
            height: 230px;
        }
        .view-profile {
            padding-top: 50%;
            text-align: center;
            text-overflow: ellipsis;
            overflow: hidden;
            right: 100%;
            position: absolute;
            top: 0%;
            color: transparent;
            background: transparent;
            width: 100%;
            opacity: 1;
            height:100%;
            transition: right 0.4s,background 0.5s, color 0.7s;
        }
        .img:hover{
            background: #fff;
        }
        .img:hover .desc b,
        .img:hover .desc small{
            color:#888;
        }
        .img:hover img{
            opacity: 0.7;
        }
        .img:hover .view-profile{
            right: 0;
            background: rgba(0,0,0,0.15);
            color: #fff;
            cursor: pointer;
        }
        .desc{
            text-align: center;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        .img .view-profile .btn{
            color: transparent;
            background: transparent;
            border: solid 1px transparent;
            transition:all 0.6s;
            transition-delay: 0.2s;
        }
        .img:hover .view-profile .btn{
            color:#fff;
            background: rgba(0,0,0,0.3);
            border: solid 1px #ccc;
            width: 80%;
            cursor: pointer;
            font-weight: bold;
        }
        .img:hover .view-profile .btn:hover{
            color: #777;
            background: #eee;
            transition:background .2s,color .4s,border .4s;
        }
        th:last-child{
            text-align: left;
            background: rgba(230,230,230,0.8)!important;
        }
        i.badge{
            top: 40px;
            right: -35px;
            padding: 5px 15px;
            opacity: 1;
        }
        i.badge:after{
            top: -5px;
            bottom: 15px;
            left: 45%;
            opacity: 1;
            box-shadow: none;
        }
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_once('navlinks.php');?>
    
    
    <!--page wrapper opens-->
    <div id="page-wrapper">
    
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel" style="color:black;border:none;">Enter the election pin</h3>
                    </div>
                    <form  method="POST" id="thatForm" >
                        <div class="modal-body row" id="input" style="text-align:center;" >
                            <div class=" col-md-4 col-md-offset-4 " >
                                <input type="text" name="pin" class=" form-control" style="background: rgba(0,0,0,0.1);text-align:center;" placeholder="PIN">
                            </div>
                            <p class="col-md-8 col-md-offset-2 " id="output"></p>
                        </div>
                        <div class="modal-footer" id="input2">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Join" id="formSubmit">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--container fluid opens-->
        <div class="container-fluid">

            <!-- container header-->
            <div class="row">
                <div class="page-title col-md-12">
                    <h3>Election Details</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li class="active"><?php echo $_SESSION['election_name'];?></li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->

            <!--nested row opens-->
            <div class="row">

                <!--col-md-8 opens-->

                <div class="col-xs-12 col-md-8">

                    <!--col-md-8 row1 opens-->

                    <div class="row">

                        <!--col-md-8 row1 col-md-12 opens-->
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">ELECTION DETAILS
                                </div>
                                <div class="panel-body">
                                    <h2><?php echo $election_name;?></h2>
                                    <p><?php echo $election_details_test;?><br>
                                    <?php echo $posts_table;?>
                                </div>
                            </div>
                        </div>
                        <!--col-md-8 row1 col-md-12 closes-->
                        
                    </div>
                    <!--col-md-8 row1 closes-->

                    <!--col-md-8 row2 opens-->

                    <div class="row">

                        <!--col-md-8 row2 col-md-12 opens-->
                        <div class="col-xs-12 col-md-12" style="height: auto">
                            <div class="panel panel-primary" >
                                <div class="panel-heading">
                                    <h4 class="panel-title" style="text-align: center;">CONTESTANTS</h4>
                                </div>
                                <div class="panel-body" style="padding: 0px;">
                                    <div style="text-align: left; max-height:340px; overflow-y:auto; overflow-x:hidden;padding-top:10px;">
                                        <div class="row" style="text-align: center">
                                            <div class="col-md-12" >
                                                <?php
                                                if(!empty($contestants_array)) {
                                                    for ($efe = 0; $efe < count($contestants_array); $efe++) {
                                                        echo $contestants_array[$efe];
                                                    }
                                                }else{
                                                    echo "<h3>"."Contestants are yet to register for this election."."</h3>";
                                                }
                                                ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--col-md-8 row2 col-xs-12 col-md-12 closes-->
                    </div>
                    <!--col-md-8 closes-->
                </div>
                <!--col 8 closes-->

                <!--col-md-4 opens-->

                <div class="col-xs-12 col-md-4">
                <!--post news opens-->
                    <div class="col-xs-12 col-md-12">
                        <form method="post">
                            <label>Post News </label><br>
                            <textarea name="post_news" id="post_news" class="form" rows="3" cols="40"></textarea><br>
                            <input class="btn btn-default pull-right" type="submit" value="POST" name="post_submit" id="post_submit">
                        </form><br><br>
                    </div>
                <!--news opens-->  
                    <div class="col-xs-12 col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">News</h4>
                            </div>
                            <div class="panel-body posted_news" style="overflow-y:auto;">
                                <p><?php echo $posted_news;?></p>
                            </div>
                        </div>
                    </div>
                <!--news closes-->
                </div>
                <!--col-md-4 closes-->
            </div>
            <!--nested row closes-->

        </div>
        <!--container fluid closes-->

    </div>
    <!--page wrapper closes-->


<!-- jQuery -->
<!-- <script src="../js/jquery.js"></script> -->

<!-- Bootstrap Core JavaScript -->
<!-- <script src="../js/bootstrap.min.js"></script> -->
<!-- <script src="../js/request.js"></script>-->
<script src="../js/file.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var height = getScreenHeight();

        $('.posted_news').css('max-height',height);
    });
</script>

</body>

</html>

