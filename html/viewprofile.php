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

        <!-- /#page-wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                    <h3 class="page-header"  style="text-align: center;">
                        <?php echo $user_nickname_here;?>
                        - Details
            <!-- <button class="btn btn-danger btn-sm pull-right" onclick="window.history.back();">Back</button> -->
                    </h3>
           <!--  </div> -->
            </div><!-- /#page-wrapper -->
            <div class="row" id="updateProfile">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                    <div class="row profile">
                        <div class="col-xs-12 col-md-4" id="pictureClick">
                            <?php 
                                echo "<img id='image' class='image-responsive' src='$user_picture_here' alt='$picture_name' width='100%' height='300px'><br>";
                            ?>
                            <input type="file" style="width: 100%" name="image" class="editField hide btn btn-default hide pictureChange" id="pictureChange" onchange="showPhoto(this)">
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
                                        <strong>Email Address: </strong>
                                    </div>
                                    <div class="col-xs-9 col-md-9">
                                        <small><?php echo $myemail; ?></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <strong>Contesting for: </strong>
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
                                <div class="row">
                                    <div class="col-xs-3 col-md-3"><strong>Citation</strong></div>
                                    <div class="col-xs-9 col-md-9">
                                        <small>
                                            <?php
                                            if(!empty($user_citation_here)) {
                                                echo $user_citation_here;
                                            }else{
                                                echo "None";
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4" style="text-align: center;">
                            <input class="btn btn-danger" value="Step Down" type="submit" name="delete">
                            <button type="button" class="toggleEdit editField btn btn-primary">Edit</button>
                            <input class="editField btn btn-primary hide" value="Save" type="submit" name="submit">
                            <input class="toggleEdit editField btn btn-default hide" value="Cancel" type="reset">
                        </div>
                    </div>
                </form>
            </div>
    <!-- edit form column -->
    <!-- <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
      
      <h3 style="padding-left:55px;border-bottom:1px solid">Contestant Personal Information</h3><br>
      <form class="form-horizontal" enctype="multipart/form-data" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <div class="form-group"><span class="error"><?php echo $update_election_message;?></span>
          <label class="col-lg-3 control-label">first name:</label><?php echo $user_fname; ?>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">last name:</label><?php echo $user_lname;  ?>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Email:</label>
		  <?php echo $myemail; ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label><?php echo $username; ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Post:</label><?php echo $user_contestant_post; ?>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Nickname:</label>
            <?php
            echo '<div class="col-md-8">';

            $edit_nickname_here="\"$user_nickname_here\"";
            $id1="\"space\"";
            $edit_nick_name_nameatt = "\"nick_name\"";
            echo '<div  id="dem">';
            echo $user_nickname_here;
            echo "</div>";
            echo "<a href='#' id='nick' onclick='edit(0)' >Edit</a>";
            echo "</div>";

            ?>

        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Manifesto:</label>
            <?php
            echo '<div class="col-md-8" id="replace"><ul>';
                for($i=0;$i<$no_of_manifesto_point;$i++){
                    $id="\"dem$i\"";
                    $edit_manifestos="\"$manifestos[$i]\"";
                    $edit_manifestos_nameatt="\"manifesto$i\"";
                    echo "<li id=$id> $manifestos[$i] </li>";
 
                }
            echo "<a href='#' id='manifesto' onclick='edit($no_of_manifesto_point)'>Edit</a>";
            echo "</ul></div>";
            ?>

          </div>
          <div class="form-group" style="margin-top:50px;margin-left:-3px;">
            <label class="col-md-3 control-label">Picture: </label>
                        <p class="help-block">
                            <?php
                            echo "<img src='$user_picture_here' alt='$picture_name' width='40px' height='40px'>";
                            echo $picture_name;
                            ?>
                            <br>
                            <a href="#" onclick='changePicture()'>Change picture</a>
                            <div id="pictureClick">

                            </div>
                            Pls ensure the file being uploaded is clear picture of yourself.
                            <br><span class="error"> <?php echo $uploadErr; ?></span>
                            <span class="error"> <?php echo $success; ?></span>

                        </p>
          </div>
          <div class="form-group" style="margin-top:30px;margin-left:-3px">
            <label class="col-md-3 control-label">Citation: </label>
                        <p class="help-block">
                            <?php
                            if(!empty($user_citation_here)) {
                                echo $user_citation_here;
                            }else{
                                echo "None";
                            }
                            ?><br>
                        Pls ensure the file being uploaded is a pdf file.
                        </p>
         </div>
    </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">

            <input class="btn btn-default" value="Step Down" type="submit" name="delete">
            <input class="btn btn-primary" value="Save" type="submit" name="submit">
            <span></span>
            <input class="btn btn-default" value="Cancel" type="reset">

          </div>
        </div>
      </form>
    </div> -->
  </div>
<!--    wrapper-->


<!-- jQuery -->
<!-- <script src="../js/jquery.js"></script> -->


<!-- jQuery -->
<!-- <script src="../js/file.js"></script> -->

<!-- Bootstrap Core JavaScript -->
<!-- <script src="../js/bootstrap.min.js"></script> -->
    <script src="../js/contestant.js"></script>

</body>

</html>

