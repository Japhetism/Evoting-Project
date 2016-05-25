<?php
include_once('../php/register_candidate.php');
include_once('../php/photo.php');
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting</title>

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

    <style type="text/css">
    .error.pull-right{
        padding:9px 30px 0 0;
        text-align: left;
        font-weight: bold;
    }
    </style>
</head>
<body>

<div id="wrapper">
    <!-- Navigation -->
    <?php include_once('navlinks.php');?>
    
    <div id="page-wrapper">

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- edit form column -->
            <div class="row">
                <div class="col-xs-12" style="text-align: left">
                    <span class="alert alert-info">
                        <a href="election_detailsNews.php<?php echo $_SESSION['election_key'];?> " style="text-decoration: none">Home </a> > Joined ELection > <a href="postnews.php" style="text-decoration: none"><?php echo $_SESSION['election_name'];?> </a> > <b>Register candidate</b>
                     </span>
                </div><br>
                <div class="col-xs-8 col-xs-offset-2">
                    <div class="electoralform">
                        <fieldset class="dash">
                            <div class="col-xs-10 col-xs-offset-1 personal-info">
                                <h3 style=" text-align: center">Candidate Registration</h3><br>
                                   <form enctype="multipart/form-data" class="form-horizontal" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                                        <span class="col-xs-9 col-xs-offset-2 error" style="font-size: 14px">
                                            <?php echo $registration_message; ?>
                                        </span>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">first name:</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" value="<?php echo $contestant_fname;?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">last name:</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" value="<?php echo $contestant_lname; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Email:</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="email" placeholder="Email address" value="<?php echo $myemail; ?>" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Username:</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" name="" value="<?php echo $contestant_username; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Nickname:</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" placeholder="Nickname" name="nick_name" value="<?php echo $nick_name; ?>" required><span class="error"> <?php echo $nick_nameErr; ?></span>
                                            </div>
                                            <span class="col-xs-1 error pull-right">*</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Post:</label>
                                            <div class="col-xs-8">
                                                <?php echo $postString;?>
                                                <span class="error"><?php echo $contestant_postErr; ?></span>
                                            </div>
                                            <span class="col-xs-1 error pull-right">*</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Pin:</label>
                                            <div class="col-xs-8">
                                            <input class="form-control" placeholder="Pin" type="text" name="contestant_pin" value="<?php echo $contestant_pin_temp; ?>"  required>
                                            <span class="error"> <?php echo $contestant_pinErr; ?></span>
                                            <span class="error"> <?php echo $errors; ?></span>
                                              </div>
                                            <span class="col-xs-1 error pull-right">*</span>
                                        </div>
                                        <div class="form-group">
                                          <label class="col-xs-3 control-label">Manifesto:</label>
                                          <div class="col-xs-8">
                                            <input class="form-control" type="number" id="no_of_points" name="manifesto_points" value="" oninput="myfunction2()" min="1" max="10" placeholder="No of manifesto_points" required><span class="error"> <?php echo $no_manifesto_pointsErr; ?></span>
                                          </div>
                                            <span class="col-xs-1 error pull-right">*</span>
                                        </div>
                                        <div class="form-group">
                                          <div class="col-xs-1 col-xs-offset-2 " id="dem1">

                                          </div>
                                          <div class="col-xs-8" id="dem">

                                          </div>
                                        </div>
                                        <div class="form-group" >
                                            <label class="col-xs-3 control-label">Picture: </label>
                                                <div class="col-xs-8">
                                                    <div class="input-group">
                                                        <input type="file" name="image" id="picture" required class="btn btn-default form-control"  style="border-right: none;">
                                                        <span class="input-group-addon after clear-input" target='#picture' style="background: transparent;border-left: none;padding: 0">
                                                            <i class="fa fa-close"  data-toggle="tooltip"  data-title="clear field"></i>
                                                        </span>
                                                    </div>
                                                    <p id="pic_error1" class="error" style="display:none; color:#ff0000;">Image formats should be JPG, JPEG,or PNG .</p>
                                                    <p id="pic_error2" class="error" style="display:none; color:#FF0000;">Max file size should be 2MB.</p>
                                                    <p class="help-block">
                                                        Pls ensure the file being uploaded is clear picture of yourself.<br><span class="error"> <?php echo $uploadErr; ?></span>
                                                        <span class="error"><?php echo $success; ?></span>
                                                    </p>
                                                </div>
                                            <span class="col-xs-1 error pull-right">*</span>
                                        </div>
                                        <div class="form-group" >
                                            <label class="col-xs-3 control-label">Citation: </label>
                                            <div class="col-xs-8">
                                                <div class="input-group">
                                                    <input type="file" name="citation" id="citation" class="btn btn-default form-control" style="border-right: none;">
                                                    <span class="input-group-addon after clear-input" target='#citation' style="background: transparent;border-left: none;padding: 0">
                                                        <i class="fa fa-close"  data-toggle="tooltip"  data-title="clear field"></i>
                                                    </span>
                                                </div>
                                                
                                                <p class="help-block">
                                                    <p id="sig_error1" class="error" style="display:none; color:#FF0000;">Citation format should be PDF.</p>
                                                    <p id="sig_error2" class="error" style="display:none; color:#FF0000;">Max file size should be 2MB.</p>

                                                    Pls ensure the file being uploaded is a PDF file.<br>
                                                    <span class="error"> <?php echo $uploadCitationErr; ?></span><span class="error"> <?php echo $successC; ?></span>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="col-xs-3 control-label"></label>
                                          <div class="col-xs-4 col-xs-offset-2">
                                            <input class="btn btn-primary" value="Save" name="submit" type="submit">
                                            <input class="btn btn-default" value="Cancel" type="reset" onclick="window.location='election_detailsNews.php?key=<?php echo $_SESSION["election_key"]?>';">
                                          </div>
                                        </div>
                                    </form>
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
<!-- <script src="../js/jquery.js"></script> -->

<!-- Bootstrap Core JavaScript -->
<!-- <script src="../js/bootstrap.min.js"></script> -->

<!-- Custom JavaScript -->
<script src="../js/contestant.js"></script>

<!-- <script src="../js/file.js"></script> -->

</body>
<!--check of types of file by Adela-->
<script src="../js/file_upload.js"></script>
</html>

