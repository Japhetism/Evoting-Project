<?php
//include('../php/session.php');

session_start();

if(isset($_SESSION['login_user'])){
    $myemail = $_SESSION['login_user'];
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
                            <a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Created Election<i style="margin-left:5px;"class="fa fa-caret-down"></i></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a class="active2" href="postnews.php">Post News</a>
                                </li>
                                <li>
                                    <a class="active2"href="updateelectiondetails.php">Update Election</a>
                                </li>
                                <li>
                                    <a class="active active2"href="#">Edit Participants</a>
                                </li>
                                <li>
                                    <a class="active2"href="#">View Results</a>
                                </li>
                            </ul>
                            <!-- /.nav-third-level -->
                        </li>
                           <li class="inactive">
							<a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Joined Election</a>
						   </li>
				</ul>
                    <!-- /.nav-second-level -->
                </li>
            <li>
                <a href="createelection1.php" data-toggle="collapse" data-target="#steps"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
                <ul id="steps" class="collapse">
                    <li>
                        <a href="#">Step 1<i class="fa fa-spinner fa-spin"></i></a>
                    </li>
                    <li>
                        <a href="#">Step 2</a>
                    </li>
                    <li>
                        <a href="#">Step 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-plus-square"></i>Join an Election</a>
            </li>
        </ul>
        <!-- /.navbar-collapse -->
        </div>
    </nav>


    <div id="page-wrapper">
        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->

            <!-- /.row -->
            <div class="col-md-4 elections1">
                <div class="col-md-12 electheading">
                    <ol class="breadcrumb">
                        <li class="active">
                            Contestant
                        </li>
                    </ol>
                </div>
                <div class="col-md-12 electlist">
                    <ul>
                        <li><a href="#">Election 1</a></li>
                        <li><a href="#">Election 2</a></li>
                        <li><a href="#">Election 3</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 elections2">
                <div class="col-md-12 electheading">
                    <ol class="breadcrumb">
                        <li class="active">
                            Voters
                        </li>
                    </ol>
                </div>
                <div class="col-md-12 electlist">
                    <ul>
                        <li>Election 1</li>
                        <li>Election 2</li>
                        <li>Election 3</li>
                    </ul>
                </div>
             </div>
            <div class="col-md-4 elections2">
                <div class="col-md-12 electheading">
                    <ol class="breadcrumb">
                        <li class="active">
                            Invites
                        </li>
                    </ol>
                </div>
                <div class="col-md-12 electlist">
                    <ul>
                        <li>damiadek2009@gmail</li>
                        <li>taofeeqah.balogun@gmail.com</li>
                        <li>sofiebereshepherd@gmail.com</li>
                    </ul>
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

</body>

</html>

