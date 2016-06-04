<?php
include_once("../php/vote.php");
include_once('../php/photo.php');
$message2="";
if(isset($_GET['key'])){
    $message2=$_GET['key'];
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
       
    <title>E-voting | Results</title>

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
    #page-wrapper{
        background: rgba(0,0,0,0.05);
        min-height: 700px;   
        padding :0px 100px;
    }
    #election_time_left>label{
        width: 100%;
        margin: 0;
    }
    #election_time_left>label>h4{
        text-align: center;
        width: 100%;
        color: #fff;
    }
    #spacer1>td{
        font-size: 40px;
        border-bottom: none;
    }
    td{
        border-right:solid 1px #2A5D89;
        border-bottom:solid 1px #2A5D89;
        background: rgba(0,0,0,0.05);
    }/*
    .contestants img{
        border: solid 1px #ccc;
    }
    .contestants input{
        cursor: pointer;
    }
    .contestants{
         border:solid 1px #ccc;
         height: 250px;
         text-align: center;
         background: #fff;
         transition: box-shadow .2s;
         padding: 5px;
         border-radius: 2px;
    }
    .contestants:hover{
        box-shadow: 2px 2px 6px #ddd;
        cursor: default;
    }*/
    #page-wrapper>.container-fluid>.row{
        background: #fff;
        box-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        padding-top: 20px;
    }
    h1{
        color: #fff;
    }
    .panel-body{
        color: #999;
    }
    .panel-body h3{
        color: #444;
        margin-top: 20px;
    }
    table{
        border: solid 1px #ccc;
        border-collapse: inherit;
    }
    input[type='radio']:not(old){
        width: 28px;
        height: 30px;
        padding : 0;
        margin: 10px 0 0 0;
        opacity: 1;
        cursor: pointer;
    }
    label#option{
            display: inline-block;
            position: absolute;
            top: 40px;
            left: -2px;
            width: 30px;
            height: 45px;
            color: transparent;
            background: none;
            transition: background 0.2s;
    }
    input[type='radio']:not(old):checked + label#option{
        background: url('../images/voting/checks.jpg') center no-repeat;
        top: 0;
    }
    .panel-default>.panel-body{
        min-height: 300px;
        max-height: 300px;
        overflow: hidden;
        overflow-y:auto;
        overflow-x: hidden;
        padding-top: 5px; 
        margin-top: 0;
    }
    .row.contestant{
        margin: 0 -10px 5px -10px;
        cursor: pointer;
        border: solid 1px #eee;
        margin-bottom: 5px;
        position: relative;
    }

    .row.contestant-details{
        margin: 0 -10px 5px -10px;
        cursor: pointer;
        min-height: 50px;
        margin-top: 0px; 
        width: 89%;
        margin-left: 0px;
        display: none;
        position: absolute;
        background: transparent;
        z-index: 3;
        padding: 0
    }
    .row.contestant>.col-xs-8{
        padding-top: 5px;
    }
    .row.contestant>.col-xs-2>img{
        margin: 5% 0px 5% -15px;
        border: solid 1px #eee;
        padding: 2px;
        border-radius: 2px;
        background: #fff;
        width: 40px;
        height: 50px;
    }
    .row.contestant-details>.col-xs-12>.col-xs-8{
        padding-top: 5px;
    }
    .row.contestant-details>.col-xs-12>.col-xs-2>img{
        margin: 5% 0px 5% -10px;
        border: solid 1px #eee;
        padding: 2px;
        border-radius: 2px;
        background: #fff;
        width: 40px;
        height: 50px;
    }
    .row.contestant-details>.col-xs-12{
        position: relative;
        top: 0px;
        background: rgba(0,0,0,0.3);
        left: 0%;
        padding:3px 0 0 0;
        z-index:2;
        width: 100%;
        color: #fff
    }
    .row.contestant:hover{
        box-shadow: 0px 2px 4px rgba(0,0,0,0.2);
        padding: 0;
    }
    .row.contestant.active{
        background: rgba(232,232,232,0.6);
        box-shadow: 0px 2px 4px rgba(0,0,0,0.14);
    }
    .panel-default ::-webkit-scrollbar-thumb:hover{
        background-color: #666;
        border-radius: 4px;
    }
    .panel-default ::-webkit-scrollbar-thumb{
        background: rgba(100,100,100,0.4);
        height: 20px;
    }
    .panel-default ::-webkit-scrollbar{
        width: 5px;
        background: rgba(200,200,200,0.6);
    }
    .panel-default .panel-heading{
        background-color: rgba(208, 146, 57, 0.84);
        text-align: center;
        opacity: 0.75;
        color: black;
    }
</style>
<script type="text/javascript">
    function check_result(){
        var result_display = '<?php echo $result_display;?>';
        var election_end1 = new Date('<?php echo $election_end1;?>');
        var election_start = new Date('<?php echo $electionStartDateTemp;?>');
        var nowDate = new Date();
        var page = document.getElementById('page');
        var msg = document.getElementById('msg');
        var hasVoted = '<?php echo $hasvoted;?>';
        var message = '<?php echo $message2;?>';
        if (election_start > nowDate){
            page.style.display = 'none';
            msg.innerHTML = 'Voting is yet to commence. It will commence on '+election_start;
            msg.setAttribute('class','alert alert-');
        }else{

            if(result_display === "during"){
                page.style.display = 'block';
                if (hasVoted==0) {
                    var vote_link = "voting.php";
                    document.getElementById("vote_link").setAttribute("href", vote_link);
                    msg.innerHTML = 'Voting has commenced for this election. Cast your vote now!!!';
                    msg.setAttribute('class','alert alert-success');
                }else{
                    msg.innerHTML = '<span><i class="fa fa-check-circle text-success"></i>You have already voted in this election.</span>';
                    msg.setAttribute('class','alert alert-success');
                }
                // page1.style.display = 'none';
            }else if(result_display === "after"){
                page.style.display = 'none';
                if (hasVoted==0) {
                    var vote_link = "voting.php";
                    document.getElementById("vote_link").setAttribute("href", vote_link);
                    msg.innerHTML = 'Voting has commenced for this election. Cast your vote now!!!<br>Election results will be available after the election has been concluded.';
                    msg.setAttribute('class','alert alert-success');
                }else{
                    msg.setAttribute('class','alert alert-danger');
                    msg.innerHTML = 'Election results will be available after the election has been concluded.';                
                }
                $('#body').css('margin-top','40px');
                // page1.style.display = 'block';
            }
                if(election_end1 < nowDate){
                    page.style.display = 'block';
                    msg.innerHTML = 'Election has been concluded.';
                    msg.setAttribute('class','alert alert-danger');
                    $('#body').css('margin-top','0px');
                    // page1.style.display = 'none';
                
            //  if(hasVoted == 1 && message!=='') {
            //     document.getElementById('message').innerHTML = message;
            // }else{
            //      document.getElementById('message').innerHTML = 'You have already voted in this election';
            // }
            }

        }



    }
</script>
</head>
<body onload="check_result()">

<div class="blanket">
    <i class="btn btn-default fa fa-close" onclick="$('.blanket').fadeOut();"></i>
    <div class="content">

    </div>
    
</div>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_once('navlinks.php');?>
                
    <div id="page-wrapper">
    <!-- /#page-wrapper -->
        <div class="container-fluid">
            <div class="row" id="body">
                <div class="page-title col-md-12">
                    <h3>Election Results</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li><a href="<?php echo $_SESSION['adek_link']?>"><?php echo $_SESSION['election_name'];?></a></li>
                            <li class="active">Election Results</li>
                        </ol>
                    </div>
                </div>
                <!-- <h2 id="message"> </h2> -->
                     <div class='col-md-12'>
                        <h3 id="msg"></h3>
                     </div>
                    <div class='col-md-12' id="page" style="display:none">
                        <div class="row">
                            <?php 
                                echo $string_election;
                                for($k=0;$k<count($string_result_array);$k++){
                                    echo $string_result_array[$k].'<p>';
                                }
                            ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</div>

        <!-- jQuery -->
        <!-- <script src="../js/jquery.js"></script> -->

        <!-- Bootstrap Core JavaScript -->
        <!-- <script src="../js/bootstrap.min.js"></script> -->

        <!-- Custom JavaScript -->
        <!-- <script src="../js/file.js"></script> -->
</body>
</html>