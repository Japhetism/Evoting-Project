<?php
//include('../php/session.php');
//open connection
include('../php/connection.php');
session_start();

if(isset($_SESSION['login_user'])){
    $myemail = $_SESSION['login_user'];
}
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
                <!-- Page Heading -->

                <!-- /.row -->
                <div class="row elections1">
					<div class="col-md-10 col-md-offset-1 ">
						<div class="col-md-12 electheading">
							<ol class="breadcrumb">
								<li class="active">
									Created Elections
								</li>
							</ol>
						</div>
						<div class="col-md-12 electlist">
							<div class="row">
							<div class="col-md-11 col-md-offset-1 ">
							<?php
                            $get_id = "SELECT user_id FROM users WHERE email='$myemail'";
                            $user_id =  mysqli_fetch_row(mysqli_query($connection2,$get_id));
                            $admin_query= "SELECT * FROM election WHERE user_id='$user_id[0]'";
                            $admin= mysqli_query($connection2,$admin_query);
                            $add=mysqli_fetch_row($admin);
                            $elections_displayed="";

                            if($add){
                                $elections_displayed.="<table >
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Pin</th>
														<th></th>
                                                    </tr>";
                                do {
                                    $elections_displayed.="<tr>";
                                    for($i=1;$i<=6;$i++)
                                    {
                                        $elections_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>$add[$i]</td>";
                                    }
                                    $elections_displayed.="<td><a href='postnews.php'>Edit</a></td>";
                                    $elections_displayed.="</tr>";

                                }  while($add=mysqli_fetch_row($admin));

                                $elections_displayed.=   "</table>";
                            }else{
                                $elections_displayed.="You are yet to create an election";
                            }
                            print $elections_displayed;
                            ?>

						</div>
						</div>
						</div>
					</div>
					<div class="col-md-10 col-md-offset-1 ">
						<div class="col-md-12 electheading">
							<ol class="breadcrumb">
								<li class="active">
									Joined Elections
								</li>
							</ol>
						</div>
						<div class="col-md-12 electlist">
							<div class="row">
							<div class="col-md-10 col-md-offset-2 ">
							<?php
                            $joined_displayed='';
                            $election_id_query= "SELECT election_id FROM joined WHERE user_id='$user_id[0]'";
                            $election_id=mysqli_query($connection2,$election_id_query)or print('election_id problem');
                            $election_id_value= mysqli_fetch_row($election_id);
                            if($election_id_value){
                                $joined_displayed.="<table>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Date</th>
                                                        <th>Admin</th>
                                                        <th></th>
                                                    </tr>";
                                do{
                                    $election_details_query="SELECT * FROM election WHERE election_id='$election_id_value[0]'";
                                    $detail= mysqli_query($connection2,$election_details_query);
                                    $details=mysqli_fetch_row($detail);
                                    $joined_displayed.="<tr>";
                                    for($i=1;$i<=2;$i++)
                                    {
                                        $joined_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>$details[$i]</td>";
                                    }
                                    $get_admin_query="SELECT * FROM users WHERE user_id='$details[8]'";
                                    $get_admin=mysqli_query($connection2,$get_admin_query);
                                    $admin_details= mysqli_fetch_row($get_admin);
                                    $joined_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>$admin_details[4]</td>";
                                    $joined_displayed.="<td><a href='viewcontestant.php'>View</a></td>";
                                    $joined_displayed.="</tr>";
                                }while($election_id_value=mysqli_fetch_row($election_id));
                                $joined_displayed.="</table>";

                            }else{
                                $joined_displayed.='You have not joined any election';
                            }

                            print $joined_displayed;

                            ?>
						</div>
						</div>
						</div>
					</div>
                </div>
            </div>

        </div>
    </div>
<!--    wrapper-->


    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
	
    <!-- Custom JavaScript -->
    <script src="../js/file.js"></script>

</body>

</html>

