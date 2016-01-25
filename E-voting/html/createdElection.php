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
			<ul class="nav navbar-nav side-nav sidebar">
				<h4><span class="fa fa-th-large"></span> Dashboard</h4>
				<li>
					<a href="#" style="font-weight:bolder;"><i class="fa fa-fw fa-th"></i>My Elections<i style="margin-left:50px;"class="fa fa-caret-down"></i></a>
					<ul class="nav nav-second-level">
						<li class="inactive">
							<a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Created Election<i style="margin-left:5px;"class="fa fa-caret-down"></i></a>
							<ul class="nav nav-third-level">
								<li>
									<a class="active active2" href="#">Post News</a>
								</li>
								<li>
									<a class="active2"href="#">Update Election</a>
								</li>
								<li>
									<a class="active2"href="#">Edit Partiipants</a>
								</li>
								<li>
									<a class="active2"href="#">View Results</a>
								</li>
							</ul>
							<!-- /.nav-third-level -->
						</li>
						<li>
							<a class="inactive" href="#"><i class="fa fa-edit"></i>Joined Election</a>
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

    <div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
           <div class="row">
                    <div class="col-md-12">
                        <h3>Post News</h3>
                    </div>
           </div>
               <div class="row">
                   <div class="col-md-11">
                       <textarea rows="4" style="max-width: 100%;min-width: 100%;max-height: 80px"></textarea>
                   </div>
                        <div class="col-md-11">
                            <input type="submit" value="POST">
                        </div>
               </div>
            <div class="row">
                <div class="col-md-12 news" style="margin-top: 50px;font-size:20px;">
                    <p>The Presidential and National Assembly elections in Nigeria were held on March 28-29, 2015. The INEC announced the official results in the early hours of April 1, 2015, Wednesday.</p>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" placeholder="write a comment" class="form-control">

                    </div>
                </div>
        </div>
            <div class="col-md-4">
            <h3 style="text-align: center">Invites</h3>
                <ul style="padding-left:80px;">
                    <li>adek</li>
                    <li>TAB</li>
                    <li>Sophia</li>
                </ul>
            </div>
    </div>
 </div>
</div>
<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>

