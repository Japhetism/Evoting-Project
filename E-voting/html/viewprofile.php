<?php
include('../php/view_profile.php');
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
    <script type="text/javascript">
        function kunle1(){
            var output=document.getElementById("pictureClick");
            output.innerHTML =  '<input type="file" name="image" class="btn btn-default" ><br>';
        }
    </script>
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
                                    <a class="active2" href="viewcontestant.php">View Contestants</a>
                                </li>
                                <li>
                                    <a class="active2" href="registercandidate.php">Register As A Candidate</a>
                                </li>
                                <li>
                                    <a class="active active2"href="#">View Profile (Contestants only)</a>
                                </li>
                                <li>
                                    <a class="active"href="#">Vote</a>
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
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">
                        My Profile
                    </h3>
                </div>
            </div>
    <!-- edit form column -->
    <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
      
      <h3 style="padding-left:55px;border-bottom:1px solid">Contestant Personal Information</h3><br>
      <form class="form-horizontal" enctype="multipart/form-data" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <div class="form-group"><span class="error"><?php echo $update_election_message;?></span>
          <label class="col-lg-3 control-label">first name:</label><?php echo $user_fname; ?>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">last name:</label><?php echo $user_lname;  ?>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Email:</label>
		  <?php echo $myemail; ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label><?php echo $username; ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Post:</label><?php echo $user_contestant_post; ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Nickname:</label>
            <?php
            echo '<div class="col-md-8">';

            $edit_nickname_here="\"$user_nickname_here\"";
            $id1="\"space\"";
            $edit_nick_name_nameatt = "\"nick_name\"";
            echo '<div  id="dem">';
            echo $user_nickname_here;
            echo "</div>";
            echo "<a href='#' id='nick' onclick='edit(0)' >Edit</a>";
            echo "</div>";

            ?>

        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Manifesto:</label>
            <?php
            echo '<div class="col-md-8" id="replace"><ul>';
                for($i=0;$i<$no_of_manifesto_point;$i++){
                    $id="\"dem$i\"";
                    $edit_manifestos="\"$manifestos[$i]\"";
                    $edit_manifestos_nameatt="\"manifesto$i\"";
                    print <<<HERE
                        <li id=$id> $manifestos[$i] </li>
HERE;

                }
            print <<<HERE
                       <a href="#" id="manifesto" onclick='edit($no_of_manifesto_point)'>Edit</a>
HERE;
            echo "</ul></div>";
            ?>

          </div>
          <div class="form-group" style="margin-top:50px;margin-left:-3px;">
            <label class="col-md-3 control-label">Picture: </label>
                        <p class="help-block">
                            <?php
                            echo "<img src='$user_picture_here' alt='$picture_name' width='40px' height='40px'>";
                            echo $picture_name;
                            ?><br>
                            <a href="#" onclick='kunle1()'>Change picture</a>
                            <div id="pictureClick">

                            </div>
                            Pls ensure the file being uploaded is clear picture of yourself.
                            <br><span class="error"> <?php echo $uploadErr; ?></span>
                            <span class="error"> <?php echo $success; ?></span>

                        </p>
          </div>
          <div class="form-group" style="margin-top:30px;margin-left:-3px">
            <label class="col-md-3 control-label">Citation: </label>
                        <p class="help-block">
                            <?php
                            if(!empty($user_citation_here)) {
                                echo $user_citation_here;
                            }else{
                                echo "None";
                            }
                            ?><br>
                        Pls ensure the file being uploaded is a pdf file.
                        </p>
         </div>
    </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">

<input class="btn btn-default" value="Step Down" type="submit" name="delete">
            <input class="btn btn-primary" value="Save" type="submit" name="submit">
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


<!-- jQuery -->
<script src="../js/file.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>
    <script src="../js/contestant.js"></script>

</body>

</html>

