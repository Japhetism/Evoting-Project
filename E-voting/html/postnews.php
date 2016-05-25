<?php
include('../php/session.php');
include_once('../php/post_news.php');
include_once('../php/session.php');

    //open connection
    include_once('../php/connection.php');
    //get election key
    $key=$_GET['key'];
    $election_idd = substr($key,9,strlen($key)-17);
    //check if key is valid
    $election_id_check_query="SELECT * FROM election WHERE election_id='$election_idd'";
    $election_id_check= mysqli_query($connection2,$election_id_check_query);
    $election_details= mysqli_fetch_row($election_id_check);
    //redirect if election is not present
    if(count($election_details)===0){
        header("Location:maindashboard.php");
    }else{
        $election_id=$election_details[0];
        //check if the user is truly the admin of the election using the session email and the election id
        //get user_id from email
        $user_id_query="SELECT user_id FROM users WHERE email='$myemail'";
        $user_id =mysqli_query($connection2,$user_id_query);
        $user_id=mysqli_fetch_row($user_id);
        //check if user is the admin
        $is_user_admin_query="SELECT * FROM election WHERE user_id='$user_id[0]' AND election_id='$election_id'";
        $is_user_admin= mysqli_query($connection2,$is_user_admin_query);
        $is_user_admin=mysqli_fetch_row($is_user_admin);
        if(count($is_user_admin)===0){
            header("Location:maindashboard.php");
        }else{
            $date_diff=-strtotime(date("Y-m-d"))+strtotime(date($is_user_admin[2]));
            $_SESSION['election_id'] = $key;
        }
        //user is now the admin of this election.
    }
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <script type="text/javascript">
        function news(id){
            window.location = "editnews.php?under=" +id;
        }
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
			<ul class="nav navbar-nav side-nav sidebar">
				<h4><span class="fa fa-th-large"></span> Dashboard</h4>
				<li>
					<a href="maindashboard.php" style="font-weight:bolder;"><i class="fa fa-fw fa-th"></i>My Elections<i style="margin-left:50px;"class="fa fa-caret-down"></i></a>
					<ul class="nav nav-second-level">
						<li class="inactive">
							<a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Created Election<i style="margin-left:5px;"class="fa fa-caret-down"></i></a>
							<ul class="nav nav-third-level">
								<li>
									<a class="active active2" href="#">Post News</a>
								</li>
								<li>
									<a class="active2"href="updateelectiondetails.php">Update Election</a>
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
				<li >
					<a class="inactive" href="#"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
				</li>
				<li>
					<a class="inactive" href="#"><i class="fa fa-fw fa-plus-square"></i>Join an Election</a>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
    </nav>
	
	
    <div id="page-wrapper">

    <div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
           <div class="row">
                    <div class="col-md-12">
                        <h3>Post News</h3>
                    </div>
           </div>
            <form method="post">
                <div class="row">
                    <div class="col-md-11">
                        <textarea rows="4" name="post_news" style="max-width: 100%;min-width: 100%;max-height: 80px"></textarea>
                    </div>
                    <div class="col-md-11">
                        <input type="submit" value="POST" name="post_submit">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12 news" style="margin-top: 50px;font-size:20px;">
                    <p><?php echo $posted_news;?></p>
                </div>
            </div>

        </div>

                    <?php
                    //lets get pending requests but we must check if election has not concluded
                    $sender_id_query ="SELECT user_id FROM request WHERE election_id='$election_id'";
                    $sender_highdee =mysqli_query($connection2,$sender_id_query);
                    $sender_id =mysqli_fetch_row($sender_highdee)[0];
                    if($sender_id!=''){
                        $request_string='<div class="col-md-4">
                                       <h3 style="text-align: center">Pending Requests<br>
                                       <h5 style="margin-left: 20%">You can only accept or reject request before the start of the election.</h5></h3>
                                        <ul style="display: inline-block;list-style:none;">';
                        do{
                            //get email of current sender and display it
                            $sender_email_query="SELECT email FROM users WHERE user_id='$sender_id'";
                            $sender_email= mysqli_query($connection2,$sender_email_query);
                            $sender_email = mysqli_fetch_row($sender_email)[0];
                            $specification=$sender_id.'_'.$election_id;
                            $request_string.='<li>
							                    <ul  style="display: inline-block;list-style:none;"	>
								                    <li  style="display: inline-block;" class=';
                            $request_string.=$specification;
                            $request_string.='>';
							$request_string.=           $sender_email;
							$request_string.=       '</li>
								                    <li id=';
                            $request_string.=$date_diff;
                            $request_string.=' style="display: inline-block;" class=';

                            $request_string.=$specification;
                            $request_string.='>
                                                <span style="margin-left: 15px;" class="fa fa-check text-success acceptInvite"></span>
                                                <span  style="margin-left: 15px;" class="fa fa-close text-danger rejectInvite"></span>

								                    </li>
							                    </ul>
					                        </li>' ;


                        }while($sender_id =mysqli_fetch_row($sender_highdee)[0]);
                        $request_string.=' </ul>
                                         </div>';
                        print $request_string;
                    }
                    ?>


    </div>
 </div>
</div>
<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/request.js"></script>

</body>

</html>

