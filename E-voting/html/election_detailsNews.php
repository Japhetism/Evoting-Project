<?php
include('../php/post_news.php');
include('../php/view_contestant.php');
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
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
                        <a href="../php/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
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
                                    <a class="active active2"href="#">Election Details</a>
                                </li>
                                <li>
                                    <a class="active2" href="registercandidate.php">Register As A Contestant</a>
                                </li>
                                <li>
                                    <a class="inactive"href="#">View Profile (Contestants only)</a>
                                </li>
                                <li>
                                    <a class="active2" href="voting.php">Vote</a>
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
        <div class="container-fluid">
            <!-- Page Heading -->

            <!-- /.row -->
            <div class="row electionDetail">
                <div class="col-md-12">
                    <div class="col-md-8 electheading">
                        <ol class="breadcrumb">
                            <li class="active">
                                <?php echo $election_name;?>
                            </li>
                        </ol>
                    </div>
                    <!-- Other details should be here  -->
                    <div class="col-md-8 electlist">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="panel panel-success">
                                    <div class="panel-heading">ADMIN DETAILS:<br><?php echo $election_admin_details.$election_admin_detail;?></div>
                                    <div class="panel-body">
                                        <p><?php echo $election_details;?></p>



                                    </div>
                                </div>


                            </div>

                            <div class="">
                                <?php echo $con_photo;?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="panel panel-info">
                                    <div class="panel-heading">News</div>
                                    <div class="panel-body">
                                        <p><?php echo $view_posted_news;?></p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>



        <!--    wrapper-->


        <!-- jQuery -->
        <script src="../js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Custom JavaScript -->
        <script src="../js/file.js"></script>
</body>
</html>