<?php
include_once('../php/register_candidate.php');
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

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
                        <a href="../php/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="navbar-ex1-collapse">
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav side-nav sidebar">
                <h4><span class="fa fa-th-large"></span> Dashboard</h4>
                <li>
                    <a href="maindashboard.php" style="font-weight:bolder;"><i class="fa fa-fw fa-th"></i>My Elections<i style="margin-left:50px;"class="fa fa-caret-down"></i></a>
                    <ul class="nav nav-second-level">
                           <li class="inactive">
							<a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Created Election</a>
						   </li>
                           <li class="inactive">
                            <a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Joined Election<i style="margin-left:5px;"class="fa fa-caret-down"></i></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a class="active2"href="viewcontestant.php">View Contestants</a>
                                </li>
                                <li>
                                    <a class="active active2" href="#">Register As A Candidate</a>
                                </li>
                                <li>
                                    <a class="active2"href="viewprofile.php">View Profile</a>
                                </li>
                                <li>
                                    <a class="active2"href="#">Vote</a>
                                </li>
                            </ul>
                             <!-- /.nav-third-level -->
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
    </div>
    </nav>


    <div id="page-wrapper">

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->
    <!-- edit form column -->
    <div class="col-md-8 col-md-offset-2 col-sm-6 col-xs-12 personal-info">
      
      <h3 style="padding-left:55px;border-bottom:1px solid">Information</h3><br>
      <form enctype="multipart/form-data"class="form-horizontal" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
        <div class="form-group"><span class="error"><?php echo $registration_message; ?></span>
          <label class="col-lg-3 control-label">first name:</label>
          <div class="col-md-8">
            <input class="form-control" type="text" value="<?php echo $contestant_fname;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">last name:</label>
          <div class="col-md-8">
            <input class="form-control" type="text" value="<?php echo $contestant_lname; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Email:</label>
          <div class="col-lg-8">
            <input class="form-control" type="email" placeholder="Email address" value="<?php echo $myemail; ?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label>
          <div class="col-md-8">
            <input class="form-control" type="text" name="" value="<?php echo $contestant_username; ?>">
          </div>
        </div>
          <div class="form-group">
              <label class="col-md-3 control-label">Nickname:</label>
              <div class="col-md-8">
                  <input class="form-control" type="text" name="nick_name" value="<?php echo $nick_name; ?>"><span class="error"> <?php echo $nick_nameErr; ?></span>
              </div>
          </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Post:</label>
          <div class="col-md-8">
                <?php echo $postString;?>
              <span class="error"><?php echo $contestant_postErr; ?></span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Pin:</label>
          <div class="col-md-8">
            <input class="form-control" type="text" name="contestant_pin" value="<?php echo $contestant_pin_temp; ?>"><span class="error"> <?php echo $contestant_pinErr; ?></span><span class="error"> <?php echo $errors; ?></span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Manifesto:</label>
          <div class="col-md-8">
            <input class="form-control" type="number" id="no_of_points" name="manifesto_points" value="<?php echo $no_manifesto_points; ?>" oninput="myfunction2()" min="1" max="10" placeholder="No of manifesto_points" ><span class="error"> <?php echo $no_manifesto_pointsErr; ?></span>
          </div>
        </div>
          <div class="form-group">
              <div class="col-md-1 col-md-offset-2 " id="dem1">

              </div>
              <div class="col-md-8" id="dem">

              </div>
          </div>
          <div class="form-group" style="margin-top:50px;margin-left:-3px">
            <label class="col-md-3 control-label">Picture: </label>
                <div class="col-md-9">
                    <input type="file" name="image" class="btn btn-default">
                        <p class="help-block">
                        Pls ensure the file being uploaded is clear picture of yourself.<br><span class="error"> <?php echo $uploadErr; ?></span>
                            <span class="error"> <?php echo $success; ?></span>
                        </p>
                </div>
         </div>
          <div class="form-group" style="margin-top:30px;margin-left:-3px">
            <label class="col-md-3 control-label">Citation: </label>
                <div class="col-md-9">
                    <input type="file" name="citation" class="btn btn-default">
                        <p class="help-block">
                        Pls ensure the file being uploaded is a text file.<br>
                            <span class="error"> <?php echo $uploadCitationErr; ?></span><span class="error"> <?php echo $successC; ?></span>
                        </p>
                </div>
         </div>
    </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input class="btn btn-primary" value="Save" name="submit" type="submit">
            <span></span>
            <input class="btn btn-default" value="Cancel" type="reset">
          </div>
        </div>
      </form>
    </div>
  </div>
<!--    wrapper-->


<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script src="../js/contestant.js"></script>

</body>

</html>

