<?php
require_once '../php/csv.php';

error_reporting(0);

require_once '../php/connection.php';
include_once('../php/session.php');


if(isset($_GET['status']) && isset($_SESSION['csv'])) {
    $status = unserialize(base64url_decode($_GET['status']));
    $csv_arrays = unserialize(base64url_decode($_SESSION['csv']));
}
else header('Location: createelection1.php');
?>





<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard-createelection</title>

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
					<a  data-toggle="collapse" data-target="#accounts"><i class="fa fa-fw fa-th"></i>My Elections<i class="fa fa-fw fa-caret-right"></i></a>
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
                            <a class="inactive" href="#">Step 1<i class="fa fa-check"> </i></a>
                        </li>
                        <li>
                            <a class="inactive" href="#">Step 2<i class="fa fa-check"> </i></a>
                        </li>
                        <li>
                            <a class="active" href="#">Step 3<i class="fa fa-spinner fa-spin"> </i></a>
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
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="electoralform">
                        <fieldset class="dash">
                            <div class="row">
                                <div class="col-lg-8 col-lg-offset-2 form">
                                    <fieldset>
											<div class="row" style="padding-top:30px;">
                                                <div class="col-md-12" id="csvemails">
													<p style="font-size:30px;font-weight:bolder;">Election created successfully <span class='fa fa-check' style='color:lawngreen;'> </span></p>
                                                    <?php
                                                        $error = false;
                                                        if($status['valid'] == true) {
                                                            if(is_array($csv_arrays) && !empty($csv_arrays)) {
                                                                $select_query = "SELECT email FROM users";
                                                                $smh = $connection1->prepare($select_query);

                                                                if($smh->execute()) {
                                                                    $result_1 = $smh->fetchAll(PDO::FETCH_ASSOC);
                                                                }
                                                                else {
                                                                    echo 'Not executed';
                                                                }
                                                                $fields = array('email');
                                                                $valid_users = csv_valid_voters($csv_arrays, $result_1, $fields, 1);
                                                                $valid_voters = array_values_recursive(csv_valid_voters($csv_arrays, $result_1, $fields));
                                                                $user_count = (empty($valid_users)) ? 0 : count($valid_users);

                                                                if(empty($valid_voters)) {
                                                                    $error = true;
                                                                }
                                                                else echo '<p>The total number of individuals invited for election is: ' . count($valid_voters) . '</p>';
                                                                echo '<p>The total number of individuals not invited for election is: ' . $user_count . '</p>';

                                                                unset($_SESSION['csv']);
                                                            }
                                                            else {
                                                                echo '<p>There was a problem displaying the final outcome of election creation. Please proceed to be sure of the final outcome</p>';
                                                            }
                                                        }
                                                        if($status['valid'] == false || $error) {
                                                        ?>
                                                            <p><strong>Please Note: </strong>No individual with the email address(es) in the uploaded csv file has an active account.</p>
                                                    <?php
                                                        }
                                                        echo '<hr><p style="font-size: 1.2em; font-weight:bold;">The first five (or less) email addresses in the uploaded csv file are as follows:<p>';
                                                        $count = ((count($csv_arrays) - 5) <= 0) ? count($csv_arrays) : 5;
                                                        $emails = array_values_recursive($csv_arrays);
                                                        if(is_array($emails)) {
                                                            echo '<table><tr><th>Index</th><th>Email</th></tr>';
                                                            for($i=0; $i<$count; $i++) {
                                                                $j = $i + 1;
                                                                echo '<tr><td>' . $j . '</td><td style="text-align:left;">' . $emails[$i] . '</td></tr>';
                                                            }
                                                            echo '</table>';
                                                        }
                                                        else echo '<p>There was a problem displaying the final outcome of election creation. Please proceed to be sure of the final outcome</p>';

                                                        foreach($csv_arrays as $array => $value) {
                                                            if(is_array($value))
                                                                $key = array_keys($value);
                                                            else $key = $array[0];
                                                        }

                                                        if(strpos($key[0], '@')) {
                                                            echo '<hr>';
                                                            echo '<p><em>**Please note that </em><strong>' . $key[0] . '</strong><em> is invalid as it was used as the header of the csv file uploaded**</em></p>';
                                                        }
                                                    ?>
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