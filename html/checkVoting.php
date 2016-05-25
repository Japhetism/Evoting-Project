<?php
include_once("../php/vote.php");

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
          
    <script type="text/javascript">
        var current="Election Has Closed";   
        var current1 = "Election Starts in";
        var startyear=<?php echo $start_year;?>    
        var startmonth=<?php echo $start_month;?>       
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
               window.location = "../html/voting.php";
            }
            else {
                document.getElementById('write').innerHTML = current1;
                document.getElementById('count2').style.display="none";
                document.getElementById('dday').innerHTML=sdday;
                document.getElementById('dhour').innerHTML=sdhour;
                document.getElementById('dmin').innerHTML=sdmin;
                document.getElementById('dsec').innerHTML=sdsec;
                setTimeout("countdown(stheyear,sthemonth,stheday,sthehour,stheminute)",1000);
            }
        }


        function check(){
            var start_date = new Date('<?php echo $election_start_date." ".$election_time_from;?>');
            var end_date = new Date('<?php echo $election_end_date." ".$election_time_to;?>');
            var today_date = new Date();
            var page = document.getElementById('page');
            var tables = document.getElementById('tables');
            var wee = document.getElementById('wee');
            if(start_date > today_date){
                page.style.display = 'none';
                wee.style.display = 'none';
                tables.style.display = 'block';
            }else if(start_date < today_date && end_date < today_date){
                page.style.display = 'none';
                table.style.display = 'block';
            }else{
                tables.style.display = 'none';
                window.location = '../html/voting.php';
            }
         }


    </script>

    <title>Dashboard</title>

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
<body onload="countdown(startyear,startmonth,startday,starthour,startminute); check()">

<div id="wrapper">

    
    <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" id="blanketLink">
                    <i class="fa fa-play-circle"></i>  <span class="light">E -</span> Voting
                </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown userActions">
                    <a href="#" class="dropdown-toggle showActions" id="showActions" data-toggle="dropdown"><i><img src="../images/voting1.jpg" width="30px" height="30px" style="border: white 2px solid;border-radius:100%;"></i><?php echo $myemail;?><i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu userOptions" id="userOptions">
                        <li>
                            <a href="#"><i class="fa fa-user"></i> Edit profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../php/logout.php"><i class="fa fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav side-nav sidebar" id="MainMenu">
                    <li class="col-md-12 ">
                        <div class="row userProfile"  id="userActions">
                            <p class="col-md-4">
                                <img src="../images/voting1.jpg" alt="???" width="60px" height="60px" style="border-radius:10px;">
                            </p> 
                            <div class="col-md-8  userActions"  style="padding-top:25px;">
                                <a href="#" id="showActions" class="showActions dropdown-toggle" data-toggle="dropdown" >username
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu drop userOptions" id="userOptions">
                                    <li>
                                        <a href="#"> <i class="fa fa-fw fa-user"></i>Edit profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="../php/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="active" id="1" >
                            <a href="maindashboard.php" class="active"><i class="fa fa-dashboard"></i>
                            Dashboard</a>
                    </li>
                    
                    <li class="active">
                        <a data-target="#demo3" class="active" data-toggle="collapse" data-parent="#MainMenu">
                        <i class="fa fa-pencil-square-o"></i>Manage Elections<i class="fa fa-angle-left pull-right" style="width:10px;"></i></a>
                        <ul class="open collapse in tableLinks" id="demo3">
                            <li class="inactive" id="demo3_1" target="table_1" >
                                <a class="active" data-toggle="collapse" data-target="#SubMenu">
                                    Created Elections<i class="btn pull-right success" >3</i>
                                </a>
                                <ul class="nav collapse" id="SubMenu">
                                    <li>
                                        <a href="#" class="inactive" data-parent="#SubMenu1">
                                        Post News
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="inactive" data-parent="#SubMenu1">Update Election</a>
                                    </li>
                                    <li>
                                        <a href="#" class="inactive">Edit Participants</a>
                                    </li>
                                    <li>
                                        <a href="#" class="inactive" data-parent="#SubMenu1">View Results</a>
                                    </li>
                                </ul>
                            </li>   
                            <li class="active1" target="table_2" id="demo3_2" >    
                                <a href="#" data-target="#SubMenu1" data-toggle="collapse" class="active"> Joined Elections<i class="btn pull-right primary" >1</i></a>
                                <ul class="open nav collapse in" id="SubMenu1">
                                    <li class="active1">
                                        <a href="#" class="active" data-parent="#SubMenu1">
                                            Election Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="registercandidate.php" class="active" data-parent="#SubMenu1">Register as Contestant</a>
                                    </li>
                                    <li>
                                        <a href="viewprofile.php" class="active">View Profile</a>
                                    </li>
                                    <li>
                                        <a href="checkVoting.php" class="active" data-parent="#SubMenu1">Vote</a>
                                    </li>
                                    <li>
                                        <?php echo $result_tag1 ?>
                                        <?php echo $result_tag2 ?>
                                    </li>
                                </ul>
                            </li> 
                            <li target="table_3" id="demo3_3" >    
                                <a href="#" class="active" > Pending Invites<i class="btn pull-right warning" >2</i></a>
                            </li>   
                            <li target="table_4" id="demo3_4" >    
                                <a href="#" class="active" > Pending Requests<i class="btn pull-right danger" >3</i></a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="active" >
                        <a href="createelection1.php" data-target="#demo4" class="active" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus"></i>Create an Election<i class="fa fa-angle-left pull-right" ></i></a>
                            <ul class="collapse" id="demo4">
                                <li>
                                    <a href="createelection1.php" class="active">Step 1<i class="fa fa-info-circle pull-right" ></i></a>
                                </li>
                                <li>
                                    <a href="#" class="inactive">Step 2<i class="fa fa-pencil-square-o pull-right" ></i></a>
                                </li>
                                <li>
                                    <a href="#" class="inactive">Step 3<i class="fa fa-check-circle pull-right" ></i></a>
                                </li>
                            </ul>
                    </li>
                    <li class="active">
                        <a href="#" class="active" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-user-plus"></i>Join an election
                        </a>
                    </li><!-- 
                    <li class="active sideBarSturvs">
                        <a class="active"href="#">Joined Election</a>
                    </li>
                    <li class="active sideBarSturvs">
                        <a class="active"href="#">Election Details</a>
                    </li>
                    <li class="active sideBarSturvs">
                        <a class="active" href="registercandidate.php">Register As A Contestant</a>
                    </li>
                    <li class="active sideBarSturvs">
                        <a class="inactive" href="#">View Profile (Contestants only)</a>
                    </li>
                    <li class="active sideBarSturvs">
                        <a class="inactive" href="voting.php">Vote</a>
                    </li>
                     -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>


    <div id='tables' style="display: none;">
<table id="table" border="0" >
    <tr>
        <td align="center" colspan="6"><label><h2 id='write'></h2></label><div class="numbers" id="count2" style="padding: 10px; "></div></td>
        
    </tr>
    <tr id="spacer1">
        <td align="center" ><div class="title" ></div></td>
        <td align="center" ><div class="numbers" id="dday"></div></td>
        <td align="center" ><div class="numbers" id="dhour"></div></td>
        <td align="center" ><div class="numbers" id="dmin"></div></td>
        <td align="center" ><div class="numbers" id="dsec"></div></td>
        <td align="center" ><div class="title" ></div></td>
    </tr>
    <tr id="spacer2">
        <td align="center" ><div class="title" ></div></td>
        <td align="center" ><div class="title" id="days">Days</div></td>
        <td align="center" ><div class="title" id="hours">Hours</div></td>
        <td align="center" ><div class="title" id="minutes">Minutes</div></td>
        <td align="center" ><div class="title" id="seconds">Seconds</div></td>
        <td align="center" ><div class="title" ></div></td>
    </tr>
</table>
</div>

<!--    <div class = "row">-->


<div class="wee" id="wee" style="display: none">
<label><h4>Election Time Left</h4></label>
<table id="table1" border="0">
    <tr>
        <td align="center" colspan="6"><div class="numbers" id="count2" style="padding: 10px; "></div></td>
        <label id='write'></label>
    </tr>
    <tr id="spacer1">
        <td align="center" ><div class="title" ></div></td>
        <td align="center" ><div class="numbers1" id="dday"></div></td>
        <td align="center" ><div class="numbers1" id="dhour"></div></td>
        <td align="center" ><div class="numbers1" id="dmin"></div></td>
        <td align="center" ><div class="numbers1" id="dsec"></div></td>
        <td align="center" ><div class="title1" ></div></td>
    </tr>
    <tr id="spacer2">
        <td align="center" ><div class="title1" ></div></td>
        <td align="center" ><div class="title1" id="days">Days</div></td>
        <td align="center" ><div class="title1" id="hours">Hours</div></td>
        <td align="center" ><div class="title1" id="minutes">Minutes</div></td>
        <td align="center" ><div class="title1" id="seconds">Seconds</div></td>
        <td align="center" ><div class="title1" ></div></td>
    </tr>
</table>

</div> 

<div class='page' id="page" style="display:none">
     <?php echo $string_election;
for($efe=0;$efe<count($string_array);$efe++){
    echo $string_array[$efe].'<br>';
}
                ?>
<!--            <div class = "col-xs-6 col-sm-4">-->
<!--             <input type="radio" name="theActualPost" value="contestantId">   <img src="../images/pic1.png" width=80% height="">-->
<!--            </div>-->
<!--            <div class = "col-xs-6 col-sm-4">-->
<!--                <input type="radio" name="theActualPost" value="contestantId">   <img src="../images/pic1.png" width="80%" height="">-->
<!--            </div>-->
<!--            <div class = "col-xs-6 col-sm-4">-->
<!--                <input type="radio" name="theActualPost" value="contestantId">   <img src="../images/pic1.png" width="80%" height="">-->
<!--            </div>-->
<!--    </div>-->
            </div>
    </div>
    

        <!-- jQuery -->
        <script src="../js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>
</body>
</html>