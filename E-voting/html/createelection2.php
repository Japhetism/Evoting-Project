<?php
include('../php/createelection.php');
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
            <li >
                <a href="maindashboard.php" data-toggle="collapse" data-target="#accounts"><i class="fa fa-fw fa-th"></i>My Elections<i class="fa fa-fw fa-caret-right"></i></a>
                <ul id="accounts" class="collapse">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-edit"></i>Manage Created Election</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-edit"></i>Manage Joined Election</a>
                    </li>
                </ul>
            </li>
            <li class="active">
                <a href="#" data-toggle="" data-target="#steps"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
                <ul id="steps" class="collapse" style="display: block">
                    <li class="active">
                        <a class="inactive" href="createelection1.php">Step 1<i class="fa fa-check"> </i></a>
                    </li>
                    <li>
                        <a class="active" href="#">Step 2<i class="fa fa-spinner fa-spin"> </i></a>
                    </li>
                    <li>
                        <a class="inactive" href="#">Step 3</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>


<div id="page-wrapper">

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
<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
<div class="row form-group">
    <label>Name of Election</label>
    <input type="text" class="form-control" id="election_name" name="name_of_election" value ="<?php echo $name_of_election; ?>" placeholder="Name of Election" >
    <span class="error"><?php echo $name_of_electionErr; ?></span>
</div><br>
<div class="row">
<div class="col-md-7">
    <div class="form-group">
        <label>
            Start Date of Election
        </label>

        <div class="row">
            <input type="text" class="datePicker" name="start_date"  value="<?php echo $dummy1;?>">
        </div>
       <span class="error"><?php echo $start_date_of_electionErr; ?></span>
    </div><br><br>
    <div class="form-group">
        <label>
            End Date of Election
        </label>
        <div class="row">
            <input type="text" class="datePicker" name="end_date"  value="<?php echo $dummy2;?>">
 </div>
    <span class="error"><?php echo $end_date_of_electionErr; ?></span>
    </div>
</div>
<div class=" col-md-4 col-md-offset-1">
    <div class="form-group">
        <div class="row">
            <label>
                Start Time of Election
            </label>
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
       <span class="error"><?php echo $time_of_election_fromErr; ?></span>
    </div><br><br>
    <div class="form-group">
        <div class="row">
            <label>
                End Time of Election
            </label>
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
             </div>
        <span class="error"><?php echo $time_of_election_toErr; ?></span>
    </div><br>
</div>
</div>
<div class="form-group">
    <label>Number of Posts</label>
    <input type="number"  id="number_of_posts" name="number_of_posts" class="form-control" oninput="myfunction();" min="1" max="20" placeholder="No of Posts" >
</div><br>
<div class="row">
    <div class="col-lg-6"><div id="dem"></div></div>
    <div class="col-lg-6"><div id="dem1"></div></div>
</div>
    <div class="form-group" >
        <label>Election Privacy</label>
        <select name="privacy">
            <option value="">Privacy</option>
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
        <span class="error"><?php echo $privacyErr; ?></span>
    </div><br>
<div class="form-group" style="text-align: center">
    <label>CSV File Input</label>
    <input type="file" id="" name="election_csv">
</div><br>
    <?php echo $upload_photo;?>
    <span class="error"> <?php echo $uploadErr; ?></span>
    <span class="error"> <?php echo $success; ?></span>
<div class="checkbox">
    <label>

    </label>
</div>
<input type="submit" class="btn btn-success" name="submit" value="Submit">
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
<!--    wrapper-->


<!-- jQuery -->
<!--<script src="../js/jquery.js"></script>-->

<!-- custom js-->
<script src="../js/file.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>