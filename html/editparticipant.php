<?php
error_reporting(0);

include_once('../php/session.php');
include_once('../php/function.php');

if(isset($_SESSION['election_id'])) {
    $id = $_SESSION['election_id'];
    $election_id = unwrap($id);
}
else {
    header('Location: maindashboard.php');
}

require_once '../php/add_edit.php';
require_once '../php/photo.php';
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Edit Participants</title>

    <link href="../images/logo.png" rel="icon">
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">


    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">

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
        .addVoter:nth-child(odd){
            padding: 10px 0px;
            text-align: left;
        }
        @media (min-width: 768px) {
            .addVoter2{
                margin-right: -60px;
                /*padding-top: 50px;*/
            }
            .dropdown.menu{
                position: relative;
                display: inline-block;
            }
            .dropdown.menu .dropdown-menu {
                /*display: none;*/
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                padding: 12px 16px;
                z-index: 1;
            }
            .dropdown.menu .dropdown-menu li a:hover{
                background-color: #2A5D89;
                width: 125px;
                color:white;
            }
            #page-wrapper{
                min-height: 550px;
            }
        }
        #wrapper{
            background-color: rgba(51,122,183,0.1);
            overflow-x: hidden;
        }
        .label-default {
            padding-left: 27px;
            padding-right: 27px;
        }

        .report {
            background-color:#ffffff !important;
            padding:20px;
            margin-bottom: 50px;
        }

        table tr th {
            color: #333;
        }
        @media (max-width: 768px) {
            .addVoter2 input[type = 'button']{
                width: 50px;
                padding-left:1px;
                padding-right: 1px;

            }
            .addVoter2 input[type = 'submit']{
                width: 40px;
                padding-left: 4px;
                padding-right: 4px;
                margin-left: -10px;

            }


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
        table i.preview-img{
            left: 50px;
            top: -35px;
        }

    </style>
</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_once('navlinks.php');?>


    <div id="page-wrapper">
        <!-- /#page-wrapper -->

            <!-- container header-->
            <div class="row">
                <div class="page-title col-xs-12">
                    <h3>Edit Participants</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li><a href="<?php echo $_SESSION['adek_link'];?> "><?php echo $_SESSION['election_name'];?> </a></li>
                            <li class="active">Edit Participants</li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->


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


        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class=" col-xs-12 col-md-12 addVoter2">
                    <form class=" addButtons" style="float: right; display: none;width: 100%" enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                      <div class="row">
                          <div class="col-xs-5 col-md-3 addButtons" style="display: none;float: right; margin-right: -27px">
                              <input type="submit" value="Add" class="btn btn-primary">
                              <input type="button" value="Cancel" onclick="$('.addButtons').fadeOut(200,function(){$('.dropdown.menu').fadeIn();});" class="btn btn-danger">
                          </div>
                        <div class="col-xs-7 col-md-7    addButtons" style="float: right">
                            <input class="form-control form-inline" name="election_csv" type="file" id="fileInput" style="display: none">
                            <input class="form-control form-inline" name="email" type="email" placeholder="E-mail" id="emailInput" style="display: none">
                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
                        </div>
                      </div>
                    </form>
                    <div class="col-xs-12 col-md-2 dropdown menu" style="display: <?php echo $display_style; ?>; text-align: left;float: right; margin-right:10px">
                        <a style="font-weight: bolder" class="btn btn-md btn-primary dropdown-toggle" data-toggle="dropdown" href = "#">Add Voters &nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu" style=" background-color: #ffffff; padding:10px; margin-left: -20px">
                            <li class="btn addVoter" target="#emailInput" style="padding: 0px; text-align: center"><a style="padding: 0px; font-size: 16px"> Add with E-mails</a></li>
                            <li class="divider"style="padding: 0px"></li>
                            <li class="btn addVoter" target="#fileInput"style="padding: 0px; text-align: center"><a style="padding: 0px;font-size: 16px">Add with CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div><br><br>
            <?php
                if(!empty($errors)) {
                    echo '<div class="errors" style="color: red;">';
                    foreach($errors as $error) {
                        echo '<p>' . $error . '</p>';
                    }
                    echo '</div>';
                }
                else {
                    echo $success_message;
                }

                if(!empty($users)) {
            ?>
                <div class="table-responsive">
                    <table  id='table_1' class='table table-striped table-bordered table-hover' cellspacing='0' width='100%'>
                        <thead class='primary' >
                            <tr>
                                <th style="color: #ffffff">User</th>
                                <th style="color: #ffffff">Date Joined</th>
                                <th style="color: #ffffff">Status</th>
                                <th style="color: #ffffff">Email Address</th>
                                <th style="display: <?php echo $display_cell; ?>;"></th>
                            </tr>
                        </thead>
                        <tbody>
            <?php
                        foreach ($users as $row => $user) {
                            $user_name = htmlspecialchars($user['fname'] . ' ' . $user['lname']);
                            $date = date_create($user['joined_date']);
                            $user['email'] = htmlspecialchars(strtolower($user['email']));
                            $joined_date = date_format($date,"F j, Y, g:i a");
                            $get_id = $user['user_id'] . '_' . $election_id;
                            $status = ($user['status'] == 'contestant') ? 1 : 0;
                            $style = ($status) ? 'label-primary' : 'label-default';
                            echo <<<EOT
                           <tr id="$get_id">
                                <td style="position:relative;"><img src="{$user['picture_name']}" class="img-circle preview" height="50" width="50" ><span style="padding-left:10px; color:#337ab7;" id="userName">$user_name</span> </td>
                                <td style="padding-top: 20px">$joined_date</td>
                                <td style="padding-top: 20px; text-align:center" class="text-capitalize"><span class="label $style" style="font-size: 15px;" id="status">{$user['status']}</span></td>
                                <td style="padding-top: 20px">{$user['email']}</td>
                                <td style="padding-top: 20px; display: {$display_style};border:none;">
                                    <i data-toggle = "modal" data-target = "#myModal2"  id="deleteButton" class="fa fa-trash danger"></i><span id='user_id' style='display:none;'>{$user['user_id']}</span><span id='user_status' style='display:none;'>{$status}</span><span id='election_id' style='display:none;'>{$election_id}</span><span id='date_diff' style='display:none;'>{$date_diff}</span>

                                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <p class="deleteMsg" style = "font-size:15px; font-family:Arial"></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"  class="btn btn-danger confirmDelete" data-dismiss = "modal">Yes</button>
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

EOT;
                        }
            ?>
                        </tbody>
                    </table>
                </div>
            <?php
                }
                else {
                    echo <<<EOD
                        <div class="row" style="box-shadow: 0px 1px 4px 3px rgba(0,0,0,0.12)">
                            <div class="col-md-8 col-md-offset-2">
                                <p><h3>There are no participants (voters or contestants) in this election yet</h3></p>
                            </div>
                        </div>
EOD;
                }
            ?>
<!--    wrapper-->
        </div>
    </div>
    <!-- jQuery -->
    <!-- <script src="../js/jquery.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <!-- <script src="../js/bootstrap.min.js"></script> -->
    <script src="../js/jQuery.dataTables.js"></script>
     <script src="../js/file.js"></script>
    <script src="../js/dummy.js"></script>
    <script type="text/javascript">
        // $('.showForm').click(function(){
        //     var add= $(this).parents('.addVoter')
        //     add.fadeOut(500,function(){
        //         add.siblings().fadeIn(500);
        //     });
        // });
        $('.fa-trash').click(function(){
            var username = $(this).parent().siblings().children('#userName').html();
            var status = $(this).parent().siblings().children('#status').html();
            var user_id = $(this).siblings('#user_id').html();
            var user_status = $(this).siblings('#user_status').html();
            var election_id = $(this).siblings('#election_id').html();
            var date_diff = $(this).siblings('#date_diff').html();
            $('.confirmDelete').attr("onclick","deleteParticipant("+user_id+", " + election_id + ", " + date_diff + ", " + user_status + ")");
            $('.deleteMsg').html('Are you sure you want to remove the <span>' + status + '</span> <strong class="text-primary">' +username+'</strong> from this election ?');
        });
        $('.addVoter').click(function(){
            $(this).parents(".dropdown.menu").hide();
            var add= $($(this).attr('target'));
            add.siblings().fadeOut(300,function(){
                add.fadeIn(200);
                $('.addButtons').fadeIn();
            });
        });
        $('#table_1').dataTable();
        // image preview function
            $('img.preview').hover(function(){
                    var image = $(this);
                    image.parent().append('<i class="preview-img" style="display:none"><img src='+image.attr('src')+' width="80px" height="100px" </i>');
                    $('i.preview-img').fadeIn();
                },function(){
                    $(this).siblings().remove('i.preview-img');
                }
            );


            $('img.preview').bind('click', function(){
                var imagesrc = '<img src="'+$(this).attr('src')+'" width="98%" height="480px" style="">';
                $('.content').html(imagesrc);
                $('.blanket').fadeIn(400,function(){
                    $('.content').animate({'top':'5%'});
                });
            });
    </script>
</body>

</html>