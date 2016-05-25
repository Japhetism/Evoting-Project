<?php
include('../php/register_login.php'); // Includes register and login script

if(isset($_SESSION['login_user'])){
    header('Location:maindashboard.php');
}
$output2="";
$output3 = "Account Created Successfully, Check Your Email For confirmation";
if(isset($_GET['key'])){
    $output2=$_GET['key'];
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

    <!--Custom fonts-->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
    <!--    Custom CSS-->
    <link href="../css/index.css" type="text/css" rel="stylesheet">

    </script>

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
                        <a class="page-scroll" href="#about-section">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#login-section">Login</a>
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
    <section id="about-section" class="container content-section text-center">
        <div class="row about" id="about">
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

    <!--login section-->
    <section id="login-section" class="container login-section text-center">
        <!--login section-->
            <div id="login" class="row login">
                <div class="col-md-4 col-lg-offset-4">
                    <fieldset class="home">
                        <h4 style="color: white">login or <a href="signup.php#register">create an account</a> </h4>
                        <form action="<?php echo htmlspecialchars("#login");?>" method="post">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input class="form-control" type="email" placeholder="Email address" name="lemail" value="<?php echo $lemail;?>" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                                    <input class="form-control password" id="password" type="password" placeholder="Password"  name="lpassword" value="<?php echo $lpassword;?>" required/>
                                    <span class="input-group-addon after eyeChange">
                                    <i class="fa fa-eye" id="eye" ></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 ">
                                    <input type="submit" class="btn btn-success" name="login" value="LOGIN">
                                </div>
                            </div>
                            <?php echo $output2;?>
                            <br>
                            <?php
                            if($lmainError!=""){
                                echo('<span class="error" >'. $lmainError.'</span>');
                            }else{
                                echo($confirmationMessage);
                            }
                            ?>

                            </br>
                        </form>
                    </fieldset>
                </div>
            </div>
		<!--end of login section-->
            
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