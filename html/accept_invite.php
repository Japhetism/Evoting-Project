<?php
include_once('../php/connection.php');
include_once('../php/accept_reject_invite.php');
include_once('../php/database.php');
include_once('../php/function.php');

$election_id = $_SESSION['election_index'];

//fetching the election details
$election_name = $election_start_date = $election_end_date = $election_time_from = $election_time_to = $string_election = "";
$result_tag1 = $result_tag2 = "";
$election_start_date = changeDateFormat( $election_details['election_start_date']);
$adela = $election_details['election_time_from'];
$election_time_from=(explode(":",$adela)[0]-1).":".explode(":",$adela)[1].":".explode(":",$adela)[2];

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
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
            width: 140px;
            /*text-align: right;*/
        }    </style>

   <link href="../css/bootstrap.min.css" rel="stylesheet">
   <link href="../css/countdown.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>

<div class="container">

    <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" style="font-size: 20px; text-align: center"><?php print $election_details["election_name"];?></h3>

                </div>
                <div class="panel-body">
                    <p>You have been invited to participate in the <b><?php print $election_details["election_name"];?></b>.
                    This invitation will be  discarded if you do not ACCEPT or DECLINE it in</p>

                    <div class="row">
                        <div id="clockdiv" class="col-xs-12">
                            <div >
                                <span class="days"></span>
                                <div class="smalltext">Days</div>
                            </div>
                            <div >
                                <span class="hours"></span>
                                <div class="smalltext">Hours</div>
                            </div>
                            <div >
                                <span class="minutes"></span>
                                <div class="smalltext">Minutes</div>
                            </div>
                            <div >
                                <span class="seconds"></span>
                                <div class="smalltext">Seconds</div>
                            </div>
                        </div>
                        <label for="pin">Election Pin:</label><h4><?php print $election_details["election_pin"];?></h4>

                    <h5 style="text-align: center">ADMIN DETAILS</h5>
                    <div clas="row">
                        <div class="col-xs-4">
                            <p ><?php echo $election_admin_detail?></p>
                        </div>
                        <div class="col-xs-8">
                            <label for="aName">Name:</label><h4><?php echo $admin_details["fname"].'  '.$admin_details["lname"]?></h4><br>
                            <label for="aEmail">Email:</label><h4><?php print $admin_details["email"]?></h4><br>
                            <label for="aphone">Phone Num.:</label><h4><?php print $admin_details["phone"]?></h4><br>
                            <label for="aGender">Gender:</label><h4><?php echo $admin_details["gender"]?></h4>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 200px;padding-left: 230px;">
                        <div class="col-md-12">
                            <div class="form-inline">
                                <input class="btn btn-success" type="submit" name="accept" value="Accept">
                                <input class="btn btn-danger col-md-offset-1" type="submit" name="decline" value="Decline">
                            </div>
                        </div>
                    </div>

                    </div>
<!--script for the countdown-->
                    <script src="../js/countdown.js"></script>
                    <script>
                        var deadline = new Date(Date.parse('<?php echo $election_start_date." ".$election_time_from;?>') );
                        initializeClock('clockdiv', deadline);
                    </script>
                </div>
            </div>
    </form>
    <div id="clear"></div>
</div>

            <!-- Right side div -->
<div id="clear"></div>
</div>

        <!--        end-->

    </div>

</body>

</html>
