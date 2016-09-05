<?php
include_once('../php/register_login.php'); // Includes register and login script
include_once('../php/function.php');

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

    <title>E-voting | Register</title>

    <!--    Bootstrap CSS-->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link href="../images/logo.png" rel="icon">

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
    <section id="about" class="container-fluid content-section text-center">
        <div class="about">
            <div class="row" id="comfort">
                <div class="col-md-4 col-md-offset-1 image">
                    <img src="../images/voting/voteipad.jpg" height="100%" width="100%">
                </div>
                <div class="col-md-6 col-md-offset-1 about-description">
                    <hr>
                    <h3>Comfort</h3>
                     You can vote anywhere, anytime, even <br>
                     on your <span class="text-success">mobile</span> device...
                </div>
            </div>
            <div class="row" id="realtime">
                <div class="col-md-6 about-description">
                    <hr>
                    <h3>Real-time</h3>
                     View election results in <br> <span class="text-success">real-time...</span>

                </div>
                <div class="col-md-4 col-md-offset-1 image">
                    <img src="../images/voting/voteanywhere.jpg" height="100%" width="100%">
                </div>
            </div>
            <div class="row" id="description">
                <div class="col-md-4 col-md-offset-1 image">
                    <img src="../images/voting/voteipad.jpg" height="100%" width="100%">
                </div>
                <div class="col-md-6 col-md-offset-1  about-description">
                    <hr>
                    <h3>Integrity</h3>
                     Election results are <span class="text-success">accurate</span> <br>
                     and void of manipulation...
                </div>
            </div>
        </div>
    </section>

    <!--register section-->
    <section id="register" class="container login-section text-center" style="padding: 0;">
		<!--signup section-->
            <div id="signup" class="row login" style="margin: 0;padding: 20px 0px">
                <div class="col-sm-12 col-md-8 col-md-offset-2">
                    <fieldset class="home row">
                        <h4 style="color: white; margin-left: 50px;">Register or <a href="index.php#login" >sign in</a> </h4>
                        <form action="<?php echo htmlspecialchars("#register");?>" method="post">
                            <span class="error" ><?php echo $mainError;?></span><p>
                            <span class="error"><?php echo $output;?></span><p>
                                <div class="col-sm-12 col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" type="text" placeholder="first name" name="fname" value="<?php echo $fname;?>" maxlength="25" required/>
                                </div>
                                <div class="col-sm-12 col-md-4 col-md-offset-1 input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input class="form-control" type="text" placeholder="last name" name="lname" value="<?php echo $lname;?>" maxlength="25" required/>
                                </div>
                                <div class="col-sm-12 col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input class="form-control" type="text" placeholder="username" name="username" value="<?php echo $username;?>" maxlength="25" required/>
                                </div>
                                <div class="col-sm-12 col-md-4 col-md-offset-1 input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input class="form-control" type="email" placeholder="Email address" name="email" value="<?php echo $email;?>" maxlength="40" required/>
                                </div>
                                <div class="col-sm-12 col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-key fa-fw"></i>
                                    </span>
                                    <input class="form-control password" id="password1" type="password" placeholder="Password" name="password1" value="<?php echo $password1;?>" minlength="6" required/><br>
                                    <span class="input-group-addon after eyeChange">
                                        <i class="fa fa-eye" id="eye"></i>
                                    </span>
                                </div>
                                <div class="col-sm-12 col-md-4 col-md-offset-1 input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-key fa-fw"></i>
                                    </span>
                                    <input class="form-control password" id="password2" type="password" placeholder="confirm your password" name="password2" value="<?php echo $password2;?>" minlength="6" required/>
                                    <span class="input-group-addon after eyeChange">
                                        <i class="fa fa-eye" id="eye"></i>
                                    </span>
                                </div>
                                <div class="col-sm-12 col-md-4 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile-phone fa-fw"></i></span>
                                    <input class="form-control" type="number" placeholder="phone number" name="phone" value="<?php echo $phone;?>" maxlength="14" required/>
                                </div>
                                <div class="col-sm-6 col-md-2 col-md-offset-1 input-group">
                                    <input  type="radio" name="sex" <?php if (isset($sex) && $sex=="male") echo "checked";?> value="male" required/>Male
                                </div>
                                <div class="col-sm-6 col-md-2 input-group" style="margin-left: 20px;">
                                    <input type="radio" name="sex" <?php if (isset($sex) && $sex=="female") echo "checked";?> value="female" required/>Female
                                </div>
                                <div class="col-sm-12 col-md-4 col-md-offset-4" >
                                  <input type="submit" class="btn btn-success btn-block" name="register" value="CREATE ACCOUNT"></span><br>
                                </div>
                                <div class="col-sm-12">
                                    <a href="index.php#login">Forgot password?</a>
                                </div>
                        </form>
                    </fieldset>
                </div>
            </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row contact">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6 text-right b_r">
                        <i class="fa fa-building-o"></i>
                        Room 011, computer building, Obafemi Awolowo University, Ile-Ife.
                    </div>
                    <div class="col-sm-6 text-left">
                        <a href="www.facebook.com/oauevoting" class="text-default">
                            Contact on us facebook
                            <span class="fa-stack fa-sm">
                              <i class="fa fa-square-o fa-stack-2x text-primary"></i>
                              <i class="fa fa-facebook fa-stack-1x text-primary"></i>
                            </span>
                        </a>
                    </div>
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

    <script type="text/javascript">
        // jQuery to collapse the navbar on scroll
        $(window).scroll(function() {
            if ($(".navbar").offset().top > 50) {
                $(".navbar-fixed-top").addClass("top-nav-collapse");
            } else {
                $(".navbar-fixed-top").removeClass("top-nav-collapse");
            }

            if ($('.navbar').offset().top > 280) {
                $('#comfort>.image').animate({'opacity':"1"},400,function(){
                    $('#comfort>.about-description').animate({'opacity':'1'},400);
                        $('#comfort>.about-description>h3, #comfort>.about-description>hr').animate({'top':"0",'opacity':'0.9'},400);
                });
            }
            if ($('.navbar').offset().top > 610) {
                $('#realtime>.image').animate({'opacity':"1"},400,function(){
                    $('#realtime>.about-description').animate({'opacity':'1'},400);
                    $('#realtime>.about-description>h3, #realtime>.about-description>hr').animate({'top':"0",'opacity':'0.9'},400);
                });
            }
            if ($('.navbar').offset().top > 900) {
                $('#description>.image').animate({'opacity':"1"},400,function(){
                    $('#description>.about-description').animate({'opacity':'1'},400);
                    $('#description>.about-description>h3, #description>.about-description>hr').animate({'top':"0",'opacity':'0.9'},400);
                });
            }

        });

    </script>

</body>
</html>