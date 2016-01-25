<?php
//include('session.php');

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

    <title>Dashboard-createelection</title>

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
			<ul class="nav navbar-nav side-nav">
				<h4><span class="fa fa-th-large"></span> Dashboard</h4>
				<li >
					<a href="maindashboard.php" data-toggle="collapse" data-target="#accounts"><i class="fa fa-fw fa-th"></i>My Elections<i class="fa fa-fw fa-caret-right"></i></a>
						<ul id="accounts" class="collapse">
							<li>
								<a href="#"><i class="fa fa-fw fa-edit"></i>Manage Created Election</a>
							</li>
							<li>
								<a href="#"><i class="fa fa-fw fa-edit"></i>Manage Joined Election</a>
							</li>
						</ul>
				</li>
				<li class="active">
                    <a href="#" data-toggle="" data-target="#steps"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
                    <ul id="steps" class="collapse" style="display: block">
                        <li class="active">
                            <a class="active" href="#">Step 1<i class="fa fa-spinner fa-spin"> </i></a>
                        </li>
                        <li>
                            <a class="inactive" href="createelection2.php">Step 2</a>
                        </li>
                        <li>
                            <a class="inactive" href="#">Step 3</a>
                        </li>
                    </ul>
                </li>
			</ul>
		</div>
        <!-- /.navbar-collapse -->
    </nav>


    <div id="page-wrapper">

    <!-- /#page-wrapper -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 dash">
					<div class="col-lg-12">
						<h3 class="page-header1">
							Follow the instructions below to create an election
						</h3>
					</div>	
                    <div class="col-lg-12">
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
						<button class="btn btn-primary">submit</button>
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

</body>

</html>

