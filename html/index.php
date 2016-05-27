<?php
include('../php/register_login.php'); // Includes register and login script
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
            <!-- <div class="col-lg-8 col-lg-offset-2"> -->
                <!-- <h1>About E-voting</h1> -->
            <!-- </div> -->
                    <div class="row" id="comfort">
                        <div class="col-md-4 col-md-offset-1 image">
                            <img src="../images/voting/voteipad.jpg" height="100%" width="100%">
                        </div>
                        <div class="col-md-6 col-md-offset-1 about-description">
                            <hr>
                            <h3>Comfort</h3>
                             You can vote anywhere, anytime<br>
                             on your <span class="text-success">mobile</span> device...
                        </div>

                        <!-- <div class="col-md-4"><span class="fa fa-plus" style="background: url('../images/voting/voteipad.jpg') no-repeat center; background-size: cover;"></span><p>Vote anywhere, anytime...</p></div>
                        <div class="col-md-4"><span class="fa fa-hand-paper-o" style="background: url('../images/voting1.jpg') no-repeat center; background-size: cover;"></span><p>Vote in an existing election...</p></div>
                        <div class="col-md-4"><span class="fa fa-newspaper-o"></span><p>View realtime election updates...</p></div> -->
                    </div>
                    <div class="row" id="realtime">
                        <div class="col-md-6 about-description">
                            <hr>
                            <h3>Real-time</h3>
                             Election results are updated<br> <span class="text-success">per second...</span>
                             
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
                            <h3>Comfort</h3>
                             You can vote anywhere, anytime<br>
                             on your <span class="text-success">mobile</span> device...
                        </div>

                        <!-- <div class="col-md-4"><span class="fa fa-plus" style="background: url('../images/voting/voteipad.jpg') no-repeat center; background-size: cover;"></span><p>Vote anywhere, anytime...</p></div>
                        <div class="col-md-4"><span class="fa fa-hand-paper-o" style="background: url('../images/voting1.jpg') no-repeat center; background-size: cover;"></span><p>Vote in an existing election...</p></div>
                        <div class="col-md-4"><span class="fa fa-newspaper-o"></span><p>View realtime election updates...</p></div> -->
                    </div>
        </div>
    </section>

    <!--login section-->
    <section id="login" class="container login-section text-center" style="padding: 0">
		<!--login section-->
        <div class="row login" style="margin: 0;padding: 20px 0px">
            <div class="col-md-4 col-md-offset-4">
                <form action="<?php echo htmlspecialchars("#login");?>" method="post">
                    <fieldset class="home">
                        <h4 style="color: white">login or <a href="signup.php#register">create an account</a> </h4>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input class="form-control" type="email" placeholder="Email address" name="lemail" value="<?php echo $lemail;?>" required/>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-8 col-md-offset-2 input-group">
									<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
									<input class="form-control password" type="password" placeholder="Password"  name="lpassword" value="<?php echo $lpassword;?>" required/>
									<span class="input-group-addon after eyeChange"><i class="fa fa-eye" id="eye" ></i></span>
								</div>
							</div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <input type="submit" class="btn btn-success" name="login" value="LOGIN">
                                </div>
                            </div>
                            <br>
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
            var nav = $('.navbar').offset().top;
            console.log(nav);

        });

    </script>
</body>
</html>