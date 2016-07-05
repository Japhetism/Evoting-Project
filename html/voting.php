<?php
include_once("../php/vote.php");
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
       
<script type="text/javascript">

    var current="Election Has Closed!";   //-->enter what you want the script to display when the target date and time are reached, limit to 20 characters
    var current3 = "Election Ends In";
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
            window.location = "electionResult.php";
            /*var page = document.getElementById('page');
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
            return;*/
        }
        else {
            document.getElementById('count2').style.display="none";
            document.getElementById('wrote').innerHTML = current3;
            document.getElementById('dday').innerHTML=dday+'';
            document.getElementById('dhour').innerHTML=dhour+'';
            document.getElementById('dmin').innerHTML=dmin+'';
            document.getElementById('dsec').innerHTML=dsec;
            setTimeout("countdown(theyear,themonth,theday,thehour,theminute)",1000);
        }
    }



    function check(){
        var start_date = new Date('<?php echo $election_start_date." ".$election_time_from;?>');
        var end_date = new Date('<?php echo $election_end_date." ".$election_time_to;?>');
        var today_date = new Date();
        if(start_date > today_date){
            window.location = "maindashboard.php";
        }

        var hasvoted = '<?php echo $hasvoted;?>';
        if(hasvoted === "1"){
            window.location = 'electionResult.php';
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

<style type="text/css"> 
    #page-wrapper{
        padding :20px 20px;
            background-color: floralwhite;
            height: 100%;
    }
    .media{
        padding-top: 60px!important;
        transition: padding .2s;
    }
    @media(min-width: 768px){
        #page-wrapper{
            padding:20px 100px;
        }
        .contestants{
            margin-bottom: 0;
        }
        .media{
            padding-top: 60px!important;
        }
        h2#wrote{
            width: 20%;
            float: left;
            font-size: 20px;
        }
        #table1{
            width: 30%;
            border: none;
        }
    }
    .panel{
        box-shadow: 0px 2px 3px 2px rgba(0,0,0,0.1);
        padding-bottom: 10px;
    }
    .panel .panel:hover{
        box-shadow:0px 0px 3px 1px rgba(0,0,0,0.1);
    }
    #election_time_left{
        margin: 30px 0px;
    }
    #election_time_left>.panel>.panel-heading{
        width: 100%;
    }
    .panel-default .panel-heading{
        background-color: rgba(208, 146, 57, 0.84);
        text-align: center;
        opacity: 0.6;
        color: black;
    }
    .panel-title{
        font-size: 15px;
        font-weight: bold;
    }
    #spacer1>td{
        font-size: 30px;
        border-bottom: none;
    }
    td{
        /*border: solid 1px #2A5D89;*/
        text-align: center;
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
         padding: 5px;
         border-radius: 2px;
         margin-bottom: 20px;
    }
    .contestants.active{       
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.15), 0 6px 20px 0 rgba(0, 0, 0, 0.12);
    }
    .contestants:hover{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.09);
        cursor: pointer;
    }
    hr{
        margin: 10px 0px;
        border-top: solid 1px #ccc;
    }*/
    .panel-body{
        color: #777;
    }
    .panel-body h3{
        color: #444;
        margin-top: 20px;
    }
    input[type='radio']:not(old){
        width: 28px;
        height: 30px;
        padding : 0;
        margin: 10px 0 0 0;
        opacity: 0;
        cursor: pointer;
    }
    label#option,
    label#chosen{
            display: inline-block;
            position: absolute;
            top: 40px;
            left: -2px;
            width: 30px;
            height: 45px;
            color: transparent;
            background: none;
            transition: background 0.2s;
            cursor: pointer;
    }
    input[type='radio']:not(old):checked + label#option,
    input[type='radio']:not(old):checked + label#chosen{
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
        border: solid 1px #ddd;
        margin-bottom: 5px;
        position: relative;
        padding: 2px 0 3px 0;
        transition: opacity 0.5s;
    }
    .row.contestant:hover{
        box-shadow: 0px 2px 4px rgba(0,0,0,0.2);
    }

    .row.contestant-details{
        margin: 0 -10px 5px -10px;
        cursor: pointer;
        margin-top: 0px; 
        width: 88%;
        margin-left: 0px;
        display: none;
        position: absolute;
        background: #fff;
        z-index: 3;
        padding: 0;
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
        cursor: progress;
    }
    .row.contestant-details>.col-xs-12{
        position: relative;
        top: 0px;
        background: rgba(100,100,100,0.8);
        left: 0%;
        padding:3px 0 2px 0;
        z-index:2;
        width: 100%;
        color: #fff;
    }
    .row.contestant-details>.col-xs-12>.col-xs-8{
        padding-top: 5px;
    }
    .row.contestant-details>.col-xs-12>.col-xs-2>img{
        margin: 1px 0px 2px -10px;
        border: solid 1px #eee;
        padding: 2px;
        border-radius: 2px;
        background: #fff;
        width: 40px;
        height: 50px;
    }
    .row.contestant.active:hover{
        box-shadow: none;
    }
    .row.contestant.active img{
        opacity: 0.4;
    }
    .row.contestant.active{
        /*opacity: 0.6;*/
        background: rgba(242,242,242,0.5);
        color: #ccc;
        transition: background 0.6s,color 0.2s;
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
    .page-header.dash{
         background-color: rgba(208, 146, 57, 0.84)!important;
         text-align: center;
         border: none;
         opacity: 0.7;    
    }
    .panel-body.media.main{
        padding-top: 0px!important;
    }
    /*input#option:after{
        opacity: 1;
        width   : 28px;
        height: 30px;
        font-size: 30px;
        border-radius: 100%;
        color: #eee;
    }
    input#option:not(old):checked:after{
        opacity: 1;
        content: "✓";
        position: absolute;
        top: -5px;
        right: -1px;
    }*/
</style>
</head>
<body onload="countdown(year,month,day,hour,minute); check()">



<div id="wrapper">
    
    <?php include_once('navlinks.php');?>


    <div id="page-wrapper">

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

            <!-- container header-->
            <div class="row">
                <div class="page-title col-xs-12">
                    <h3>Voting Page</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="maindashboard.php">Home</a></li>
                            <li><a href="<?php echo $_SESSION['adek_link'];?> "><?php echo $_SESSION['election_name'];?> </a></li>
                            <li class="active">Voting</li>
                        </ol>
                    </div>
                </div>

            </div><br>
            <!-- container header ends-->
    <!-- /#page-wrapper -->
        <div class="container-fluid">
            <div class="row">

                    <div class='col-md-12' id="page" style="display:block">
                        <form class="form-horizontal" role="form" id="706641944" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">

                            <div class="panel">
                                <div class="panel-heading" style="padding: 0">
                                    <div class="page-header dash"> 
                                        Election - <?php echo $election_name;?>
                                    </div>
                                </div>
                                <div class="panel-body main">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <?php
                                                echo '
                                                <div class="table-responsive">
                                                    <table id="table1" border="0">
                                                        <h2 id="wrote"></h2>
                                                        <thead>
                                                            <tr>
                                                                <th class="primary" colspan="6">
                                                                    <div class="numbers" id="count2" style=" ">Election End</div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tr id="spacer1">
                                                            <td><div class="numbers1" id="dday"></div></td>
                                                            <td>:</td>
                                                            <td><div class="numbers1" id="dhour"></div></td>
                                                            <td>:</td>
                                                            <td><div class="numbers1" id="dmin"></div></td>
                                                            <td>:</td>
                                                            <td><div class="numbers1" id="dsec"></div></td>
                                                        </tr>
                                                        <tr id="spacer2">
                                                            <td><div class="title1" id="days">Days</div></td>
                                                            <td></td>
                                                            <td><div class="title1" id="hours">Hours</div></td>
                                                            <td></td>
                                                            <td><div class="title1" id="minutes">Minutes</div></td>
                                                            <td></td>
                                                            <td><div class="title1" id="seconds">Seconds</div></td>
                                                        </tr>
                                                    </table>
                                                </div>';
                                            ?>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <span>Click on the contestant(s) you want to vote for,&nbsp; and then cast your vote.</span>
                                    </div>
                                    <div class="row">
                                        <?php
                                            for($efe = 0; $efe < count($string_array); $efe++){
                                                echo $string_array[$efe];
                                            }
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-2 col-md-offset-4" style="text-align: center;">
                                    <input class="btn btn-primary btn-lg" value="Vote" type="submit" name="submit">
                                </div>
                                <div class="col-xs-6 col-md-2" style="text-align: left;">
                                    <input class="btn btn-danger btn-lg" value="Cancel" type="button" onclick="window.location='election_detailsNews.php?key=<?php echo $_SESSION["election_key"]?>';">
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    

</div>

        <script type="text/javascript">
            $('input#option').click(function(){
                $('.contestant').removeClass('active');
                $(this).parents('.contestant').addClass('active');
            });

            $('.row.contestant').click(function(){
                var thisContestant = $(this);
                var contestantDetails = $(this).html();
                var thisPicked = $(this).parents('.panel-body').siblings('#contestant');
                if (thisContestant.attr('class')== "row contestant active") {
                    var hello = thisContestant.find('b').html();
                console.log(contestantDetails);
                    $('.content').html('Do u want to untick <span class="text-primary">'+ hello +'</span> ?&nbsp;<b class="btn btn-success" id="yes">Yes</b> <b class="btn btn-danger">no</b>');
                    $('.blanket').fadeIn(400,function(){
                        $('.content').animate({'top':'10%'});
                    });

                    $('#yes').click(function(){
                        thisPicked.slideUp();
                        thisContestant.parents('.panel-body').removeClass('media');
                        thisContestant.find('input#option').prop('checked',false);
                        thisContestant.removeClass('active');  
                    });

                    $('b').click(function(){
                        $('.content').animate({'top':'-15%'},function(){                            
                            $('.blanket').fadeOut();
                        });
                    });
                }
                else{
                    thisPicked.children('.col-xs-12').html(contestantDetails);
                    thisPicked.find('label#option').attr('class','chosen');
                    thisContestant.siblings('.contestant').removeClass('active');
                    thisContestant.siblings('.contestant').find('input#option').prop('checked',false);
                    thisPicked.find('input#option').attr('name','');
                    thisPicked.find('input#option').prop('checked',true);
                    thisContestant.find('input#option').prop('checked',true);
                    thisContestant.addClass('active');
                    thisPicked.slideDown(500);
                    thisContestant.parents('.panel-body').addClass('media');
                    $('.row.contestant-details').find('i.preview-img').remove();
                }
                    
            });



            // $('.blanket').click(function(){
            //     $('.content').animate({'top':'-15%'},200,function(){
            //         $('.blanket').fadeOut();
            //     });
            // });

            $('.contestant-details').click(function(){
                var details= $(this);
                var hello=$(this).find('.col-xs-8>b').html();
                $('.content').html('Do u want to untick <span class="text-primary">'+ hello +'</span> ?&nbsp;<b class="btn btn-success" id="yes">Yes</b> <b class="btn btn-danger">no</b>');
                $('.blanket').fadeIn(200,function(){
                    $('.content').animate({'top':'10%'});
                });

                $('#yes').click(function(){
                    details.slideUp(400,function(){
                        details.siblings('.panel-body').removeClass('media');
                        details.siblings('.panel-body').children('.contestant').removeClass('active');
                        details.siblings('.panel-body').find('input#option').attr('checked',false);
                    });                  
                    
                });

                $('b').click(function(){
                    $('.content').animate({'top':'-15%'},200,function(){                            
                        $('.blanket').fadeOut();
                    });
                }); 
            });

        </script>
<script src="../js/file.js"></script>
</body>
</html>