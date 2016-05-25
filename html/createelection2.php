<?php
include_once('../php/createelection.php');
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

    <title>E-voting | Create Election</title>

   
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style>
        select{
            padding: 5px 0px 5px 0px;
            background: #fff;
            border:solid 1px #ccc;
            border-radius:3px;
            color: #888;
            margin-top:1px;
            height: 34px;
        }
        select:focus{
            background: #fff;
            color:#555;
        }
        select:active{
            background: white;
            color:#555;
        }
        option{
            color: #666;
        }
        .form-group{
            width:100%;
            margin:0;
        }
    </style>

    <link rel="stylesheet" href="../css/jquery-ui.css">
    <link href="../css/timepicki.css" rel="stylesheet">

    <script src="../js/jquery.js"></script>

    <script src="../js/jquery-ui.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>


    <![endif]-->
</head>
<body
    <?php if(isset($_POST["submit"])){
        echo ('onload=genFields('.json_encode(post_pin()).')') ;
    }?>
    >
    <div id="wrapper" style="overflow-x: hidden;">

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
                            <img src="<?php echo $photo_fetched;?>" width="30px" height="30px" >
                        </i>
                            <?php echo $myemail;?>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu userOptions" id="userOptions">
                        <li>
                            <a href="viewuserprofile.php"><i class="fa fa-user"></i> View Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../php/logout.php"><i class="fa fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav side-nav sidebar" id="MainMenu">
                    <li class="col-md-12 ">
                        <div class="row userProfile" id="userActions">
                            <div class="col-md-12 userActions">
                                <img src="<?php echo $photo_fetched;?>" alt="???" width="100px" height="100px" style="border-radius:100%;"><br><br>
                                <b><?php echo $fullname;?></b><br>
                                <strong>User</strong>
                            </div>
                        </div>
                    </li>
                    <!-- link to dashboard -->
                    <li class="active">
                            <a href="maindashboard.php" class="active"><i class="fa fa-dashboard"></i>
                            Dashboard</a>
                    </li>
                    
                    <li class="active">
                        <a data-target="#" class="inactive" data-toggle="collapse" data-parent="#MainMenu">
                            <i class="fa fa-pencil-square-o"></i>
                                Manage Elections
                            <i class="fa fa-angle-left pull-right" style="width:10px;"></i>
                        </a>
                        <ul class="collapse" id="demo3">   
                            <li id="demo3_1" >    
                                <a href="#" class="inactive" > Public Elections<i class="btn pull-right success" >1 </i></a>
                            </li>
                            <li class="active1" id="demo3_2" target="table_2" >
                                <a class="active" data-toggle="collapse" data-target="#SubMenu">
                                    Created Elections<i class="btn pull-right primary" >2</i>
                                </a>
                                <ul class="nav collapse" id="SubMenu">
                                    <li class="active1">
                                        <a href="#" class="active" data-parent="#SubMenu1">
                                        Election Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="updateelectiondetails.php" class="active" data-parent="#SubMenu1">Update Election</a>
                                    </li>
                                    <li>
                                        <a href="editparticipant.php" class="active">Edit Participants</a>
                                    </li>
                                    <li>
                                        <a href="#" class="active" data-parent="#SubMenu1">View Results</a>
                                    </li>
                                </ul>
                            </li>   
                            <li target="table_3" id="demo3_3" >    
                                <a href="#" data-target="#" data-toggle="collapse" class="inactive" > Joined Elections<i class="btn pull-right warning" >3</i></a>
                                <ul class="nav collapse" id="SubMenu1">
                                    <li>
                                        <a href="#" class="inactive" data-parent="#SubMenu1">
                                        Election Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="inactive" data-parent="#SubMenu1">Register as a Contestant</a>
                                    </li>
                                    <li>
                                        <a href="#" class="inactive">View Profile(contestants Only)</a>
                                    </li>
                                    <li>
                                        <a href="#" class="inactive" data-parent="#SubMenu1">Vote</a>
                                    </li>
                                </ul>
                            </li>   
                            <li target="table_4" id="demo3_4" >    
                                <a href="#" class="inactive" > Pending Invites<i class="btn pull-right danger" >4</i></a>
                            </li>   
                            <li target="table_5" id="demo3_5" >    
                                <a href="#" class="inactive" > Pending Requests<i class="btn pull-right default" >5</i></a>
                            </li>
                        </ul>
                    </li>
                        
                    <li class="active" >
                        <a href="#" data-target="#demo4" class="active" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus"></i>Create an Election<i class="fa fa-angle-left pull-right" ></i></a>
                            <ul class="open collapse in" id="demo4">
                                <li>
                                    <a href="createelection1.php" class="active">Step 1<i class="fa fa-check-circle-o fa-lg text-success pull-right" ></i></a>
                                </li>
                                <li>
                                    <a href="#" class="active">Step 2<i class="fa fa-spinner fa-spin pull-right" ></i></a>
                                </li>
                                <li>
                                    <a href="#" class="inactive">Step 3<i class="fa fa-check-circle pull-right" ></i></a>
                                </li>
                            </ul>
                    </li>
                    <li class="active">
                        <a href="#" class="inactive" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-user-plus"></i>Join an election
                        </a>
                    </li>
                        
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>


        <div id="page-wrapper">

            <!-- container header-->
            <div class="row">
                <div class="page-title col-md-12">
                    <h3>Create Election</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li><a href="#">Create Election</a></li>
                            <li><a href="createelection1.php">Step 1</a></li>
                            <li class="active">Step 2</li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->

        <!-- /#page-wrapper -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="electoralform">
                            <fieldset class="dash">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <p style="border-bottom: solid 2px #265a88"><label>Welcome to i-vote election creation page, please fill in appropriately, details of the election you want to
                                                create in the fields provided below.</label></p>
                                        Note: All fields are compulsory to complete the registration of your election.<br><br>
                                    </div>

                                    <div class="col-lg-8 col-lg-offset-2 form">
                                        <?php
                                            if(!empty($errors)) {
                                                echo '<div class="errors" style="color: red;">';
                                                foreach($errors as $error) {
                                                    echo '<p>' . $error . '</p>';
                                                }
                                                echo '</div>';
                                            }
                                            if(!empty($message)){
                                                echo '<span class="error">'.$message.'</span>';
                                            }else{
                                                echo '<span class="error">'.$message2.'</span>';
                                            }
                                        ?>
                                        <form enctype="multipart/form-data" id="thatForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label>Name of Election</label>
                                                    <input type="text" class="form-control" id="election_name" name="name_of_election"
                                                           value ="<?php
                                                           if($name_of_electionErr=="")
                                                               echo($name_of_election);
                                                           else echo($dummy3);
                                                           ?>"
                                                           placeholder="Name of Election" required="">
                                                    <span class="error"><?php echo $name_of_electionErr; ?></span>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class=" row form-group">
                                                        <div class="col-md-12">
                                                            <label>
                                                                Start Date of Election
                                                            </label>
                                                            <input type="text" class="form-control datePicker" name="start_date"  value="<?php echo $dummy1;?>" required="">
                                                           <span class="error"><?php echo $start_date_of_electionErr; ?></span>
                                                        </div>
                                                    </div><br>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <label>
                                                                End Date of Election
                                                            </label>
                                                                <input type="text" class="form-control datePicker" name="end_date"  value="<?php echo $dummy2;?>" required="">
                                                            <span class="error">
                                                                <?php echo $end_date_of_electionErr; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row form-group">
                                                        <label class="col-xs-12 col-md-12">
                                                            Start Time of Election
                                                        </label>
                                                        <div class="col-xs-12 col-md-12" id="elect_time">
                                                            <!-- startime -->
                                                            <div class="inner cover indexpicker">
                                                                <div class="time_pick"><input id="timepicker1" class="form-control" type="text" name="start_time" value="<?php echo $dummy4;?>" required="">
                                                                    <div class="timepicker_wrap " style="display: none;">

                                                                        <div class="time">
                                                                            <div class="prev action-prev"></div>
                                                                            <div class="ti_tx">
                                                                                <input type="text" class="timepicki-input">
                                                                            </div>
                                                                            <div class="next action-next"></div>
                                                                        </div>

                                                                        <div class="mins">
                                                                            <div class="prev action-prev"></div>
                                                                            <div class="mi_tx">
                                                                                <input type="text" class="timepicki-input">
                                                                            </div>
                                                                            <div class="next action-next"></div>
                                                                        </div>

                                                                        <div class="meridian">
                                                                            <div class="prev action-prev"></div>
                                                                            <div class="mer_tx">
                                                                                <input type="text" class="timepicki-input" readonly="" >
                                                                            </div>
                                                                            <div class="next action-next"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       <span class="col-xs-7 col-md-12 error"><?php echo $time_of_election_fromErr; ?></span>
                                                    </div><br>
                                                    <div class="row form-group">
                                                        <label class="col-xs-12 col-md-12">
                                                            End Time of Election
                                                        </label>
                                                        <div class="col-xs-12 col-md-12" id="elect_time">
                                                            <!-- enditime -->
                                                            <div class="inner cover indexpicker">
                                                                <div class="time_pick"><input id="timepicker2" class="form-control" type="text" name="end_time" value="<?php echo $dummy5;?>" required="">
                                                                    <div class="timepicker_wrap " style="display: none;">

                                                                        <div class="time">
                                                                            <div class="prev action-prev"></div>
                                                                            <div class="ti_tx">
                                                                                <input type="text" class="timepicki-input">
                                                                            </div>
                                                                            <div class="next action-next"></div>
                                                                        </div>

                                                                        <div class="mins">
                                                                            <div class="prev action-prev"></div>
                                                                            <div class="mi_tx">
                                                                                <input type="text" class="timepicki-input">
                                                                            </div>
                                                                            <div class="next action-next"></div>
                                                                        </div>

                                                                        <div class="meridian">
                                                                            <div class="prev action-prev"></div>
                                                                            <div class="mer_tx">
                                                                                <input type="text" class="timepicki-input" readonly="" >
                                                                            </div>
                                                                            <div class="next action-next"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="col-xs-7 col-md-12 error">
                                                        <?php echo $time_of_election_toErr; ?>
                                                        </span>
                                                    </div><br>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-xs-12">
                                                    <label>Number of Posts</label>
                                                    <input  class=" form-control" value="<?php echo $number_of_posts ?>" type="number"  id="number_of_posts" name="number_of_posts" oninput="myfunction();" min="1" max="20" placeholder="No of Posts" required="">
                                                    <span class="error"><?php echo $number_of_postsErr?></span>
                                                </div>
                                            </div><br>
                                            <div class="row form-group">
                                                    <div class="col-xs-6"><div id="dem" ></div></div>
                                                    <div class="col-xs-5"><div id="dem1" ></div></div>
                                            </div>
                                            <div class="row form-group" >
                                                <div class="col-xs-12">
                                                    <label>Do you want your election to be visible to all users?</label> <br>
                                                    <!-- &nbsp; &nbsp; -->
                                                    <input type="radio" name="privacy" value="1" required>Yes
                                                    <input type="radio" name="privacy" value="2" required>No<br><br>
                                                    <label>Do you want to authenticate your voters before they join this election?</label><br>
                                                    <!-- &nbsp; &nbsp; -->
                                                    <input type="radio" name="openness" value="1" required>Yes
                                                    <input type="radio" name="openness" value="2" required>No<br><br>
                                                    <label>When do you want election result to be display?</label><br>
                                                     <!-- &nbsp; &nbsp; -->
                                                    <input type="radio" name="result_display" value="after" required="">After Election
                                                    <input type="radio" name="result_display" value="during" required="">During Election
                                                    <span class="error"></span>
                                                </div>
                                            </div><br>
                                            <div class="row form-group" style="text-align: center">
                                                <div class="col-xs-12">
                                                    <label>CSV File Input</label>
                                                    <div class="input-group">
                                                        <input class="form-control btn btn-default" type="file" name="election_csv" id="election_csv">
                                                        <span class="input-group-addon after clear-input" target='#election_csv' style="background: transparent;border-left: none;padding: 0">
                                                            <i class="fa fa-close"  data-toggle="tooltip"  data-title="clear field"></i>
                                                        </span>
                                                    </div>
                                                    <p class="error help-block">
                                                        <p id="sig_error1" style="display:none; color:#FF0000;">File format should be CSV.</p>
                                                        <p id="sig_error2" style="display:none; color:#FF0000;">Max file size should be 2MB.</p>
                                                    </p>
                                                </div>
                                            </div><br>
                                                <?php echo $upload_photo;?>
                                            <span class="error"> 
                                                <?php echo $uploadErr; ?>
                                            </span>
                                            <span class="error"> 
                                                <?php echo $success; ?>
                                            </span>
                                            <input type="submit" id="submitThatForm" class="btn btn-success" name="submit" value="Submit">
                                        </form>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="../js/timepicki.js"></script>
    <script>
        $('#timepicker1').timepicki();
        $('#timepicker2').timepicki();  
    </script>
<!--    wrapper-->


<!-- jQuery -->
<!--<script src="../js/jquery.js"></script>-->


<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- custom js-->
<script src="../js/file_upload.js"></script>
<script src="../js/file_upload2.js"></script>
<script src="../js/file.js"></script>

</body>
</html>