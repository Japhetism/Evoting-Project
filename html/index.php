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
    <meta name="google-site-verification" content="2ERX4arw9MZd-etZD-ru7sXrr9nLNcptyYuFoT7ciNQ" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Home</title>

    <!--    Bootstrap CSS-->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">


    <link href="../images/logo.png" rel="icon">

    <!--Custom fonts-->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!--    Custom CSS-->
    <link href="../css/index.css" type="text/css" rel="stylesheet">

    <style type="text/css">
    .row.details>.col-md-4>span{
        /*background: #666;*/
        /*background: url('../images/voteback2.jpg') no-repeat center;
        background-size: fill;*/
        color: transparent;
        width: 100%;
        padding: 5px;
        top: 0;
    }
    .row.details>.col-md-4{
        background: #fff;
        padding: 0;
        width: 30%;
        margin-right: 5%;
        font-size: 20px;
        box-shadow: 0px 0px 8px 0 rgba(0,0,0,0.2), 0px 0px 20px 0 rgba(0,0,0,0.19) ;
        margin-bottom: 25px;
    }
    .row.details>.col-md-4:last-of-type{
        margin-right: 0;
    }
    .image{
        padding: 10px 10px 30px 10px;
        /*box-shadow: 1px 2px 4px rgba(0,0,0,0.5);*/
        border: solid 1px #ddd;
        border-radius: 5px;
        background: #fff;
    }
    .image img{
        opacity: 0.9;
        background: #000;
    }
    </style>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <div id="reset_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- password reset form -->
            <form id="reset_form">
                <div class="modal-content" style="color:#555;">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reset Password</h4>
                  </div>
                  <div class="modal-body text-center">
                    <div id="form_field">
                        <input class="form-control" type="email" required="required" id="forgotten_password" name="email" placeholder="Enter Email Address">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>
                    <button type="submit" class="btn btn-success" id="submit_email">Submit</button>
                  </div>
                </div>
            </form>
        </div>
    </div>
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
                        <a class="page-scroll" href="#login">Login</a>
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
                        <p class="intro-text">let your vote count...</p>
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

    <!--login section-->
    <section id="login" class="container login-section text-center" style="padding: 0">
		<!--login section-->
        <div class="row login" style="margin: 0;padding: 20px 0px">
            <div class="col-sm-12 col-md-4 col-md-offset-4">
                <form action="<?php echo htmlspecialchars("#login");?>" method="post">
                    <fieldset class="home row">
                        <h4 style="color: white">login or <a href="signup.php#register">create an account</a> </h4>
                                <div class="col-sm-12 col-md-8 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input class="form-control" type="email" placeholder="Email address" name="lemail" value="<?php echo $lemail;?>" required/>
                                </div>
								<div class="col-sm-12 col-md-8 col-md-offset-2 input-group">
									<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
									<input class="form-control password" type="password" placeholder="Password"  name="lpassword" value="<?php echo $lpassword;?>" required/>
									<span class="input-group-addon after eyeChange"><i class="fa fa-eye" id="eye" ></i></span>
								</div>
                                <div class="col-sm-12 col-md-4 col-md-offset-4">
                                    <input type="submit" class="btn btn-success btn-block" name="login" value="LOGIN"><br>
                                </div>
                                <div class="col-sm-12">
                                    <a href="#" data-toggle="modal" data-target="#reset_modal">Forgot password?</a>
                                </div>
                            <?php echo $output2;?>
                            <br>
                            <span><?php if($confirmationMessage !="") echo($confirmationMessage);?></span>
                            <span class="error" ><?php echo $lmainError;?></span>
                    </fieldset>
                </form>
            </div>
        </div>
		<!--end of login section-->

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