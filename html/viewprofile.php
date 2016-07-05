<?php
include_once('../php/view_profile.php');
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

    <title>Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style type="text/css">
            input[type=text]:active,
            input[type=text]:focus{
                border: none!important;
                border-radius: 10px;
            }
            input[type=text]{
                width: 50%;
                padding: 5px;
                line-height: 20px;
                border-radius: 10px;
                box-shadow: none!important;
            }
            @media(min-width: 768px){
                #updateProfile{
                 padding-left: 200px;
                }
            }
            .img-thumbnail{
                border:none;
            }
    </style>
    <script>
        function check(){
            var hasvoted = '<?php echo $hasvoted;?>'
            var link = document.getElementById('link');
            if(hasvoted==1){
                link.style.display = 'none';
            }
        }
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   </head>
<body onload="check()">

<div id="wrapper">

    <!-- Navigation -->
    <?php include_once('navlinks.php'); ?>


    <div id="page-wrapper" style="overflow-x: hidden">

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
                                <input type="text" name="pin" class=" form-control" style="background: rgba(0,0,0,0.1);text-align:center;width: 100%" placeholder="PIN">
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

            </div><br>
            <!-- container header ends-->
            
            <!-- Page Heading -->
            <div class="row">
                    <h3 style="text-align: center;" class="page-header">
                        <?php echo $user_nickname_here;?>
                        - Details
            <!-- <button class="btn btn-danger btn-sm pull-right" onclick="window.history.back();">Back</button> -->
                    </h3>
           <!--  </div> -->
            </div><!-- /#page-wrapper -->
            <div class="row" id="updateProfile">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                    <div class="row profile">
                        <div class="col-xs-12 col-md-4 img-thumbnail" id="pictureClick">
                                <p class="alert alert-warning editField hide">Please click image to change</p>
                            <?php 
                                echo "<img id='image' class='img-responsive' src='$user_picture_here' alt='$picture_name' width='100%' height='auto'><br>";
                            ?>
                            <input type="file" style="width: 100%;height: 100%;top:0;position: absolute;opacity:0;" name="image" class="editField hide btn btn-default hide pictureChange" id="pictureChange" onchange="showPhoto(this)">
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <div class="row">
                                <div class="col-xs-12 ">
                                    <span class=" error"><?php echo $update_election_message;?></span>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3">
                                            <strong>Firstname: </strong>
                                        </div>
                                        <div class="col-xs-9 col-md-9">
                                            <small><?php echo $user_fname; ?></small>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Lastname: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small><?php echo $user_lname; ?></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Nickname: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small class="editField"><?php echo $user_nickname_here; ?></small>
                                        <small class="editField hide"><input type="text" name="nick_name" value="<?php echo $user_nickname_here; ?>"></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Email Add.: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small><?php echo $myemail; ?></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Post: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small><?php echo $user_contestant_post; ?></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Manifestoes:</strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small class="editField">



                                            <?php
                                            echo '<ul>';
                                            for($i=0;$i<$no_of_manifesto_point;$i++){
                                                $id="\"dem$i\"";
                                                $edit_manifestos="\"$manifestos[$i]\"";
                                                $edit_manifestos_nameatt="\"manifesto$i\"";
                                                echo "<li id=$id> $manifestos[$i] </li>";

                                            }
                                            echo "</ul>";
                                            ?>
                                        </small>
                                        <small class="editField hide">
                                            <?php
                                            for($i=0;$i<$no_of_manifesto_point;$i++){
                                                $id="\"dem$i\"";
                                                $edit_manifestos="\"$manifestos[$i]\"";
                                                $edit_manifestos_nameatt="\"manifesto$i\"";
                                                echo "<input type='text' name='manifesto".$i."' value='".$manifestos[$i]."' >";
                                            }
                                            ?>

                                        </small>
                                    </div>
                                </div>
                               </div>

                            </div>

                            <div class="row">
                                <div class="col-md-8" style="text-align: center;">
                                    <input class="btn btn-danger" value="Step Down" type="submit" name="delete">
                                    <button type="button" class="toggleEdit editField btn btn-primary">Edit</button>
                                    <input class="editField btn btn-primary hide" value="Save" type="submit" name="submit">
                                    <input class="toggleEdit editField btn btn-default hide" onclick="window.location = location.href;" value="Cancel" type="reset">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    <!-- edit form column -->
  </div>
<!--    wrapper-->


<!-- jQuery -->
<!-- <script src="../js/jquery.js"></script> -->


<!-- jQuery -->
 <script src="../js/file.js"></script>

<!-- Bootstrap Core JavaScript -->
<!-- <script src="../js/bootstrap.min.js"></script> -->
<script src="../js/contestant.js"></script>

</body>

</html>

