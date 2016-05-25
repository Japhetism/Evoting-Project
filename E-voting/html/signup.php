<?php
include('../php/register_login.php'); // Includes register and login script

if(isset($_SESSION['login_user'])){
    header('Location:maindashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting</title>

    <!--    Bootstrap CSS-->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!--    Custom CSS-->
    <link href="../css/index.css" type="text/css" rel="stylesheet">

    <!--Custom fonts-->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-play-circle"></i>  <span class="light">E -</span> Voting
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#register">register</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">E-voting</h1>
                        <p class="intro-text">The best voting option</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row about">
            <div class="col-lg-8 col-lg-offset-2">
                <h1>About E-voting</h1>
            </div>
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="row">
                        <div class="col-md-4"><span class="fa fa-plus"></span><p>Create and manage your own elections...</p></div>
                        <div class="col-md-4"><span class="fa fa-hand-paper-o"></span><p>Vote in an existing election...</p></div>
                        <div class="col-md-4"><span class="fa fa-newspaper-o"></span><p>View news on any election you're involved in...</p></div>
                    </div>
                </div>
        </div>
    </section>

    <!--register section-->
    <section id="register" class="container login-section text-center">
		<!--signup section-->
            <div id="signup" class="row signup">
                <div class="col-md-8 col-lg-offset-2">
                    <fieldset class="home">
                        <h4 style="color: white">Register or <a href="index.php#login" >sign in</a> </h4>
                        <form action="<?php echo htmlspecialchars("#register");?>" method="post">
                            <span class="error" ><?php echo $mainError;?></span><p>
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

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row contact">
            <div class="col-lg-8 col-lg-offset-2">
                <h1>Contact Us</h1>
                <p>E-mail us with your suggestions or complaints at any time </p>
                <p><a href="ouremail-link???">ouremail link??</a> </p>
            </div>
            <div class="col-lg-8 col-lg-offset-2">
                <div class="row">
                    <div class="col-md-12"><span class="fa fa-building-o"></span><h3>reach us at computer building,Ife</h3></div>
                    <div class="col-md-12"><span class="fa fa-facebook"></span><p></p></div>
                    <div class="col-md-12"><span class="fa fa-newspaper-o"></span><p>View news on any election you're involved in...</p></div>
                </div>
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