<?php
include_once('../php/updateelection.php');
include_once('../php/photo.php');
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
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
        #page-wrapper{
            background-color: rgba(51,122,183,0.1);
        }
        .badge{
            position: absolute;
            top: 0px;
            right: 30px;
            box-shadow: 0px 2px 3px rgba(0,0,0,0.14);
            opacity: 1;
            background: #c10510;
            padding: 5px;
        }
        .hide{
            transition: display 0.3s;
        }
    </style>

    <link rel="stylesheet" href="../css/jquery-ui.css">
    <!-- <script src="../js/jquery.js"></script> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Update Election Details</title>

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
<link href="../css/timepicki.css" rel="stylesheet">
<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_once('navlinks.php');?>


    <div id="page-wrapper">

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="myModalLabel" style="color:black;border:none;">Enter the election pin</h3>
                </div>
                <form  method="POST" id="thatForm" >
                    <div class="modal-body row" id="input" style="text-align:center;" >
                        <div class=" col-md-4 col-md-offset-4 " >
                            <input type="text" name="pin" class=" form-control" style="background: rgba(0,0,0,0.1);text-align:center;" placeholder="PIN">
                        </div>
                        <p class="col-md-8 col-md-offset-2 " id="output"></p>
                    </div>
                    <div class="modal-footer" id="input2">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" value="Join" id="formSubmit">
                    </div>
                </form>
            </div>
        </div>
    </div>

            <!-- container header-->
            <div class="row">
                <div class="page-title col-xs-12">
                    <h3>Update Election</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li><a href="<?php echo $_SESSION['adek_link'];?> "><?php echo $_SESSION['election_name'];?> </a></li>
                            <li class="active">Update Election Details</li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="electoralform" style="background: #fff">
                        <fieldset class="dash" >
                            <div class="col-md-10 col-md-offset-1">
                                <p style="border-bottom: solid 2px #265a88; font-size: 17px">
                                    <label>
                                        Please fill in appropriately, details of the election you want to edit in the
                                        fields provided below.
                                    </label>
                                </p>
                                <p class="text-danger" style="font-size: 15px;">
                                    <strong>Note </strong>: None of the date and time should be left unfilled once at
                                    least one of  them is changed.<br>Previous values are automatically discarded once
                                    this form is submitted.<br><br>
                                    <span class="error"><?php echo $messaging; ?></span>
                                </p>
                            </div>
                            <div class="col-xs-10 col-xs-offset-1 form">
                                <fieldset>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="row">
                                            <div class="form-group col-xs-12"><br>
                                                <label>Name of Election</label><br>
                                                <input type="text" class="form-control" id="election_name" name="name_of_election" value ="<?php echo $this_election['election_name']; ?>" placeholder="Name of Election" >
												<span class="error"><?php echo $name_of_electionErr; ?></span>
										    </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="form-group col-xs-12 col-md-6">
                                                <label>Start Date of Election</label><br>
                                                <div>
                                                    <d><?php echo dateString($this_election['election_start_date'])?></d>
                                                    <input type="text" class="datePicker form-control"  id="datePicker1" name="start_date" value="<?php echo $dummy1;?>" style="display: none;">
                                                </div>
                                                <span class="error"><?php if(empty($messaging)) echo $start_date_of_electionErr; ?></span>
                                            </div>
                                            <div class="form-group col-xs-12 col-md-6">
                                                <label>Start Time of Election</label><br>
                                                <div>
                                                    <d><?php echo timeString($this_election['election_time_from'])?></d>
                                                </div>
                                                <div id="timeStart" style="display: none">
                                                    <div id="elect_time">
                                                        <!-- enditime -->
                                                        <div class="inner cover indexpicker">
                                                            <div class="time_pick"><input id="timepicker1" class="form-control" type="text" name="start_time" value="<?php echo $dummy3;?>">
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
                                                    <span class="error"><?php if(empty($messaging)) echo $time_of_election_fromErr; ?></span>
                                                </div><br>
                                            </div>
                                        </div><br>

                                        <div class="row">
                                            <div class="form-group col-xs-12 col-md-6">
                                                <label>End Date of Election</label><br>
                                                <div>
                                                    <d><?php echo dateString($this_election['election_end_date'])?></d>
                                                    <input type="text" class="datePicker form-control" id="datePicker2" name="end_date" value="<?php echo $dummy2;?>" style="display: none;">
                                                </div>
                                                <span class="error"><?php if(empty($messaging)) echo $end_date_of_electionErr; ?></span><br>
                                            </div>
                                            <div class="form-group col-xs-12 col-md-6">
                                                <label>End Time of Election</label><br>
                                                <div>
                                                    <d><?php echo timeString($this_election['election_time_to'])?></d>
                                                </div>
                                                <div id="timeEnd" style="display: none">
                                                    <div id="elect_time">
                                                        <!-- enditime -->
                                                        <div class="inner cover indexpicker">
                                                            <div class="time_pick"><input id="timepicker2" class="form-control" type="text" name="end_time" value="<?php echo $dummy4;?>">
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
                                                    <span class="error"><?php if(empty($messaging)) echo $time_of_election_toErr; ?></span>
                                                </div><br>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-xs-10">
                                                <button type="button" class="btn btn-warning form-control" id="dateButton" onclick="displayContent()">Change Date/Time</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" id="row editPosts" >
                                            <div class="col-xs-6" style="text-align: left;">
                                                <?php echo $post_string;?>
                                            </div>
											<div class="col-xs-5" style="text-align: left; padding-left:35px">
                                                <?php  echo $pin_string;?>
											</div>
										</div>
                                        <div class="row form-group"><br>
                                            <label class="col-xs-10">Do you want to add new posts?</label>
                                            <div class="col-xs-8 col-md-8">
                                                <input type="radio" onchange="displayPosts('addPosts')" name="newPost"/>Yes
                                                <input type="radio" onchange="displayPosts('addPosts')" name="newPost" checked />No
                                            </div>
                                        </div>

                                        <span class="error"><?php echo $new_post_Err; ?></span>
                                        <div class="row form-group" id="addPosts" style="display:none;">
											<div class="col-xs-12" >
												<label>Number of Posts</label>
												<input type="number"  id="number_of_posts"  value="" name="number_of_new_posts" class="form-control" oninput="myfunction();" min="1" max="20" placeholder="No of Posts" >
											</div>
											<div class="col-xs-12">
												<div class="col-md-6"><div id="dem" style="display: none"></div></div>
											    <div class="col-md-6"><div id="dem1" style="display: none"></div></div>
											</div>
                                        </div>
                                        <?php echo($status_string);?>
                                        <input type="submit" class="btn btn-success" name="update" value="submit">
                                    </form>
                                </fieldset>
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
    <script src="../js/jquery-ui.js"></script>
    <script type="text/javascript">
        $( ".datePicker" ).datepicker();
    </script>
<!--    wrapper-->


<!-- jQuery -->
<!--<script src="../js/jquery.js"></script>-->

<!-- Bootstrap Core JavaScript -->
<!-- <script src="../js/bootstrap.min.js"></script> -->

<!-- Custom JavaScript -->
 <script src="../js/file.js"></script>

</body>

</html>

