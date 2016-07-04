<?php
include_once("../php/connection.php");
include_once('../php/photo.php');
include_once('../php/post_news.php');
include_once('../php/view_contestant.php');
include_once("../php/vote.php");
include_once("../php/database.php");
//check if election exists
$election_id = $_SESSION["election_id"];
$user_id = user_id($myemail);
$election = getElectionDetails($election_id);
$joined = getAllMembers("joined",["*"],["user_id","=",$user_id],0,"AND",["election_id","=",$election_id]);
if(count($election) == 0 | count($joined) == 0){
    //that means the election does not exist or the user is not joined to the election
    header("Location:maindashboard.php");
}
// check if contestant or voter
$adekagun="Voter";
if(attached("contestants",user_id($myemail),$_SESSION["election_id"])==="contestants"){
    $adekagun='Contestant';
}
$_SESSION['adek_link'] = 'election_detailsNews.php?key='. $_SESSION['election_key'];
$_SESSION['adek_status'] = $adekagun;


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <style type="text/css">

        .numbers {
          /*  border-style: ridge;*/
            border-width: 2px;

            padding: 0px 0px;
            width: 30px;
            text-align: center;
            font-family: Arial;
            font-size: 20px;
            /*font-weight: bold;*/
            font-style: inherit;
            color: #000000;
        }
        .title {
            padding: 0px;
            width: 45px;
            text-align: center;
            font-family: Arial;
            font-size: 10px;
            font-weight: normal;
            color: darkgrey;
            background: transparent;

        }

        #table {
            box-shadow: none;
            border:hidden;
            margin: 0;
            position: relative;
            top: 0px;
            left: 0px;
        }
        #page-wrapper{
            /*background:rgba(208, 146, 57, 0.2);*/
            background-color: floralwhite;
            height: 100%;
        }
    .admin i.preview-img{
        position: absolute;
        top: 0px;
        left: 70px;
        z-index: 90000;
        padding: 4px 4px 8px 4px;
        background: #fff;
        box-shadow: 2px 2px 6px 2px rgba(0,0,0,0.12);
        opacity: 1;
    }
    </style>



    <script type="text/javascript">
        // var vote_link = "";
        var current="Election Has Closed";
        var current1 = "";
        var current2 = "<span class='text-success'>Election Has Started</span>";
        var startyear=<?php echo $start_year;?>;
        var startmonth=<?php echo $start_month;?>;
        var startday=<?php echo $start_day;?> ;
        var starthour=<?php echo $start_hour;?> ;
        var startminute=<?php echo $start_minute;?> ;
        var stz=+1;

        //    DO NOT CHANGE THE CODE BELOW!
        var smontharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

        function countdown(syr,sm,sd,shr,smin){
            var election_end = new Date('<?php echo $election_end_date." ".$election_time_to;?>');
            stheyear=syr;sthemonth=sm;stheday=sd;sthehour=shr;stheminute=smin;
            var stoday=new Date();

            var stodayy=stoday.getYear();
            if (stodayy < 1000) {stodayy+=1900;}
            var stodaym=stoday.getMonth();
            var stodayd=stoday.getDate();
            var stodayh=stoday.getHours();
            var stodaymin=stoday.getMinutes();
            var stodaysec=stoday.getSeconds();
            var stodaystring1=smontharray[stodaym]+" "+stodayd+", "+stodayy+" "+stodayh+":"+stodaymin+":"+stodaysec;
            var stodaystring=Date.parse(stodaystring1)+(stz*1000*60*60);
            var sfuturestring1=(smontharray[sm-1]+" "+sd+", "+syr+" "+shr+":"+smin);
            var sfuturestring=Date.parse(sfuturestring1)-(stoday.getTimezoneOffset()*(1000*60));
            var sdd=sfuturestring-stodaystring;
            var sdday=Math.floor(sdd/(60*60*1000*24)*1);
            var sdhour=Math.floor((sdd%(60*60*1000*24))/(60*60*1000)*1);
            var sdmin=Math.floor(((sdd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
            var sdsec=Math.floor((((sdd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
            if(sdday<=0&&sdhour<=0&&sdmin<=0&&sdsec<=0){
              document.getElementById('written').style.display = 'block';
              document.getElementById('written').innerHTML = current2;
              var table = document.getElementById('table');
              table.style.display = 'none';
              var vote_link = "voting.php";
              document.getElementById("vote_link").setAttribute("href", vote_link);
              // document.getElementById("link").setAttribute("class", 'active');
              // document.getElementById("link2").setAttribute("href", '../html/electionResult.php');
              // document.getElementById("link2").setAttribute("class", 'active');


            }else {
                
                document.getElementById('write').innerHTML = current1;
                document.getElementById('count2').style.display="none";
                document.getElementById('dday').innerHTML=sdday;
                document.getElementById('dhour').innerHTML=sdhour;
                document.getElementById('dmin').innerHTML=sdmin;
                document.getElementById('dsec').innerHTML=sdsec;
                setTimeout("countdown(stheyear,sthemonth,stheday,sthehour,stheminute)",1000);
            }
        }

        function checkElectionEnd(){
            var electionEnd = new Date('<?php echo $election_end1;?>');
            var now_date = new Date();
            var hasvoted = '<?php echo $hasvoted;?>';
            // var link = document.getElementById('link');

            if(hasvoted==1){
                // link.style.display = 'none';
                document.getElementById('written').innerHTML = "<span class='text-success fa fa-check-circle'></span>You have already voted in this election";
            }

            if(electionEnd < now_date){
                document.getElementById('written').innerHTML = "Election Has Closed";
                // link.style.display = 'none';
            }
        }

    </script>
    <script type="text/javascript">
        function contestants(id){
            window.location = "viewContestantProfile.php?key=" + id;
        }
    </script>
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Election Details</title>

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
<body onload="countdown(startyear,startmonth,startday,starthour,startminute); checkElectionEnd()">


<div id="wrapper">

    <!-- Navigation -->

    <?php include_once('navlinks.php');?>



    <div id="page-wrapper">
    <!-- /#page-wrapper -->
    
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
            <!-- container header-->
            <div class="row">
                <div class="page-title col-md-12">
                    <h3>Election Details</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li class="active"><?php echo $_SESSION['election_name'];?></li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->

            <div class="row">
                <div class="col-md-8">
                    <div class="row ">
                        <div class="col-md-7">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="text-align: center ">Administrator's Details</h3>
                                </div>
                                <div class="panel-body admin">
                                    <?php echo $election_admin_detail.$election_admin_details;?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="text-align: center ">Election Details </h3>
                                </div>
                                <div class="Adelne panel-body table-responsive" style="text-align: left ;padding: 0 5px">
                                    <!-- <br> -->
                                        <h4 id="written" style="margin-top: 5px;display: none"></h4>
                                        <table id="table">
                                            <tr>
                                                <td colspan="12"><label>Election Starts in:</label><i id="write"></i>  <div class="numbers" id="count2" style="padding: 1px; "></div></td>

                                            </tr>
                                            <tr id="spacer1">
                                                <!-- <td align="center" ><div class="title" ></div></td> -->
                                                <td align="center" ><div class="numbers" id="dday"></div></td>
                                                <td align="center" ><div class="numbers" id="dhour"></div></td>
                                                <td align="center" ><div class="numbers" id="dmin"></div></td>
                                                <td align="center" ><div class="numbers" id="dsec"></div></td>
                                                <td align="center" ><div class="title" ></div></td>
                                            </tr>
                                            <tr id="spacer2">
                                                <!-- <td align="center" ><div class="title" ></div></td> -->
                                                <td align="center" ><div class="title" id="days">Days</div></td>
                                                <td align="center" ><div class="title" id="hours">Hours</div></td>
                                                <td align="center" ><div class="title" id="minutes">Minutes</div></td>
                                                <td align="center" ><div class="title" id="seconds">Seconds</div></td>
                                                <td align="center" ><div class="title" ></div></td>
                                            </tr>
                                        </table>

                                        <p><?php echo $election_details_test;  ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: center;">
                        <div class="col-xs-12 col-md-12  " style="height: auto">
                            <div class="panel panel-warning" >
                                <div class="panel-heading" >
                                    <h3 class="panel-title" style="text-align: center ">CONTESTANTS</h3>
                                </div>
                                <div style="text-align: left; max-height:320px; overflow-y:auto; overflow-x:hidden;padding-top:10px";>
                                    <style>
                                        .panel > .panel-heading {
                                            background-image: none;
                                            background-color: rgba(208, 146, 57, 0.84);
                                            opacity: 0.75;
                                            color: black;
                                        }
                                        .panel-title{
                                            font-size: 15px;
                                            font-weight: bold;
                                        }
                                        div.img {
                                            margin-bottom:20px;
                                            padding: 5%;
                                            float: left;
                                            width: 100%;
                                        }

                                        div.desc {
                                            text-align: center;
                                        }
                                        div.img {
                                            border: 1px solid #ccc;
                                            float: left;
                                            text-overflow: ellipsis;
                                            overflow: hidden;
                                            position: relative;
                                        }
                                        div.img img {
                                            width: 100%;
                                            height: 200px;
                                        }
                                        div.view-profile {
                                            padding-top: 50%;
                                            text-align: center;
                                            text-overflow: ellipsis;
                                            overflow: hidden;
                                            right: 100%;
                                            position: absolute;
                                            top: 0%;
                                            color: transparent;
                                            background: transparent;
                                            width: 100%;
                                            opacity: 1;
                                            height:100%;
                                            transition: right 0.4s,background 0.5s, color 0.7s;
                                        }
                                        .img:hover{
                                            background: #fff;
                                        }
                                        .img:hover .desc b,
                                        .img:hover .desc small{
                                            color:#888;
                                        }
                                        .img:hover img{
                                            opacity: 0.7;
                                        }
                                        .img:hover .view-profile{
                                            right: 0;
                                            background: rgba(0,0,0,0.15);
                                            color: #fff;
                                            cursor: pointer;
                                        }
                                        .desc{
                                            text-align: center;
                                            text-overflow: ellipsis;
                                            overflow: hidden;
                                        }
                                        .img .view-profile .btn{
                                            color: transparent;
                                            background: transparent;
                                            border: solid 1px transparent;
                                            transition:all 0.6s;
                                            transition-delay: 0.2s;
                                        }
                                        .img:hover .view-profile .btn{
                                            color:#fff;
                                            background: rgba(0,0,0,0.3);
                                            border: solid 1px #ccc;
                                            width: 80%;
                                            cursor: pointer;
                                            font-weight: bold;
                                        }
                                        .img:hover .view-profile .btn:hover{
                                            color: #777;
                                            background: #eee;
                                            transition:background .2s,color .4s,border .4s;
                                        }
                                    </style>
                                    <?php
                                    if(!empty($contestants_array)) {
                                        for ($efe = 0; $efe < count($contestants_array); $efe++) {
                                            echo $contestants_array[$efe];
                                        }
                                    }
                                    else{
                                        echo "<h3>"."Contestants are yet to register for this election."."</h3>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4  " >
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-align: center">News and Updates</h3>
                        </div>
                        <div class="panel-body">
                            <p><?php echo $view_posted_news;?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- wrapper-->

</body>
</html>