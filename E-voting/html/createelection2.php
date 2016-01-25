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
            <!-- Page Heading -->
            <div class="row">

            </div>
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
                                    <fieldset>
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
                                            <div class="form-group">
                                                <label>Name of Election</label>
                                                <input type="text" class="form-control" id="election_name" name="name_of_election" value ="<?php echo $name_of_election; ?>" placeholder="Name of Election" >
												<span class="error"><?php echo $name_of_electionErr; ?></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label>Start Date of Election</label>
                                                <input type="date" class="form-control" id="start_election_date" name="start_date_of_election" value="<?php echo $start_date_of_election; ?>" placeholder="YYYY-MM-DD" >
												<span class="error"><?php echo $start_date_of_electionErr; ?></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label>Start Time of Election</label>
                                                <input type="time" class="form-control" id="election_start_time" name="time_of_election_from" value="<?php echo $time_of_election_from; ?>" placeholder="HH-MM" >
												<span class="error"><?php echo $time_of_election_fromErr; ?></span>
                                            </div><br>
                                             <div class="form-group">
                                                <label>End Date of Election</label>
                                                <input type="date" class="form-control" id="end_election_date" name="end_date_of_election" value="<?php echo $end_date_of_election; ?>" placeholder="YYYY-MM-DD" >
												<span class="error"><?php echo $end_date_of_electionErr; ?></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label>End Time of Election</label>
                                                <input type="time" class="form-control" id="election_end_time" name="time_of_election_to" value="<?php echo $time_of_election_to; ?>" placeholder="HH-MM" >
												<span class="error"><?php echo $time_of_election_toErr; ?></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label>Number of Posts</label>
                                                <input type="number"  id="number_of_posts" name="number_of_posts" class="form-control" oninput="myfunction();" min="1" max="20" placeholder="No of Posts" >
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-6"><div id="dem"></div></div>
                                                <div class="col-lg-6"><div id="dem1"></div></div>
                                            </div>
                                            <div class="form-group" style="text-align: center">
                                                <label>CSV File Input</label>
                                                <input type="file" id="" name="election_csv">
                                            </div><br>
                                            <div class="checkbox">
                                                <label>

                                                </label>
                                            </div>
                                            <input type="submit" class="btn btn-success" name="submit" value="Submit">
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
<script src="../js/jquery.js"></script>

<!-- custom js-->
<script src="../js/file.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>