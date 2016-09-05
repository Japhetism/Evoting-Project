<?php
include_once('../php/view_Contestant_Profile.php');
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

    <title>E-voting | Profile</title>

    <link href="../images/logo.png" rel="icon">
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

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- container header-->
            <div class="row">
                <div class="page-title col-md-12">
                    <h3>Contestant Profile</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li><a href="<?php echo($_SESSION['adek_link']) ?>"><?php echo $_SESSION['election_name'];?></a></li>
                            <li class="active">Contestant Profile</li>
                        </ol>
                    </div>
                </div>

            </div>
            <!-- container header ends-->
            <!-- begin page-header -->
            <h3 class="page-header" style="text-align: center;"><?php echo $contestant_fullname. " - Profile";?></h3>
            <!-- end page-header -->
            <div class="row profile">
                <div class="col-md-4">
                    <?php echo "<img class='img-circle' src='".$contestant_picture."' alt='' width='100%' height='300px'>"; ?>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3 col-xs-3">
                                    <strong>Fullname: </strong>
                                </div>
                                <div class="col-md-9 col-xs-9">
                                    <small><?php echo $contestant_fullname; ?></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-3">
                                    <strong>Nickname: </strong>
                                </div>
                                <div class="col-md-9 col-xs-9">
                                    <small><?php echo $contestant_nickname; ?></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-5 col-md-3">
                                    <strong>Email Address: </strong>
                                </div>
                                <div class="col-xs-7 col-md-9">
                                    <small><?php echo $contestant_email; ?></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-5 col-md-3">
                                    <strong>Contesting for: </strong>
                                </div>
                                <div class="col-xs-7 col-md-9">
                                    <small><?php echo $contestant_post; ?></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <strong>Manifestoes:</strong>
                                </div>
                                <div class="col-xs-12 col-md-9">
                                    <small><?php
                                            if(!empty($manifestos)) {

                                                echo "<ul>";
                                                for ($i = 0; $i < count($manifestos); $i++) {
                                                    echo "<li>" . $manifestos[$i] . "</li>";
                                                }
                                                echo "</ul>";
                                            }else{
                                                echo "None";
                                            }
                                            if(!empty($contestant_citation)) {
                                                $download_link=$citation_dir.$contestant_citation;
                                            echo  "Download citation <a href='$download_link' download>"." here"."</a>";
                                            }
                                            else {
                                                echo "<h4>Contestant Citation: None</h4>";
                                            }
                                                ?>
                                    </small>
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
    <!-- <script src="../js/jquery.js"></script> -->

    <!-- custom js -->
     <script src="../js/file.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <!-- <script src="../js/bootstrap.min.js"></script> -->

</body>

</html>

