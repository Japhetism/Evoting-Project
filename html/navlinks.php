<?php
if (isset($_SESSION['election_key'])) {
    include_once("../php/vote.php");
    $date_diff = $election_date - strtotime("now");
    # code...
}else{
    $_SESSION['adek_status'] = "user";
    $_SESSION['adek_link'] = "#";
    $date_diff = "";
}

    $manage_link=$invites = $label_display = '';
    $request_count = 0;

    if ($_SESSION['adek_status'] === 'Admin') {
        $manage_link = '
                    <li class="active1" id="demo3_2" >
                        <a data-target="#demo3" class="active" data-toggle="collapse" data-parent="#MainMenu">
                            <i class="fa fa-pencil"></i>
                                Manage Elections
                            <i class="fa fa-angle-left pull-right" style="width:10px;"></i>
                        </a>
                        <ul class="nav collapse in" id="demo3" style="margin-left:10px;">
                            <li>
                                <a href="'.$_SESSION['adek_link'].'" class="active" data-parent="#SubMenu1"></i><i class="fa fa-minus"></i>Election Details</a>
                            </li>
                            <li>
                                <a href="updateelectiondetails.php" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>Update Election</a>
                            </li>
                            <li>
                                <a href="editparticipant.php" class="active"><i class="fa fa-minus"></i>Edit Participants</a>
                            </li>
                            <li>
                                <a href="electionResult.php" id="result_link" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>View Results</a>
                            </li>
                        </ul>
                    </li>';
        $navbar_id = 'demo3_2';
    }else if($_SESSION['adek_status'] === 'Contestant' || $_SESSION['adek_status'] === 'Voter'){
        $manage_link = '
                    <li class="active1" id="demo3_3" >
                        <a data-target="#demo3" class="active" data-toggle="collapse" data-parent="#MainMenu">
                            <i class="fa fa-pencil"></i>
                                Manage Elections
                            <i class="fa fa-angle-left pull-right" style="width:10px;"></i>
                        </a>
                        <ul class="nav collapse in" id="demo3">
                            <li>
                                <a href="'.$_SESSION['adek_link'].'" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>Election Details</a>
                            </li>
                            <li>
                                <a  id="register_link" href="registercandidate.php" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>Register as Contestant</a>
                            </li>
                            <li>
                                <a href="#" class="active" id="contestant_link"><i class="fa fa-minus"></i>View Profile</a>
                            </li>
                            <li>
                                <a href="#" id="vote_link" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>Vote</a>
                            </li>
                            <li>
                                <a href="viewresult.php" id="result_link" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>View Results</a>
                            </li>
                        </ul>
                    </li>';
        $navbar_id = 'demo3_3';
    }else{
        $manage_link = '<li class="" id="" >
                        <a data-target="#demo3" href="'.$_SESSION['adek_link'].'"  data-toggle="collapse" data-parent="#MainMenu">
                            <i class="fa fa-pencil"></i>
                                Manage Elections
                            <i class="fa fa-angle-left pull-right" style="width:10px;"></i>
                        </a>
                        </li>';
        $navbar_id = '#';
    }
?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<style type="text/css">
    .acceptInvite,.rejectInvite{
        padding:1px;
        box-shadow: 1px 1px 3px 1px #eee;
        cursor: pointer;
        transition: box-shadow .2s ease-in;
        background: #fff;
        float: right;
        margin-top: 27px;
    }
    .acceptInvite:hover,.rejectInvite:hover{
        box-shadow: 2px 2px 6px 1px #aaa;
    }
   /* ul.dropdown-menu.pull-right h4{
        margin-top: 0;
    }
    ul.dropdown-menu.pull-right span.col-xs-5{
        background: #fff;
        padding-right: 1px;
        width: 40%;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-top: 5px;
        padding-left: 0;
    }
    ul.dropdown-menu.pull-right span.col-xs-5:hover{
        overflow: visible;
        width: auto;
        position: absolute;
        z-index: 200;
    }
    ul.dropdown-menu.pull-right span.col-xs-4{
        padding: 3px 0px 0 0 ;
        float: right;
    }*/
    ul.dropdown-menu.pull-right small{
        color: #aaa;
        font-size: 10px;
    }
    ul.dropdown-menu.pull-right span{
        display: inline-block;
        /*text-align: center;*/
        padding: 3px 0px;
    }
    ul.dropdown-menu.pull-right span.col-xs-3{
        padding-top: 0px;
        padding-left: 0;
    }
    ul.dropdown-menu.pull-right .sender_image{
        padding: 2px 2px 5px 2px;
        border-radius: 100%;
        border: solid  1px #ccc;
    }
    ul.dropdown-menu.pull-right p{
        margin-bottom: 2px;
        box-sizing: border-box;
        padding-right:20px;
        text-align: left;
        float: left;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    ul.dropdown-menu.pull-right li{
        margin-top: 1px;
        margin-bottom: 1px;
        width: 100%;
        cursor: pointer;
        border-bottom: solid 1px #f3f3f3;
    }
    ul.dropdown-menu.pull-right li.row:hover{ 
        background: #f7f7f7;
    }      
    ul.dropdown-menu.pull-right li.row{       
        margin-left: 0;
        padding: 5px;
        /*color: #bababa;*/
    }
    ul.dropdown-menu.pull-right li.divider{
        margin-top: 1px;
        margin-bottom: 1px;
        display: none;
        /*width: 100%;*/
    }
    ul.dropdown-menu.pull-right h6{
        font-weight: bolder;
        text-align: center;
        color: #a9a9a9;
    }
    .request_count{
        position: absolute;
        top: 5px;
        right: 15px;
        border-radius: 100%;
    }
    .email{
        line-height:20px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .email:hover{
        overflow: visible;
        background: #f7f7f7;
        z-index: 200;
    }
        i.badge{
            top: 40px;
            right: -35px;
            padding: 5px 15px;
            opacity: 1;
        }
        i.badge:after{
            top: -5px;
            bottom: 15px;
            left: 45%;
            opacity: 1;
            box-shadow: none;
        }
</style>

    <div class="load_cover">
        <i class="fa fa-spin fa-spinner"></i>
    </div>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <!-- logo -->
                    <i class="fa fa-play-circle"></i>  <span class="light">E -</span> Voting</a>
            </div>

            <!-- Top-right Menu Items -->
            <ul class="nav navbar-right top-nav">
                <?php 
                    if ($_SESSION['adek_status'] === 'Admin'){
                        $request_string_n ='
                        <li class="dropdown requests">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" onclick="$(this).siblings(\'ul\').slideToggle();">
                                <i class="fa fa-bell-o" data-toggle="tooltip" data-title="pending requests"></i><b class="caret"></b>
                                <span class="label label-primary request_count" ></span>
                            </a>
                            <ul class="dropdown-menu pull-right" style="min-width: 270px;">
                                <li>';

                        $request_string_n.='<h6 id="requests_title">Pending Requests</h6></li>
                                       <li class="divider"></li>';
                        $request_string = "";

                        //lets do this properly
                        if ($date_diff > 0)
                        {
                           //get all requests
                            $query = "SELECT
                                        request.request_date,request.user_id,users.email,users.picture_name
                                      FROM
                                        request
                                      LEFT JOIN
                                        users
                                      ON
                                        request.user_id = users.user_id
                                      WHERE
                                        request.election_id = '$election_id'";

                            $all_request = $connection1->prepare($query);
                            $all_request->execute();
                            $all_request->setFetchMode(PDO::FETCH_ASSOC);
                            $all_request = $all_request->fetchAll();
                            if (count($all_request) > 0)
                            {
                                $request_count = count($all_request);
                                for ($i = 0 ; $i < $request_count ; $i++)
                                {
                                    $sender_id = $all_request[$i]["user_id"];
                                    $sender_email = $all_request[$i]["email"];

                                    //separate the day from the time
                                    $request_day = explode(" ",$all_request[$i]["request_date"])[0];
                                    $request_time = timeString(explode(" ",$all_request[$i]["request_date"])[1]);

                                    if($all_request[$i]["picture_name"] != null)
                                        $img_url = '../images/users/'.$all_request[$i]["picture_name"];
                                    else
                                        $img_url = '../images/male.gif';

                                    $specification = $sender_id.'_'.$election_id;

                                    $request_string .= '<li class="row ';
                                    $request_string .= $specification;
                                    $request_string .= '" id="'.$sender_id.'">
                                                                    <span class="col-xs-2">
                                                                        <img class="img-circle preview" src="'.$img_url.'" alt="hey" width="100%" height="100%" >
                                                                    </span>
                                                                    <div class="col-xs-10" id="'.$date_diff.'">
                                                                      <span class="col-xs-8 email">';
                                    $request_string .=    $sender_email;
                                    $request_string .= '<span>
                                                                        <small>'.$request_day ." at ".$request_time.'</small>
                                                                     </span>
                                                                     </span>
                                                                        <i class="fa fa-close text-danger rejectInvite col-xs-1"></i>
                                                                        <i style="text-align: center;" class="fa fa-check text-success acceptInvite col-xs-1"></i>';
                                    $request_string .= '
                                                                    </div> </li>' ;
                                }
                                $request_string_n .= $request_string;

                            }
                        }
                        $request_string_n.='
                                </li>
                            </ul>
                        </li>';

                    }else{
                        $request_string_n = '';
                    }
                        print $request_string_n;
                 ?>
                <li class="dropdown userActions">
                    <a href="#" class="dropdown-toggle showActions" id="showActions" data-toggle="dropdown">
                        <i>
                            <img class="preview img-circle" src="<?php echo $photo_fetched;?>" width="30px" height="30px" >
                        </i>
                            <?php echo $myemail;?>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu userOptions" id="userOptions">
                        <li>
                            <a href="#" onclick="window.location = 'viewuserprofile.php'"><i class="fa fa-user"></i> profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../php/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="sidebar collapse navbar-collapse navbar-right navbar-main-collapse" id="sidebar">
                <ul class="nav navbar-nav side-nav sidebar" id="MainMenu">
                    <li class="col-md-12 ">
                        <div class="row userProfile" onclick="window.location = 'viewuserprofile.php?email=' + '<?php echo $myemail?>';" id="userActions">
                            <div class="col-md-12 userActions">
                                <img src="<?php echo $photo_fetched;?>" class="img-circle" alt="???" width="100px" height="100px"><br><br>
                                <b><?php echo $fullname;?></b><br>
                                <strong><?php echo $_SESSION['adek_status'];?></strong>
                            </div>
                        </div>
                    </li>
                    <li class="active" id="<?php echo $navbar_id; ?>" >
                            <a href="maindashboard.php" class="active"><i class="fa fa-home"></i>
                            Dashboard</a>
                    </li>
                    
                    <?php echo $manage_link?>
                    
                    <li class="active" id="<?php echo $navbar_id; ?>">
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
                    <li class="active" id="<?php echo $navbar_id; ?>">
                        <a href="#" class="active" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-user-plus"></i>Join an election
                        </a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

    <div class="blanket">
        <i class="btn btn-default fa fa-close" onclick="$('.blanket').fadeOut();"></i>
        <div class="content">

        </div>
    
    </div>
    <div style="display: none;" id="voted">
        <?php echo $hasvoted;?>
    </div>
    <div style="display: none;" id="result_display">
        <?php echo $result_display;?>
    </div>
    <div style="display: none;" id="adek_status"><?php echo $_SESSION['adek_status'];?></div>
    <div style="display: none;" id="request_count">
        <?php echo $request_count;?>
    </div>
<script src="../js/request.js"></script>
<!--<script src="../js/file.js"></script>-->
<script type="text/javascript">
    function check_link(){
        var vote_link = $('#vote_link');
        var result_link = $('#result_link');

        var election_end1 = new Date('<?php echo $election_end1;?>');
        var election_start = new Date('<?php echo $electionStartDateTemp;?>');
        var nowDate = new Date();
        var hasVoted = document.getElementById('voted').innerHTML;
        var result_display = document.getElementById('result_display').innerHTML;
        var contestant_link = $('#contestant_link');
        var register_link = $('#register_link');
        var status = document.getElementById('adek_status').innerHTML;

        var link = location.href;
        var startslice = link.lastIndexOf("/");
        var endslice = link.lastIndexOf(".");
        var href = link.substring(startslice+1);

            if (election_start > nowDate) {
                vote_link.attr({'href':'#','class':'inactive'});
                result_link.attr({'href':'#','class':'inactive'});
            }else if (election_start<nowDate<election_end1) {
                result_link.attr({'href':'electionResult.php','class':'active'});

                if (hasVoted == '0') {
                    vote_link.attr({'href':'voting.php','class':'active'});
                }else if (hasVoted == '1') {
                    vote_link.attr({'href':'#','class':'inactive'});
                }
            }else if (election_end1<nowDate) {
                vote_link.attr({'href':'#','class':'inactive'});
                result_link.attr({'href':'electionResult.php','class':'active'});
            }

            if (status == 'Contestant') {
                contestant_link.attr({'href':'viewprofile.php','class':'active'});
                register_link.attr({'href':'#','class':'inactive'});
            }else{
                contestant_link.attr({'href':'#','class':'inactive'});
                register_link.attr({'href':'registercandidate.php','class':'active'});
            }


            var active_link = $('[href = "'+href+'"]');
            if (active_link != '') {
                active_link.parent('li').attr('class','active1');
            }else{
                $('#demo3_2, #demo3_3').attr('class','active');
                $('#demo3_2, #demo3_3').children('a').attr({'data-target':'#','class':"inactive"});
            }
            if (status == 'Admin') {
                setRequestCount();
            }
    }



    function setRequestCount(){
        var request_count = document.getElementById('request_count').innerHTML;
        var requests_title = document.getElementById('requests_title');
        $('.request_count').css('display','inline');
        $('.request_count').html(request_count);
        if (request_count > 0 ) {
            if (request_count > 1 ) {
            requests_title.innerHTML = 'You have '+request_count+' pending requests';
            }else{
                requests_title.innerHTML = 'You have '+request_count+' pending request';
            }
        }else{
            requests_title.innerHTML = 'You have no pending request.';
        }
    }
        check_link();
</script>
<script type="text/javascript">
    $(document).click(function(){
        $('ul.dropdown-menu.pull-right').slideUp();
    });
</script>