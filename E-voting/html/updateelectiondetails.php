<?php
//include('session.php');
include('../php/createelection.php');
session_start();


if(isset($_SESSION['login_user'])){
    $myemail = $_SESSION['login_user'];
}
//
////validation and database
//
//function test_inputs($data)
//{
//    $data = trim($data);
//    $data = stripslashes($data);
//    $data = htmlspecialchars($data);
//    return $data;
//}
//
//// php function that convert date to its corresponding timestamp
//function convert_date($date){
//    $date = strtotime($date);
//    return $date;
//}
//
//
//
//function post_pin()
//{
//    $posts = array();
//    if (isset($_POST["submit"])) {
//        $number_of_posts = $_POST["number_of_posts"];
//        for ($i = 1; $i <= $number_of_posts; $i++) {
//            $currentPost = 'post' . $i;
//            $currentPin = 'pin' . $i;
//            $posts[$_POST[$currentPin]] = $_POST[$currentPost];
//        }
//    }
//    return $posts;
//    //print_r($posts);
//}
//
//function election_pins(){
//    $serverName = "localhost";
//    $userName = "root";
//    $password = "";
//    $election_pin_occur=true;
//
//    do{
//        $elect_pin = "0" . rand(01, 9) . " - " . rand(1000, 9999);
//        try {
//            $conn = new PDO("mysql:host=$serverName; dbname=eVoting", $userName, $password);
//            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            $stmt = $conn->prepare("SELECT election_pin FROM election");
//            $stmt->execute();
//            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//            $result = $stmt->fetchAll();
//            if (count($result)!=0) {
//
//                for($i=0;$i<count($result);$i++){
//                    if($result[$i]["election_pin"]!=$elect_pin){
//                        $election_pin_occur=false;
//                        return $elect_pin;
//                    }else{
//                        $election_pin_occur=true;
//                    }
//
//                }
//            }else{
//                return $elect_pin;
//            }
//
//        }catch (PDOException $e) {
//            echo "connection failed: " . $e->getMessage();
//        }
//
//    }while($election_pin_occur);
//
//}
//
//function user_id_from_session()
//{
//    $serverName = "localhost";
//    $userName = "root";
//    $password = "";
//    try {
//        $conn = new PDO("mysql:host=$serverName; dbname=eVoting", $userName, $password);
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $email = $_SESSION["login_user"];
//        $stmt = $conn->prepare("SELECT  user_id FROM users WHERE email='$email'");
//        $stmt->execute();
//        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//        $result = $stmt->fetchAll();
//        return $result[0]["user_id"];
//
//    } catch (PDOException $e) {
//        echo "connection failed: " . $e->getMessage();
//    }
//}
//
////if(isset($_POST["check_agree"])&& ($_SERVER["REQUEST_METHOD"]== "submit_dash3")) {
//$name_of_electionErr = $start_date_of_electionErr = $end_date_of_electionErr = $time_of_election_fromErr = $election_pinErr = $time_of_election_toErr = "";
//$name_of_election = $start_date_of_election =$start_date_of_election1 = $end_date_of_election =  $end_date_of_election1 = $time_of_election_from = $time_of_election_to = $election_pin = "";
//$last_election_id=0;
//$last_post_id=0;
//$now_date =convert_date(date("Y-m-d"));
////$now_time = convert_date(date("h:i"));
//
//
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    if (empty($_POST["name_of_election"])) {
//        $name_of_electionErr = "Name of election is required";
//    } else if (!preg_match("/^[a-zA-Z ]*$/", test_inputs($_POST["name_of_election"]))) {
//        $name_of_electionErr = "Only letters and white space allowed";
//    } else {
//        $name_of_election = test_inputs($_POST["name_of_election"]);
//    }
//
//    if (empty($_POST["start_date_of_election"])) {
//        $start_date_of_electionErr = "Start date of election is required";
//        //} else if (!((explode("-", $date_of_election)[0] - date('Y') >= 0) && (explode("-", $date_of_election)[1] - date('m') >= 0 || explode("-", $date_of_election)[2] - date('d') >= 0))) {
//        //$date_of_electionErr = "Date of election cannot be a time in the past specify the date in the format provided";
//    } else {
//        $start_date_of_election = test_inputs($_POST["start_date_of_election"]);
//        $start_date_of_election1 = convert_date($start_date_of_election);
//            if($now_date > $start_date_of_election1){
//                $start_date_of_electionErr = "Time is in the past";
//            }
//
//    }
//
//    if (empty($_POST["end_date_of_election"])) {
//        $end_date_of_electionErr = "End date of election is required";
//        //} else if (!((explode("-", $date_of_election)[0] - date('Y') >= 0) && (explode("-", $date_of_election)[1] - date('m') >= 0 || explode("-", $date_of_election)[2] - date('d') >= 0))) {
//        //$date_of_electionErr = "Date of election cannot be a time in the past specify the date in the format provided";
//    } else {
//        $end_date_of_election = test_inputs($_POST["end_date_of_election"]);
//        $end_date_of_election1 = convert_date($end_date_of_election);
//            if($now_date > $end_date_of_election1){
//                $end_date_of_electionErr = "Time is in the past";
//            }
//
//
//			//comparing between start and end date of election
//			if($start_date_of_election1 > $end_date_of_election1){
//				$end_date_of_electionErr = "Invalid election duration";
//			}else{
//				$end_date_of_electionErr = "";
//			}
//    }
//
//
//
//    if (empty($_POST["time_of_election_from"])) {
//        $time_of_election_fromErr = "start time of election is required";
//    } else {
//        $time_of_election_from = test_inputs($_POST["time_of_election_from"]);
//        //$time_of_election_from1 = convert_date($time_of_election_from);
//    }
//
//    if (empty($_POST["time_of_election_to"])) {
//        $time_of_election_toErr = "End time of election is required";
////    } elseif() {
////        $time_of_election_toErr = "Time of election cannot be i";
//    } else {
//        $time_of_election_to = test_inputs($_POST["time_of_election_to"]);
//       // $time_of_election_to1 = convert_date($time_of_election_to);
//    }
//
//
//    //if start and end date is same
//    if($start_date_of_election1 == $end_date_of_election1){
//        $time_of_election_from1 = convert_date($time_of_election_from);
//        $time_of_election_to1 = convert_date($time_of_election_to);
//            if($time_of_election_from1 > $time_of_election_to1){
//                $time_of_election_toErr = "Invalid time, election date is same";
//            }
//    }
//
//   $serverName = "localhost";
//    $userName = "root";
//    $password = "";
//    $election_pin = election_pins();
//    $date_created = date('Y-m-d');
//    $user_id = user_id_from_session();
//    $posts = post_pin();
//
//    try {
//        $conn = new PDO("mysql:host=$serverName; dbname=eVoting", $userName, $password);
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//        if ($name_of_election && $start_date_of_election && $end_date_of_election && $time_of_election_from && $time_of_election_to != "") {
//
//            $csv_name = date('His') . trim($_FILES['election_csv']['name']);
//            $csv_type = $_FILES['election_csv']['type'];
//            $csv_size = $_FILES['election_csv']['size'];
//            $csv_tmp = $_FILES['election_csv']['tmp_name'];
//			$csv_arr= explode('.', $csv_name);
//            $csv_ext= strtolower(array_pop($csv_arr));
//            $csv_valid_types = array('text/csv', 'text/plain', 'application/csv', 'text/comma-separated-values',
//                'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel',
//                'text/anytext', 'application/octet-stream', 'application/txt');
//
//            $target = CSV_PATH . basename($csv_name);
//
//            if(!is_uploaded_file($csv_tmp)) {
//                $errors[] = 'Please upload CSV file';
//            }
//            elseif($csv_size > MAX_FILE_SIZE) {
//                $errors[] = 'The CSV file must not be greater than ' . (MAX_FILE_SIZE / 1024) . 'KB';
//            }
//            elseif(!in_array($csv_type, $csv_valid_types) || $csv_ext !== 'csv')  {
//                $errors[] = 'Uploaded file must be in the CSV format';
//            }
//            elseif(!move_uploaded_file($csv_tmp, $target)) {
//                $errors[] = 'There was problem uploading your csv file';
//            }
//
//            $csvFields = readCsv($target);
//            $field_count = 0;
//
//            if(!$csvFields) {
//                $errors[] = 'Cannot read csv file. Please upload a valid csv file';
//            }
//            else {
//                foreach($csvFields as $field) {
//                    $field_count = count($field);
//                }
//                if($field_count != 1) {
//                    $errors[] = 'Please upload a csv file containing emails only';
//                }
//            }
//
//            if(empty($errors)) {
//                $sql1 = "INSERT INTO election(election_name, election_start_date, election_end_date, election_time_from, election_time_to, election_pin, user_id)
//                VALUES('$name_of_election', '$start_date_of_election', '$end_date_of_election', '$time_of_election_from', '$time_of_election_to', '$election_pin', '$user_id')";
//                $conn->exec($sql1);
//                $last_election_id = $conn->lastInsertId();
//
//                $sql = $conn->prepare("INSERT INTO posts(post_key, post, election_id)VALUES (:posts_key, :posts_post, :last_election_id)");
//                $sql->bindParam(':posts_key', $posts_key_value);
//                $sql->bindParam(':posts_post', $posts_post_value);
//                $sql->bindParam(':last_election_id', $last_election_id_value);
//
//                foreach ($posts as $key => $value) {
//                    $posts_key_value = $key;
//                    $posts_post_value = $value;
//                    $last_election_id_value = $last_election_id;
//                    $sql->execute();
//                }
//                $last_post_id = $conn->lastInsertId();
//
//                //csv module
//
//                $select_query = "SELECT email, user_id FROM users";
//                $smh = $conn->prepare($select_query);
//
//                if ($smh->execute()) {
//                    $result = $smh->fetchAll(PDO::FETCH_ASSOC);
//                }
//
//                $fields = array('user_id', 'email');
//                $valid_voters_id = csv_valid_voters($csvFields, $result, $fields);
//
//                if ($valid_voters_id) {
//                    $query_electionId = "SELECT election_id FROM election WHERE election_pin = '$election_pin'";
//                    foreach ($conn->query($query_electionId) as $election) {
//                        $election_id = $election['election_id'];
//                    }
//
//                    for ($i = 0; $i < count($valid_voters_id); $i++) {
//                        $valid_voters_id[$i]['election_id'] = $election_id;
//                    }
//
//                    foreach ($valid_voters_id as $voter) {
//                        $insertQuery = "INSERT INTO joined (user_id, election_id) VALUES (:user_id, :election_id)";
//                        $smh = $conn->prepare($insertQuery);
//                        $smh->execute($voter);
//                    }
//                    $valid_users_emails = csv_valid_voters($csvFields, $result, $fields, 1);
//                } else @unlink($target);
//            }
//        }
//
//        else {
//          echo "";
//        }
//
//    }
//    catch (PDOException $e) {
//      echo "connection failed: " . $e->getMessage();
//    }
//
//
//    $conn = null;
//}
//
//if ($last_election_id >0 && $last_post_id > 0) {
//    $v_voters = base64url_encode(serialize($valid_voters_id));
//    $v_users = base64url_encode(serialize($valid_users_emails));
//    $page = 'createelection3.php?inid=' . $v_voters . '&notinid=' . $v_users;
//    header('Location: ' . $page);
//
//}else{
//    echo "";
//}

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
                                    Note: All fields are compulsory to update your election.<br><br>
                                </div>
                                <div class="col-lg-8 col-lg-offset-2 form">
                                    <fieldset>
                                        <form action="">

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
                                                <label>Do you want to edit posts?</label>
                                                <input type="radio" onchange="displayPosts('editPosts')" name="oldPost"/>Yes
                                                <input type="radio" onchange="displayPosts('editPosts')" name="oldPost" />No
                                            </div>
											<div id="editPosts" style="display:none;">
												<div class="row">
													<div class="col-lg-6"><div id="newDem"><input type='text' value="supervisor" required></div></div>
												<div class="col-lg-6"><div id="newDem1"><input type='text' value="super-a1" required></div></div>
												</div>
											</div>
                                            <div class="form-group">
                                                <label>Do you want to add new posts?</label>
                                                <input type="radio" onchange="displayPosts('addPosts')" name="newPost"/>Yes
                                                <input type="radio" onchange="displayPosts('addPosts')" name="newPost" />No
                                            </div>
											<div id="addPosts" style="display:none;">
												<div class="form-group" >
													<label>Number of Posts</label>
													<input type="number"  id="number_of_posts"  value="" name="number_of_posts" class="form-control" oninput="myfunction();" min="1" max="20" placeholder="No of Posts" >
												</div><br>
												<div class="row">
													<div class="col-lg-6"><div id="dem"></div></div>
												<div class="col-lg-6"><div id="dem1"></div></div>
												</div>
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

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script src="../js/file.js"></script>

</body>

</html>

