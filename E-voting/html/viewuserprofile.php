<?php
//include('../php/session.php');
include('../php/register_login.php'); // Includes register and login script

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
			<ul class="nav navbar-nav side-nav">
				<h4><span class="fa fa-th-large"></span> Dashboard</h4>
				<li class="active">
					<a href="#"><i class="fa fa-fw fa-th"></i>My Elections<i class="fa fa-fw fa-caret-right"></i></a>
				</li>
				<li >
					<a href="createelection1.php"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
				</li>
				<li>
					<a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-fw fa-plus-square"></i>Join an Election</a>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
    </nav>
	
	
    <!--register section-->
    <section id="register" class="container login-section text-center">
		<!--signup section-->
            <div id="signup" class="row signup">
                <div class="col-md-8 col-lg-offset-2">
                    <fieldset class="home">
                        <h4 style="color: white">Register or <a href="index.php#login" >sign in</a> </h4>
                        <form action="<?php echo htmlspecialchars("#register");?>" method="post">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" type="text" placeholder="first name" name="fname" value="<?php echo $fname;?>" required/>
                                </div>
                                <div class="col-md-4 col-md-offset-1 input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input class="form-control" type="text" placeholder="last name" name="lname" value="<?php echo $lname;?>" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input class="form-control" type="text" placeholder="username" name="username" value="<?php echo $username;?>" required/>
                                </div>
                                <div class="col-md-4 col-md-offset-1 input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input class="form-control" type="email" placeholder="Email address" name="email" value="<?php echo $email;?>" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                                    <input class="form-control" id="password1" type="password" placeholder="Password" name="password1" value="<?php echo $password1;?>" required/><br>
									<span  onclick="showPassword('password1','eye1')" class="input-group-addon after"><i class="fa fa-eye" id="eye1"></i></span>
                                </div>
                                <div class="col-md-4 col-md-offset-1 input-group">
                                    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                                    <input class="form-control" id="password2" type="password" placeholder="confirm your password" name="password2" value="<?php echo $password2;?>" required/>
									<span  onclick="showPassword('password2','eye2')" class="input-group-addon after"><i class="fa fa-eye" id="eye2"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile-phone fa-fw"></i></span>
                                    <input class="form-control" type="tel" placeholder="phone number" name="phone" value="<?php echo $phone;?>" required/>
                                </div>
                                <div class="col-md-1 col-md-offset-1 input-group">
                                    <input  type="radio" name="sex" <?php if (isset($sex) && $sex=="male") echo "checked";?> value="male" required/>Male
                                </div>
                                <div class="col-md-2 input-group">
                                    <input type="radio" name="sex" <?php if (isset($sex) && $sex=="female") echo "checked";?> value="female" required/>Female
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 ">
                                  <input type="submit" class="btn btn-success" name="register" value="CREATE ACCOUNT" ></span>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
    </section>

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="../js/jquery.easing.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/file.js"></script>
</body>
</html>