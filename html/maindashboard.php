<?php
include_once('../php/main_dashboard.php');
include_once('../php/photo.php');

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Dashboard</title>
    <!--    accept-->
    <style type="text/css">
        #displayedPhoto{
            width: 150px;
            height: 150px;
            margin-left: 40px;
            /*border-radius: 50%;*/
            border:3px solid #d9534f;

        }
        h4 {
            margin-top: 5px;
            margin-bottom: 5px;
            display:inline-block;
            *display: inline;     /* for IE7*/
            zoom:1;              /* for IE7*/
            vertical-align:middle;
            margin-left:5px
        }
        label {
            display: inline-block;
            /*width: 140px;*/
            /*text-align: right;*/
        }    </style>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../images/logo.png" rel="icon">
    <link href="../css/countdown.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!--    end-->
    <!--popup adela-->
    <link rel="stylesheet" href="../assets/style.min.css">

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <!-- Custom CSS for table-->
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">

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
        function created(id){
            window.location = "postnews.php?key="  + id ;
        }
        function joined(id){
            window.location = "election_detailsNews.php?key="  + id ;
        }
    </script>
</head>
<body>


    <div id="wrapper">
        <div class="load_cover">
            <i class="fa fa-spin fa-spinner"></i>
        </div>

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
                <a class="navbar-brand" href="#">
                    <!-- logo -->
                    <i class="fa fa-play-circle"></i>  <span class="light">E -</span> Voting
                </a>
            </div>

            <!-- Top-right Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown userActions">
                    <a href="#" class="dropdown-toggle showActions" id="showActions" data-toggle="dropdown">
                        <i>
                            <img class="img-circle" src="<?php echo $photo_fetched;?>" width="30px" height="30px" >
                        </i>
                            <?php echo $myemail;?>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu userOptions" id="userOptions">
                        <li>
                            <a href="viewuserprofile.php"><i class="fa fa-user"></i> profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../php/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="sidebar collapse navbar-collapse navbar-right navbar-main-collapse" id="sidebar">
                <ul class="nav navbar-nav side-nav sidebar" id="MainMenu">
                    <li class="col-md-12 ">
                        <div class="row userProfile" id="userActions" onclick="window.location = 'viewuserprofile.php?email=' + '<?php echo $myemail?>';">
                            <div class="col-md-12 userActions">
                                <img src="<?php echo $photo_fetched;?>" alt="???" width="100px" height="100px" style="border-radius:100%;"><br><br>
                                <b><?php echo $fullname;?></b><br>
                                <strong>User</strong>
                            </div>
                        </div>
                    </li>
                    <li class="active" id="1" >
                            <a href="maindashboard.php" class="active"><i class="fa fa-dashboard"></i>
                            Dashboard</a>
                    </li>

                    <li class="active">
                        <a data-target="#demo3" class="active" data-toggle="collapse" data-parent="#MainMenu">
                        <i class="fa fa-pencil-square-o"></i>Manage Elections<i class="fa fa-angle-left pull-right" style="width:10px;"></i></a>
                    </li>

                    <li class="active" >
                        <a href="createelection1.php" data-target="#demo4" class="active" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus"></i>Create an Election<i class="fa fa-angle-left pull-right" ></i></a>
                            <ul class="collapse" id="demo4">
                                <li>
                                    <a href="createelection1.php" class="active">Step 1<i class="fa fa-info-circle pull-right" ></i></a>
                                </li>
                                <li>
                                    <a href="#" class="inactive">Step 2<i class="fa fa-pencil-square-o pull-right" ></i></a>
                                </li>
                                <li>
                                    <a href="#" class="inactive">Step 3<i class="fa fa-check-circle pull-right" ></i></a>
                                </li>
                            </ul>
                    </li>
                    <li class="active">
                        <a href="#" class="active" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-user-plus"></i>Join an election
                        </a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>


        <div id="page-wrapper">

           <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel" style="color:black;border:none;">Enter the election pin</h3>
                    </div>

                    <form  method="POST" id="thatForm" >
                        <div class="modal-body row" id="input" style="text-align:center;" >
                          <div class=" col-md-4 col-md-offset-4 " >
                                <input type="text" name="pin" class=" form-control" style="background: rgba(0,0,0,0.1);text-align:center;" placeholder="PIN">
                                <p id="output"></p>
                          </div>
                          <div id="csvemails" style="display:none;">
                                <?php #echo "error";?>
                          </div>
                        </div>
                        <div class="modal-footer" id="input2">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Join" id="formSubmit">
                        </div>
                    </form>
                </div>
              </div>
            </div>

            <div class="container-fluid">

                <div class="row">
                    <div class="page-title col-xs-12">
                        <h3>Dashboard</h3>
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="active">Home</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="row tableLinks" style="margin-bottom:5px;padding:10px 0 10px 0;">
                    <div class="col-xs-12 col-md-3 success" target="table_1">
                       Public Election(s) <span class="btn default" > <?php echo count($fully_public); ?> </span>
                    </div>
                    <div class="col-xs-12 col-md-3 primary" target="table_2">
                        Created Election(s) <span class="btn default" > <?php echo $created_count; ?> </span>
                    </div>
                    <div class="col-xs-12 col-md-3 warning" target="table_3">
                        Joined Election(s) <span class="btn default" > <?php echo $joined_count; ?> </span>
                    </div>
                    <div class="col-xs-12 col-md-3 danger" target="table_4">
                        Election Invite(s) <span class="btn default" > <?php echo $invites_count; ?> </span>
                    </div>
                    <div class="col-xs-12 col-md-3 default" target="table_5">
                        Election request(s) <span class="btn default" > <?php echo $requests_count; ?> </span>
                    </div>
                </div>

                <div class="row tables">

                    <div class="col-xs-12 col-md-12 table_1 table-responsive"  style="display:block;">
                        <?php
                            print $public_elections_displayed;
                        ?>
                    </div>


                    <div class="col-xs-12 col-md-12 table_2 table-responsive"  style="display:none;">
                        <?php
                            print $created_displayed ;
                        ?>
                    </div>

                    <div class="col-xs-12 col-md-12 table_3 table-responsive" style="display:none;">
                        <?php
                            print $joined_displayed;
                         ?>
                    </div>

                    <div class="col-xs-12 col-md-12 table_4 table-responsive" style="display:none;">
                        <?php
                            print $invite_string;
                        ?>
                    </div>

                    <div class="col-xs-12 col-md-12 table_5 table-responsive" style="display:none;">
                        <?php
                         print $request_displayed;
                        ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div id="popup2" style="position: fixed; margin-top:20px;">
        <span class="button b-close" onclick="window.location='maindashboard.php'"><span>X</span></span>

        <div class="content"></div>
        <span class="button b-close" onclick="window.location='maindashboard.php'"><span>X</span></span>
    </div>
<!--    wrapper-->



    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>


    <!-- Custom JavaScript -->
    <script src="../js/file.js"></script>
    <!--popup adela-->
    <script src="../assets/jquery.min.js"></script>
    <!--    <script>window.jQuery || document.write('<script src="assets/jquery-1.9.1.min.js"><\/script>')</script>-->
    <script src="../assets/jquery.bpopup-0.11.0.min.js"></script>
<!--    <script src="../assets/jquery.easing.1.3.js"></script>-->
    <script src="../assets/scripting.min.js"></script>
    <!-- jQuery -->
    <script src="../js/jquery.js"></script>
    <!-- Table JavaScript -->
    <script src="../js/jQuery.dataTables.js"></script>
    <script type="text/javascript">


        var table = '<?php echo $created_adek;?>';
        if (table) {
            $('table#table_2').dataTable();
        }
        var table = '<?php echo $public_adek;?>';
        if (table) {
            $('table#table_1').dataTable();
        }
        var table = '<?php echo $joined_adek;?>';
        if (table) {
            $('table#table_3').dataTable();
        }
        var table = '<?php echo $invites_adek;?>';
        if (table) {
            $('table#table_4').dataTable();
        }
        var table = '<?php echo $requests_adek;?>';
        if (table) {
            $('table#table_5').dataTable();
        }


    </script>
</body>

</html>

