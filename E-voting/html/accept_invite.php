<?php
include_once('../php/accept_reject_invite.php');

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
<style type="text/css">
    #displayedPhoto{
        width: 30%;
        height: 30%;
    }
</style>
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


    <div id="page-wrapper">
        <!-- /#page-wrapper -->
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3> class="modal-title" id="myModalLabel" style="color:black;border:none;">Enter the election pin</h3>
                    </div>
                    <form  onsubmit="joinSuccess()">
                        <div class="modal-body row" id="input" style="text-align:center;" >
                            <div class=" col-md-4 col-md-offset-4 " >
                                <input type="text" name="pin" class=" form-control" style="background: rgba(0,0,0,0.1);text-align:center;" placeholder="PIN">
                            </div>
                        </div>
                        <div class="modal-footer" id="input2">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Join">
                        </div>
                    </form>
                </div>
            </div>
        </div>
<div class="container-fluid">
   <br><br>
    <div class="row">
        <div class="col-md-offset-1 col-md-8">
            <h3 style="font-size: xx-large">Election Details</h3><br>
        </div>
    </div>
     <div class="row">
            <label style="font-size: x-large" class="col-md-offset-1 col-md-3">Election Pin</label>
            <div class="col-md-6">
               <p style="font-size: xx-large; font-weight: bolder"><?php print $election_details[6];?></p>
            </div>
        </div><br>
        <div class="row">
            <label style="font-size: x-large" class="col-md-offset-1 col-md-3">Election Name</label>
            <div class="col-md-8">
                <p style="font-size: xx-large; font-weight: bolder"><?php print $election_details[1];?></p>
            </div>
        </div><br><br>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
            <h3 style="font-size: xx-large">Admin Details</h3><br><br>
            </div>
        </div>
            <div class="row">
            <label style="font-size: x-large" class="col-md-offset-1 col-md-3">Name</label>
            <div class="col-md-8">
               <p style="font-size: x-large; font-weight: bolder"><?php print $admin_details[1].'  '.$admin_details[2]?></p>
            </div>
        </div><br>
        <div class="row">
            <label style="font-size: x-large" class="col-md-offset-1 col-md-3">Email ID</label>
            <div class="col-md-8">
                <p style="font-size: x-large; font-weight: bolder"><?php print $admin_details[4]?></p>
            </div>
        </div><br><br>
        <div class="row">
            <label style="font-size: x-large" class="col-md-offset-1 col-md-3">Phone Number</label>
            <div class="col-md-8">
                <p style="font-size: xx-large; font-weight: bolder"><?php print $admin_details[5]?></p>
            </div>
        </div><br><br>
        <div class="row">
            <label style="font-size: x-large" class="col-md-offset-1 col-md-3">Gender</label>
            <div class="col-md-8">
                <p style="font-size: x-large; font-weight: bolder"><?php print $admin_details[7];?></p>
            </div>
            <p><?php echo $election_admin_detail?></p>
        </div><br><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="col-md-offset-4 form-inline">
            <input class="btn btn-default" type="submit" name="accept" value="Accept">
            <input class="btn btn-default col-md-offset-1" type="submit" name="decline" value="Decline">
            </div>
        </form>
    </div>
        </div>
    </div>
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script src="../js/file.js"></script>

</body>

</html>