<?php
include_once('../php/edit_user.php');
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

    <title>E-voting | View Profile</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- jQuery -->
    <script src="../js/jquery.js"></script>




    <script type="text/javascript">
        $('#load_cover').fadeIn();
    </script>

    <style type="text/css">
        input[type=password]:active,
        input[type=password]:focus,
        input[type=text]:active,
        input[type=text]:focus{
            border: none!important;
            border-radius: 10px;
        }
        input[type=password],
        input[type=text]{
            width: 50%;
            padding: 5px;
            line-height: 20px;
            border-radius: 10px;
            box-shadow: none!important;
            margin-bottom: 10px;
            background: rgba(0,0,0,0.03);
        }
        @media(min-width: 768px){
            #updateProfile{
             padding-left: 200px;
            }
        }
        #changePassword{
            cursor: pointer;
        }
        #pictureChange{
            border: none;
            background: transparent;
        }
        #pictureClick{
            background: rgba(0,0,0,0.05);
            padding: 15px 15px 30px 15px;
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   </head>
<body>

    <div id="load_cover" style="z-index: 90002;background:#fff;background-size: cover;width: 100%;height: 100%;position: fixed;top: 0;">
        <i class="fa fa-spin fa-spinner" style="position: absolute;top: 40%;left:49%;font-size: 50px"></i>
    </div>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_once('navlinks.php'); ?>

    <div id="page-wrapper" style="overflow-x: hidden;">

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                    <h3 class="page-header"  style="text-align: center;">
                         Profile
            <button class="btn btn-danger btn-sm pull-right" onclick="window.history.back();">Back</button>
                    </h3>
            </div>
            <div class="row" id="updateProfile">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <span class="error"><?php echo $mainError;?></span><br>
                        <span><?php echo $uploadErr;?></span><br>
                        <span><?php echo $success;?></span>
                    <div class="row profile">
                        <div class="col-xs-12 col-md-4" id="pictureClick">
                            <span class="error" id="imgError" style="display: none;width: 100%;text-align: center;">Invalid image</span>
                            <?php 
                                echo "<img id='image' class='image-responsive' src='$user_photo' alt='$photo' width='100%' height='300px'><br>";
                            ?>
                            <input type="file" style="width: 100%" name="image" class="editField hide btn btn-default hide pictureChange" id="pictureChange" onchange="showPhoto(this);">
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <div class="row">
                                <div class="col-xs-12 ">
                                   
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Lastname: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small class="editField"><?php echo $lname; ?></small>
                                        <input type="text" class="editField hide" name="lname" value="<?php echo $lname;?>" required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Firstname: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small class="editField"><?php echo $fname; ?></small>
                                        <input type="text" class="editField hide" name="fname" value="<?php echo $fname;?>" required/>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Username: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small class="editField"><?php echo $username; ?></small>
                                        <input type="text" class="editField hide" value="<?php echo $username;?>" name="username" required/>
                                    </div>
                                    <?php print_r($_SESSION); ?>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Email Address: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small><?php echo $myemail; ?></small>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Telephone: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small class="editField"><?php echo $phone; ?></small>
                                        <input type="text" class="editField hide" value="<?php echo $phone;?>" name="phone" required/>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Gender: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small class="editField"><?php echo $sex; ?></small>
                                        <div class="editField hide">
                                        <input  type="radio" class="editField hide" name="sex" <?php if (isset($sex) && $sex=="male") echo "checked";?> value="male" required/>Male
                                        <input  type="radio" class="editField hide" name="sex" <?php if (isset($sex) && $sex=="female") echo "checked";?> value="female" required/>Female
                                        </div>
                                    </div>
                            <div class="editField hide">
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Password: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <input type="password" class="editField hide" name="old_password" id="old_password" required/><br>
                                        <a class="editField hide" id="changePassword" onclick="changePassword()">Change Password <i class="fa fa-angle-down"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="editField hide" id="newPassword" style="display: none">
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>New Password: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <input type="password" class="editField hide" name="password1" id="new">
                                    </div>
                                </div>
                                <div class="row editField hide">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Confirm Password:</strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <input type="password" name="password2" id="confirmNew" oninput="confirmPassword()"> 
                                        <br><span id="hello" style="display: none"></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4" style="text-align: center;">
                            <button type="button" class="toggleEdit editField btn btn-primary">Edit</button>
                            <input class="editField btn btn-primary hide" value="Save" type="submit" name="register">
                            <input class="toggleEdit editField btn btn-default hide" onclick="location.reload();" value="Cancel" type="reset">
                        </div>
                    </div>
                </form>
            </div>
  </div>
<!--    wrapper-->



<!-- jQuery -->
<!-- <script src="../js/file.js"></script> -->

<!-- Bootstrap Core JavaScript -->
<!-- <script src="../js/bootstrap.min.js"></script> -->
    <script src="../js/contestant.js"></script>

        <script type="text/javascript">
            $('#load_cover').fadeOut();
            $('#load_cover').children().fadeOut();
        </script>



    
</body>

</html>

