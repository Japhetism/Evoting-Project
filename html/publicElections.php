
<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/24/16
 * Time: 3:38 PM
 */
include_once('../php/session.php');
include_once('../php/connection.php');
include_once("../php/database.php");
include_once('../php/photo.php');
require_once('../php/function.php');
include_once('../php/public.php');

$this_admin=$submit=$admin_picture='';
//get election_id
$election_id=unwrap($_GET['key']);
//check if the election exists and public
$check=$connection1->prepare("SELECT * FROM election WHERE election_id='$election_id' AND (privacy='11' OR privacy='12')");
$check->execute();
$check->setFetchMode(PDO::FETCH_ASSOC);
$this_election = $check->fetchAll();
if(empty($this_election) && $error_msg == ''){
    //redirect to maindashboard
    header("Location:maindashboard.php");
}else{
    $this_election=$this_election[0];
    $privacy_degree=$this_election['privacy'];
    $_SESSION['election_id']=$this_election['election_id'];
    //get user_id
    $user_id=user_id($myemail);
    $_SESSION['user_id']=$user_id;
    $attachment = ['joined','request'];
    for($i = 0;$i < 2; $i++){
        $attach = attached($attachment[$i],$user_id,$_SESSION['election_id']);
        if($attach != null){
            break;
        }
    }
    if($attach == 'joined'){
        $error_msg ='<span class="error">You have already joined this election. Reload your main
                                            browser to see the effect.
                         </span>';
    }elseif($attach == 'request'){
        $error_msg ='<span class="error">Your request has been processed. Reload your main
                                            browser to see the effect.
                         </span>';
    }

    //get admin details
    $admin_id=$this_election['user_id'];
    $admin=$connection1->prepare("SELECT * FROM users WHERE user_id='$admin_id'");
    $admin->execute();
    $admin->setFetchMode(PDO::FETCH_ASSOC);
    $admin=$admin->fetchAll();
    $this_admin=$admin[0];
    $dir='../images/users/'.$this_admin['picture_name'];
    $admin_picture='<img src='.$dir.' class="img-responsive" width="200px" height="200px" >';
    //decide kind of submit button
    if(substr($privacy_degree,1,1)==='1'){
        $str='Voter authentication is required to be part of this election.
         Click the Request button to send a request to the admin of this election.';
        $submit='<input class="btn btn-warning" type="submit" name="request" value="Send Request"><br>';
    }elseif(substr($privacy_degree,1,1)==='2'){
        $str='This election is open. Click the join button to be part of this election.';
        $submit='<input class="btn btn-warning" type="submit" name="join" value="Join"><br>';

    }
}


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



    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for navbar-->
    <link href="../css/nav.css" rel="stylesheet">

    <style type="text/css">
        img{
            padding: 5px 5px 30px 5px;
            background: #fff;
            box-shadow: 0px 0px 3px rgba(0,0,0,0.2);
        }
    </style>

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="margin-top: 0">

<div id="wrapper">
    <div id="page-wrapper">
        <!-- /#page-wrapper -->
        <!-- Modal -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $str;?></h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 details">
                    <div class="row">
                        Election Pin: <label><?php echo($this_election['election_pin']);?></label><br>
                        Election Name: <label><?php echo($this_election['election_name']);?></label>
                        <div class="col-md-8">
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 details">                
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 style="margin-bottom: 0">Admin Details</h3><hr style="margin-top: 5px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <?php echo $admin_picture;?>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <div class="row">
                                <label>Name: </label><?php echo(strtoupper($this_admin['fname'])).'  '.$this_admin['lname']?>
                            </div><br>
                            <div class="row">
                                <label>Email ID: </label><?php echo($this_admin['email'])?>
                            </div><br>
                            <div class="row">
                                <label>Phone Number: </label>
                                    <?php echo($this_admin['phone'])?>
                            </div><br>
                            <div class="row">
                                <label>Gender: </label><?php echo(ucwords($this_admin['gender']));?>
                            </div><br>
                        </div>
                    </div>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="col-xs-12 form-inline" style="text-align: center; ">
                        <?php if($error_msg=='') echo($submit); echo($error_msg);?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script src="../js/file.js"></script>

</body>

</html>