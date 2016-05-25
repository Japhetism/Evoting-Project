<?php
include_once('../php/session.php');
include_once('../php/photo.php');
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Create Election</title>

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
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <a class="navbar-brand" href="#">
                    <!-- logo -->
                    <i class="fa fa-play-circle"></i>  <span class="light">E -</span> Voting
                </a>
        </div>
        <!-- Top-right Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown userActions">
                <a href="#" class="dropdown-toggle showActions" id="showActions" data-toggle="dropdown">
                    <i>
                        <img src="<?php echo $photo_fetched;?>" width="30px" height="30px" >
                    </i>
                        <?php echo $myemail;?>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu userOptions" id="userOptions">
                    <li>
                        <a href="viewuserprofile.php"><i class="fa fa-user"></i> View Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="../php/logout.php"><i class="fa fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
        <ul class="nav navbar-nav side-nav sidebar" id="MainMenu">
                <li class="col-md-12 ">
                    <div class="row userProfile" id="userActions">
                        <div class="col-md-12 userActions">
                            <img src="<?php echo $photo_fetched;?>" alt="???" width="100px" height="100px" style="border-radius:100%;"><br><br>
                            <b><?php echo $fullname;?></b><br>
                            <strong>User</strong>
                        </div>
                    </div>
                </li>
                <!-- link to dashboard -->
                <li class="active">
                        <a href="maindashboard.php" class="active"><i class="fa fa-dashboard"></i>
                        Dashboard</a>
                </li>
                
                <li class="active">
                    <a data-target="#" class="inactive" data-toggle="collapse" data-parent="#MainMenu">
                        <i class="fa fa-pencil-square-o"></i>
                            Manage Elections
                        <i class="fa fa-angle-left pull-right" style="width:10px;"></i>
                    </a>
                    <ul class="collapse" id="demo3">   
                        <li id="demo3_1" >    
                            <a href="#" class="inactive" > Public Elections<i class="btn pull-right success" >1 </i></a>
                        </li>
                        <li class="active1" id="demo3_2" target="table_2" >
                            <a class="active" data-toggle="collapse" data-target="#SubMenu">
                                Created Elections<i class="btn pull-right primary" >2</i>
                            </a>
                            <ul class="nav collapse" id="SubMenu">
                                <li class="active1">
                                    <a href="#" class="active" data-parent="#SubMenu1">
                                    Election Details
                                    </a>
                                </li>
                                <li>
                                    <a href="updateelectiondetails.php" class="active" data-parent="#SubMenu1">Update Election</a>
                                </li>
                                <li>
                                    <a href="editparticipant.php" class="active">Edit Participants</a>
                                </li>
                                <li>
                                    <a href="#" class="active" data-parent="#SubMenu1">View Results</a>
                                </li>
                            </ul>
                        </li>   
                        <li target="table_3" id="demo3_3" >    
                            <a href="#" data-target="#" data-toggle="collapse" class="inactive" > Joined Elections<i class="btn pull-right warning" >3</i></a>
                            <ul class="nav collapse" id="SubMenu1">
                                <li>
                                    <a href="#" class="inactive" data-parent="#SubMenu1">
                                    Election Details
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="inactive" data-parent="#SubMenu1">Register as a Contestant</a>
                                </li>
                                <li>
                                    <a href="#" class="inactive">View Profile(contestants Only)</a>
                                </li>
                                <li>
                                    <a href="#" class="inactive" data-parent="#SubMenu1">Vote</a>
                                </li>
                            </ul>
                        </li>   
                        <li target="table_4" id="demo3_4" >    
                            <a href="#" class="inactive" > Pending Invites<i class="btn pull-right danger" >4</i></a>
                        </li>   
                        <li target="table_5" id="demo3_5" >    
                            <a href="#" class="inactive" > Pending Requests<i class="btn pull-right default" >5</i></a>
                        </li>
                    </ul>
                </li>
                    
                <li class="active" >
                    <a href="#" data-target="#demo4" class="active" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus"></i>Create an Election<i class="fa fa-angle-left pull-right" ></i></a>
                        <ul class="open collapse in" id="demo4">
                            <li>
                                <a href="#" class="active">Step 1<i class="fa fa-spinner fa-spin pull-right" ></i></a>
                            </li>
                            <li>
                                <a href="#" class="inactive">Step 2<i class="fa fa-pencil-square-o pull-right" ></i></a>
                            </li>
                            <li>
                                <a href="#" class="inactive">Step 3<i class="fa fa-check-circle pull-right" ></i></a>
                            </li>
                        </ul>
                </li>
                <li class="active">
                    <a href="#" class="inactive" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-user-plus"></i>Join an election
                    </a>
                </li>
                    
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>



    <div id="page-wrapper">

            <!-- container header-->
            <div class="row">
                <div class="page-title col-md-12">
                    <h3>Create Election</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li><a href="#">Create Election</a></li>
                            <li class="active">Step 1</li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->

    <!-- /#page-wrapper -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2 dash">
					<div class="col-xs-12">
						<h3 class="page-header1">
							Follow the instructions below to create an election
						</h3>
					</div>	
                    <div class="col-xs-12">
                        <fieldset class="info">
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                            Explain how the admin should go about the election creation.<br>
                        </fieldset>
                    </div>
					<div class="col-md-8 col-md-offset-2" id="success">
					<form action="createelection2.php">
						<input type="checkbox" required/> I agree to the terms and conditions<br> 
						<button class="btn btn-success">submit</button>
					</form>
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

<!-- custom js-->
<script src="../js/file.js"></script>

</body>

</html>

