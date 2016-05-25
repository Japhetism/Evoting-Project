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

var current="Election Has Closed!";   //-->enter what you want the script to display when the target date and time are reached, limit to 20 characters
var year=<?php echo $end_year;?>;    //-->Enter the count down target date YEAR
var month=<?php echo $end_month;?>;       //-->Enter the count down target date MONTH
var day=<?php echo $end_day;?> ;       //-->Enter the count down target date DAY
var hour=<?php echo $end_hour;?> ;      //-->Enter the count down target date HOUR (24 hour clock)
var minute=<?php echo $end_minute;?> ;    //-->Enter the count down target date MINUTE
var tz=+1;        //-->Offset for your timezone in hours from UTC (see http://wwp.greenwichmeantime.com/index.htm to find the timezone offset for your location)


//    DO NOT CHANGE THE CODE BELOW!
var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

function countdown(yr,m,d,hr,min){
    theyear=yr;themonth=m;theday=d;thehour=hr;theminute=min;
    var today=new Date();
    var todayy=today.getYear();
    if (todayy < 1000) {todayy+=1900;}
    var todaym=today.getMonth();
    var todayd=today.getDate();
    var todayh=today.getHours();
    var todaymin=today.getMinutes();
    var todaysec=today.getSeconds();
    var todaystring1=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec;
    var todaystring=Date.parse(todaystring1)+(tz*1000*60*60);
    var futurestring1=(montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min);
    var futurestring=Date.parse(futurestring1)-(today.getTimezoneOffset()*(1000*60));
    var dd=futurestring-todaystring;
    var dday=Math.floor(dd/(60*60*1000*24)*1);
    var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);
    var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
    var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
    if(dday<=0&&dhour<=0&&dmin<=0&&dsec<=0){
        var page = document.getElementById('page');
        var wee = document.getElementById('wee');
        page.style.display = 'none';
        wee.style.display = 'block';
        document.getElementById('count2').innerHTML=current;
        document.getElementById('count2').style.display="block";
        document.getElementById('count2').style.width="390px";
        document.getElementById('dday').style.display="none";
        document.getElementById('dhour').style.display="none";
        document.getElementById('dmin').style.display="none";
        document.getElementById('dsec').style.display="none";
        document.getElementById('days').style.display="none";
        document.getElementById('hours').style.display="none";
        document.getElementById('minutes').style.display="none";
        document.getElementById('seconds').style.display="none";
        document.getElementById('spacer1').style.display="none";
        document.getElementById('spacer2').style.display="none";
        return;
    }
    else {
        document.getElementById('count2').style.display="none";
        document.getElementById('dday').innerHTML=dday;
        document.getElementById('dhour').innerHTML=dhour;
        document.getElementById('dmin').innerHTML=dmin;
        document.getElementById('dsec').innerHTML=dsec;
        setTimeout("countdown(theyear,themonth,theday,thehour,theminute)",1000);
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
        window.location = '../html/checkVoting.php';
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
<body onload="countdown(year,month,day,hour,minute); check()">

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="maindashboard.php">&nbsp E-voting</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $myemail;?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Edit profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="../php/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav side-nav sidebar">
                <h4><span class="fa fa-th-large"></span> Dashboard</h4>
                <li>
                    <a href="maindashboard.php" style="font-weight:bolder;"><i class="fa fa-fw fa-th"></i>My Elections<i style="margin-left:50px;"class="fa fa-caret-down"></i></a>
                    <ul class="nav nav-second-level">
                           <li class="inactive">
                            <a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Created Election</a>
                           </li>
                           <li class="inactive">
                            <a  style="font-weight:bolder;" href="#"><i class="fa fa-edit"></i>Joined Election<i style="margin-left:5px;"class="fa fa-caret-down"></i></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a class="active active2"href="#">View Contestants</a>
                                </li>
                                <li>
                                    <a class="active2" href="registercandidate.php">Register As A Contestant</a>
                                </li>
                                <li>
                                    <a class="inactive"href="#">View Profile (Contestants only)</a>
                                </li>
                                <li>
                                    <a class="inactive"href="#">Vote</a>
                                </li>
                            </ul>
                             <!-- /.nav-third-level -->
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li >
                    <a class="inactive" href="#"><i class="fa fa-fw fa-plus"></i>Create an election<i class="fa fa-fw fa-caret-right"></i></a>
                </li>
                <li>
                    <a class="inactive" href="#"><i class="fa fa-fw fa-plus-square"></i>Join an Election</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>


    <!-- <div id='tables' style="display: none;">
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
</div> -->

<!--    <div class = "row">-->


<div class="wee" id="wee" style="display: block">
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

<div class='page' id="page" style="display:block">
<form class="form-horizontal" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">

     <?php
     echo $string_election;
     echo $message. " ". $hasvoted;
     echo $contestant_id;
         for($efe=0;$efe<count($string_array);$efe++){
            echo $string_array[$efe].'<br>';
         }
     ?>
        <input class="btn btn-primary" value="Cast Vote" type="submit" name="submit">
</form>


<!--            <div class = "col-xs-6 col-sm-4">-->
<!--                <input type="radio" name="theActualPost" value="contestantId">   <img src="../images/pic1.png" width="80%" height="">-->
<!--            </div>-->
<!--    </div>-->
            </div>
    </div>
</body>
</html>