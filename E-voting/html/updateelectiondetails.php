<?php
include_once('../php/updateelection.php')
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <style>
        select{
            width: 100%;
            padding: 5px 0px 5px 0px;
            background: rgba(0,0,0,0.1);
            border:none;
            border-radius:3px;
        }
        select:focus{
            background: rgba(0,0,0,0.8);
            color:white;
        }
        select:active{
            background: white;
            color:black;
        }
        option{
            color: black;
        }
        #elect_time{
            padding-left:0;
        }
        .form-group{
            width:100%;
            margin:0;
        }
    </style>

    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script>
        $(function() {
            $( ".datePicker" ).datepicker();
        });
    </script>

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
                        <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav side-nav sidebar">
                <h4><span class="fa fa-th-large"></span> Dashboard</h4>
                <li>
                    <a href="maindashboard.php" style="font-weight:bolder;"><i class="fa fa-fw fa-th"></i>My Elections<i style="margin-left:50px;"class="fa fa-caret-down"></i></a>
                    <ul class="nav nav-second-level">
                        <li class="inactive">
                            <a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Created Election<i style="margin-left:5px;"class="fa fa-caret-down"></i></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a class="active2" href="postnews.php">Post News</a>
                                </li>
                                <li>
                                    <a class="active active2"href="#">Update Election</a>
                                </li>
                                <li>
                                    <a class="active2"href="editparticipant.php">Edit Participants</a>
                                </li>
                                <li>
                                    <a class="active2"href="#">View Results</a>
                                </li>
                            </ul>
                            <!-- /.nav-third-level -->
                        </li>
                            <li class="inactive">
							<a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Joined Election</a>
						   </li>
				</ul>
                    <!-- /.nav-second-level -->
                </li>
            <li>
                <a href="createelection1.php" data-toggle="collapse" data-target="#steps"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
                <ul id="steps" class="collapse">
                    <li>
                        <a href="#">Step 1<i class="fa fa-spinner fa-spin"></i></a>
                    </li>
                    <li>
                        <a href="#">Step 2</a>
                    </li>
                    <li>
                        <a href="#">Step 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-plus-square"></i>Join an Election</a>
            </li>
        </ul>
        <!-- /.navbar-collapse -->
        </div>
    </nav>


    <div id="page-wrapper">

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">

            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="electoralform">
                        <fieldset class="dash">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <p style="border-bottom: solid 2px #265a88"><label>Please fill in appropriately, details of the election you want to
                                            edit in the fields provided below.</label></p>
                                    Note:None of the date and time should be left unfilled once at least one of them is<br> &nbsp;  &nbsp; &nbsp; changed.
                                      Previous values are automatically discarded once this form is submitted.<br><br>
                                    <span class="error"><?php echo $message; ?></span>
                                </div>
                                <div class="col-lg-8 col-lg-offset-2 form">
                                    <fieldset>
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="form-group">
                                                <label>Name of Election</label>
                                                <input type="text" class="form-control" id="election_name" name="name_of_election" value ="<?php echo $this_election['election_name']; ?>" placeholder="Name of Election" >
												<span class="error"><?php echo $name_of_electionErr; ?></span>
											</div>
                                            <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Start Date of Election</label><br>
												<div class=""><?php echo dateString($this_election['election_start_date'])?><br>
                                                    <input type="text" class="datePicker"  id="datePicker1" name="start_date"  style="display: none;" >
                                                </div>
                                                <span class="error"><?php echo $start_date_of_electionErr; ?></span>
                                            </div>
                                                <div class="form-group col-md-6">
                                                    <label>Start Time of Election</label>
                                                    <div class="">
                                                        <?php echo timeString($this_election['election_time_from'])?>
                                                    </div>
                                                    <div id="timeStart" style="display: none">
                                                        <div class="col-md-6" id="elect_time">
                                                            <?php
                                                            $print_hour="<select name='start_hour'>";
                                                            $print_hour.="<option value=''>HH</option>";
                                                            for($hour=0;$hour<10;$hour++){
                                                                $hour_display="0".$hour;
                                                                $print_hour.="<option value='$hour'>$hour_display</option>";
                                                            }
                                                            for($hour=10;$hour<24;$hour++){
                                                                $print_hour.="<option value='$hour'>$hour</option>";
                                                            }
                                                            $print_hour.="</select>";
                                                            print $print_hour;
                                                            ?>
                                                        </div>
                                                        <div class="col-md-1" id="elect_time">:</div>
                                                        <div class="col-md-6" id="elect_time">
                                                            <?php
                                                            $print_minute="<select name='start_minute'>";
                                                            $print_minute.="<option value=''>MM</option>";
                                                            for($minute=0;$minute<10;$minute++){
                                                                $minute_display="0".$minute;
                                                                $print_minute.="<option value='$minute'>$minute_display</option>";
                                                            }
                                                            for($minute=10;$minute<60;$minute++){
                                                                $print_minute.="<option value='$minute'>$minute</option>";
                                                            }
                                                            $print_minute.="</select>";
                                                            print $print_minute;
                                                            ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                    <span class="error"><?php echo $time_of_election_fromErr; ?></span>
                                                </div><br>

                                            <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>End Date of Election</label><br>
                                                <div class=""><?php echo dateString($this_election['election_end_date'])?><br>
                                                        <input type="text" class="datePicker" id="datePicker2" name="end_date" style="display: none;">
                                                </div>
                                                <span class="error"><?php echo $end_date_of_electionErr; ?></span><br>
                                                <button type="button" id="dateButton" onclick="displayContent()">Change Date/Time</button>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>End Time of Election</label>
                                                <div class="">
                                                    <?php echo timeString($this_election['election_time_to'])?>
                                                </div>
                                                <div id="timeEnd" style="display: none">
                                                    <div class="col-md-5" id="elect_time">
                                                        <?php
                                                        $print_hour="<select name='end_hour'>";
                                                        $print_hour.="<option value=''>HH</option>";
                                                        for($hour=0;$hour<10;$hour++){
                                                            $hour_display="0".$hour;
                                                            $print_hour.="<option value='$hour'>$hour_display</option>";
                                                        }
                                                        for($hour=10;$hour<24;$hour++){
                                                            $print_hour.="<option value='$hour'>$hour</option>";
                                                        }
                                                        $print_hour.="</select>";
                                                        print $print_hour;
                                                        ?>
                                                    </div>
                                                    <div class="col-md-1" id="elect_time">:</div>
                                                    <div class="col-md-5" id="elect_time">
                                                        <?php
                                                        $print_minute="<select name='end_minute'>";
                                                        $print_minute.="<option value=''>MM</option>";
                                                        for($minute=0;$minute<10;$minute++){
                                                            $minute_display="0".$minute;
                                                            $print_minute.="<option value='$minute'>$minute_display</option>";
                                                        }
                                                        for($minute=10;$minute<60;$minute++){
                                                            $print_minute.="<option value='$minute'>$minute</option>";
                                                        }
                                                        $print_minute.="</select>";
                                                        print $print_minute;
                                                        ?>
                                                    </div>

                                                <span class="error"><?php echo $time_of_election_toErr; ?></span>
                                            </div><br>
                                            </div>
                                            </div><br>
                                            <div id="editPosts" >
												<div class="row">
                                                    <?php echo $post_string; echo $pin_string;?>
												</div>
											</div><br>
                                                <div class="form-group">
                                                <label>Do you want to add new posts?</label>
                                                <input type="radio" onchange="displayPosts('addPosts')" name="newPost"/>Yes
                                                <input type="radio" onchange="displayPosts('addPosts')" name="newPost" />No
                                            </div><br>
                                            <span class="error"><?php echo $new_post_Err; ?></span>
                                            <div id="addPosts" style="display:none;">
												<div class="form-group" >
													<label>Number of Posts</label>
													<input type="number"  id="number_of_posts"  value="" name="number_of_new_posts" class="form-control" oninput="myfunction();" min="1" max="20" placeholder="No of Posts" >
												</div><br>
												<div class="row">
													<div class="col-lg-6"><div id="dem"></div></div>
												<div class="col-lg-6"><div id="dem1"></div></div>
												</div>
                                            </div>
                                            <div class="form-group" >
                                                <label>Election Privacy</label>
                                                <select name="privacy">
                                                    <option value="">Change Privacy</option>
                                                    <option value="public">Public</option>
                                                    <option value="private">Private</option>
                                                </select>
                                                <span class="error"><?php echo $privacyErr; ?></span>
                                            </div><br>
                                            <input type="submit" class="btn btn-success" name="update" value="submit">
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--    wrapper-->


<!-- jQuery -->
<!--<script src="../js/jquery.js"></script>-->

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script src="../js/file.js"></script>
<script src="../js/updateelection.js"></script>

</body>

</html>

