<?php
include_once('../php/view_Contestant_Profile.php');
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
        <div class="navbar-ex1-collapse">
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
                                        <a class="active2"href="viewcontestant.php">View Contestants</a>
                                    </li>
                                    <li>
                                        <a class="active2" href="registercandidate.php">Register As A Candidate</a>
                                    </li>
                                    <li>
                                        <a class="active active2"href="#">View Profile (Contestants only)</a>
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
        </div>
    </nav>


    <div id="page-wrapper">

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <h3 class="page-header">
                        <?php echo $contestant_fullname." profile"?>
                    </h3>
                </div>
            <!-- profile column -->
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1 " style="border-radius: 10px;margin-top: 15px">
                            <?php echo "<img src='$contestant_picture' alt='' width='100%' height='100%'>"; ?><br>
                        </div>
                        <div class="col-md-6 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>Full Name: </h4><?php echo $contestant_fullname; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>Nickname: </h4><?php echo $contestant_nickname; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-md-8">

                                    <h4>E-mail Address: </h4><?php echo $contestant_email ;?>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-md-8">
                                    <h4>Contesting for: </h4><?php echo $contestant_post . " in ". $contestant_election_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-md-8">
                                    <h4>Manifestos: </h4><?php
                                    if(!empty($manifestos)) {

                                        echo "<ul>";
                                        for ($i = 0; $i < count($manifestos); $i++) {
                                            echo "<li>" . $manifestos[$i] . "</li>";
                                        }
                                        echo "</ul>";
                                    }else{
                                        echo "None";
                                    }
                                    if(!empty($contestant_citation)) {
                                        $download_link=$citation_dir.$contestant_citation;
                                    echo  "<a href='$download_link' download>"."Download citation here"."</a>";
                                    }
                                    else {
                                        echo "<h4>Contestant Citation: None</h4>";
                                    }

                                        ?>
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

    <!-- custom js -->
    <script src="../js/file.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>

