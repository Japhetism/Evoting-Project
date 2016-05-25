<?php
require_once '../php/csv.php';
require_once '../php/database.php';
require_once '../php/photo.php';

error_reporting(0);

require_once '../php/connection.php';
include_once('../php/session.php');

// $csv_arrays = null;

if(isset($_GET['election']) && isset($_GET['csv'])) {
    $type = ($_GET['csv'] === 'active') ? 1 : 0;
    $election_pin = $_GET['election'];
    if(isset($_SESSION['csv'])) {
        $csv_arrays = unserialize(base64url_decode($_SESSION['csv']));
        unset($_SESSION['csv']);
    }

    $query_electionId = "SELECT election_id FROM election WHERE election_pin = '$election_pin'";
    if($result = $connection1->query($query_electionId)) {
        $election_id = $result->fetch()['election_id'];
    }
}
else header('Location: createelection1.php');

$message = '<div><div style="margin-bottom: 30px; text-align: left">';

if($type == 1) {
    if(is_array($csv_arrays) && !empty($csv_arrays)) {
        $select_query = "SELECT email FROM users";
        $smh = $connection1->prepare($select_query);

        if($smh->execute()) {
            $result_1 = $smh->fetchAll(PDO::FETCH_ASSOC);
        }

        $fields = array('email');
        $valid_users = csv_valid_voters($csv_arrays, $result_1, $fields, 1);
        $valid_voters = array_values_recursive(csv_valid_voters($csv_arrays, $result_1, $fields));
        $csv_length = count($csv_arrays);
        $voters_count = (empty($valid_voters)) ? 0 : count($valid_voters);
        $user_count = (empty($valid_users)) ? 0 : count($valid_users);

        if(isset($election_id)) {
            if($user_count != 0) {
                $ignored_voters = array();
                foreach($valid_users as $user => $email) {
                    $ignored_voters[] = array('email' => $email, 'election_id' => $election_id);
                }

                foreach($ignored_voters as $voters) {
                    $ignored = getAllMembers('ignored', array('email'), array('election_id', '=', $election_id), 1);
                    if(!in_array($voters['email'], $ignored)) {
                        $insert_query = "INSERT INTO ignored (email, election_id) VALUES (:email, :election_id)";
                        $smh = $connection1->prepare($insert_query);
                        $smh->execute($voters);
                    }
                }                   
            }

            if($user_count == $csv_length && $valid_count == 0) {
                $message .= "<p>No individual with the email address(es) in the uploaded csv file has an active account.</p>";
            }
            else {
                $message .= "<p>The number of individuals sent an invitation for this election is: {$voters_count}</p>";
                $message .= "<p>The number of individuals not sent invitation to participate in this election is: {$user_count}</p><br>";
            }
            if($user_count != 0) {
                $message .= '<p style="border-top: 1px solid #eee; color:maroon; padding-top: 5px text-align:center"><em>Uninvited individuals need to create an account to participate in this election</em></p>';
            }

            $message .= "</div><hr>";

            $count = ((count($csv_arrays) - 5) <= 0) ? count($csv_arrays) : 5;
            $emails = array_values_recursive($csv_arrays);

            if(is_array($emails)) {
                $message .= '<p class="primary" style="color: #fff; padding: 10px;">The first five (or less) email addresses in the uploaded csv file are as follows:<p>';
                $message .= '<div class="table-responsive"><table class="table table-bordered"><thead><tr><td>Index</td><td>Email</td><tr></thead><tbody>';
                for($i=0; $i < $count; $i++) {
                    $j = $i + 1;
                    $message .= '<tr><td>' . $j . '</td><td style="text-align:left;">' . $emails[$i] . '</td></tr>';
                }
                $message .= '</tbody></table></div>';
            }
            else {
                $message .=  '<p>There was a problem displaying the emails in the uploaded csv file. Please proceed to be sure of the final outcome</p>';
            }

            foreach($csv_arrays as $array => $value) {
                $key = (is_array($value)) ? array_keys($value) : $key = $array[0];
            }

            if(strpos($key[0], '@')) {
                $mesaage .= '<div style="margin-bottom: 20px;"><hr>';
                $message .= '<p><em>**Please note that </em><strong>' . $key[0] . '</strong><em> is invalid as it was used as the header of the csv file uploaded**</em></p></div>';
            }
        }
        else $message .= "Sorry, this election does not exist";
    }
    else $message .= "<p>There was a problem displaying the final outcome of election creation. Please proceed to be sure of the final outcome.</p>";
}
elseif(empty($election_id) && $type == 0) {
    $message .= '<p>This is an invalid election as it does not exist</p>';
}
else {
    $message .= '<p>Your election has been created successfully. Click on <strong>finish</strong> to proceed.</p>';
}
$message .= '</div>';
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard | Create Election</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                <a class="navbar-brand" href="#">
                    <!-- logo -->
                    <i class="fa fa-play-circle"></i>  <span class="light">E -</span> Voting
                </a>
        </div>
        <!-- Top-right Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle showActions inactive" id="showActions">
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
                <li>
                        <a href="#" class="inactive"><i class="fa fa-dashboard"></i>
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
                            <a href="#" class="inactive"> Public Elections<i class="btn pull-right success" >1 </i></a>
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
                    
                <li class="active">
                    <a href="#" data-target="#demo4" class="active" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus"></i>Create an Election<i class="fa fa-angle-left pull-right" ></i></a>
                        <ul class="open collapse in" id="demo4">
                            <li>
                                <a href="#" class="inactive">Step 1<i class="fa fa-check-circle-o fa-lg text-success pull-right" ></i></a>
                            </li>
                            <li>
                                <a href="#" class="inactive">Step 2<i class="fa fa-check-circle-o fa-lg text-success pull-right" ></i></a>
                            </li>
                            <li>
                                <a href="#" class="active">Step 3<i class="fa fa-spinner fa-spin pull-right"></i></a>
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
                <div class="page-title col-xs-12">
                    <h3>Create Election</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Create Election</a></li>
                            <li><a href="#">Step 1</a></li>
                            <li><a href="#">Step 2</a></li>
                            <li class="active">Step 3</li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->
			
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="electoralform">
                        <fieldset class="dash">
                            <div class="row">
                                <div class="col-lg-8 col-lg-offset-2 form">
                                    <fieldset>
											<div class="row" style="padding-top:30px;">
                                                <div class="col-md-12" id="csvemails">
													<p style="font-size:30px;font-weight:bolder;">Election created successfully <span class='fa fa-check' style='color:lawngreen;'> </span></p>
                                                    <?php echo $message; ?>
                                                </div>
                                                <a href="maindashboard.php"><input type="button" class="btn btn-success" value="Finish"></a>
                                            </div>
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
<?php
//if(isset($_POST["check_agree"])&& ($_SERVER["REQUEST_METHOD"]== "submit_dash3")) {
//    $name_of_electionErr = $date_of_electionErr = $time_of_election_fromErr = $election_pinErr = $time_of_election_toErr = "";
//    $name_of_election = $date_created = $date_of_election = $time_of_election_from = $time_of_election_to = $election_pin = "";
//
//    if ($_SERVER["REQUEST_METHOD"] == "POST") {
//        if (empty($_POST["name_of_election"])) {
//            $name_of_electionErr = "Name of election is required";
//        } else if (!preg_match("/^[a-zA-Z ]*$/", test_inputs($_POST["name_of_election"]))) {
//            $name_of_electionErr = "Only letters and white space allowed";
//        } else {
//            $name_of_election = test_inputs($_POST["name_of_election"]);
//        }
//
//        if (empty($_POST["date_of_election"])) {
//            $date_of_electionErr = "Date of election is required";
////    } else if()) {
////        $date_of_electionErr = "Date of election cannot be a time in the past";
////    }
//        } else {
//            $date_of_election = test_inputs($_POST["date_of_election"]);
//        }
//        if (empty($_POST["time_of_election_from"])) {
//            $time_of_election_fromErr = "Time of election from is required";
//        } else {
//            $time_of_election_from = test_inputs($_POST["time_of_election_from"]);
//        }
//
//        if (empty($_POST["time_of_election_to"])) {
//            $time_of_election_toErr = "";
////    } elseif() {
////        $time_of_election_toErr = "Time of election cannot be i";
//        } else {
//            $time_of_election_to = test_inputs($_POST["time_of_election_to"]);
//        }
//        $election_pin = "0" . rand(01, 9) . " - " . rand(1000, 9999);
//        $date_created = date('Y-m-d');
//
//        $serverName = "localhost";
//        $userName = "root";
//        $password = "";
//        try {
//            $conn = new PDO("mysql:host=$serverName; dbname=evoting", $userName, $password);
//            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo "connected successfully";
//            if ($name_of_election && $date_of_election && $time_of_election_from && $time_of_election_to != "") {
//
//                $sql = "INSERT INTO election(election_name, date_created, election_date, election_time_from, election_time_to, election_pin )
//            VALUES('$name_of_election', '$date_created', '$date_of_election', '$time_of_election_from', '$time_of_election_to', '$election_pin')";
//                $conn->exec($sql);
//                $last_election_id = $conn->lastInsertId();
//                echo "<br>A row was successfully added to Table election with id no.(total number of elections created): <br>" . $last_election_id;
//            } else {
//                echo "No data added to the table row";
//            }
//        } catch (PDOException $e) {
//            echo "connection failed: " . $e->getMessage();
//        }
//        $conn = null;
//    }
//
//
//    $posts = post_pin();
//    foreach ($posts as $key => $value) {
//        echo $key . "<br>";
//        echo $value . "<br>";
//    }
//    $serverName = "localhost";
//    $userName = "root";
//    $password = "";
//    try {
//        $conn = new PDO("mysql:host=$serverName; dbname=evoting", $userName, $password);
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        echo "connected successfully";
//
//        $sql = $conn->prepare("INSERT INTO posts(post_key, post, election)VALUES (:posts_key, :posts_post, :last_election_id)");
//        $sql->bindParam(':posts_key', $posts_key_value);
//        $sql->bindParam(':posts_post', $posts_post_value);
//        $sql->bindParam(':last_election_id', $last_election_id_value);
//        foreach ($posts as $key => $value) {
//            $posts_key_value = $key;
//            $posts_post_value = $value;
//            $last_election_id_value = $last_election_id;
//            $sql->execute();
//        }
//        $last_post_id = $conn->lastInsertId();
//        echo "<br>A rows were successfully added to Table posts with id no.(total number of post in the db): <br>" . $last_post_id;
//////        }else{
////            echo "No data added to the table row";
////        }
//    } catch (PDOException $e) {
//        echo "connection failed: " . $e->getMessage();
//    }
//}
?>