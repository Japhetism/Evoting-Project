<?php 
    include_once("../php/vote.php");

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
                                <a href="'.$_SESSION['adek_link'].'" class="active" data-parent="#SubMenu1"></i>Election Details</a>
                            </li>
                            <li>
                                <a href="updateelectiondetails.php?key='.$_SESSION['election_key'].'" class="active" data-parent="#SubMenu1">Update Election</a>
                            </li>
                            <li>
                                <a href="editparticipant.php?key='.$_SESSION['election_key'].'" class="active">Edit Participants</a>
                            </li>
                            <li>
                                <a href="viewresult.php?key='.$_SESSION['election_key'].'" id="result_link" class="active" data-parent="#SubMenu1">View Results</a>
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
                                <a href="registercandidate.php?key='.$_SESSION['election_key'].'" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>Register as Contestant</a>
                            </li>
                            <li>
                                <a href="#" class="active" id="contestant_link"><i class="fa fa-minus"></i>View Profile</a>
                            </li>
                            <li>
                                <a href="#" id="vote_link" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>Vote</a>
                            </li>
                            <li>
                                <a href="viewresult.php?key='.$_SESSION['election_key'].'" id="result_link" class="active" data-parent="#SubMenu1"><i class="fa fa-minus"></i>View Results</a>
                            </li>
                        </ul>
                    </li>';
        $navbar_id = 'demo3_3';
    }else{
        $manage_link = '<li class="" id="" >
                        <a data-target="#demo3" href="'.$_SESSION['adek_link'].'" class="active" data-toggle="collapse" data-parent="#MainMenu">
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
        float: right;
    }
    .acceptInvite:hover,.rejectInvite:hover{
        box-shadow: 2px 2px 6px 1px #aaa;
    }
    ul.dropdown-menu h4{
        margin-top: 0;
    }
    ul.dropdown-menu span.col-xs-5{
        background: #fff;
        padding-right: 1px;
        width: 40%;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-top: 5px;
        padding-left: 0;
    }
    ul.dropdown-menu span.col-xs-5:hover{
        overflow: visible;
        width: auto;
        position: absolute;
        z-index: 200;
    }
    ul.dropdown-menu span.col-xs-4{
        padding: 3px 0px 0 0 ;
        float: right;
    }
    ul.dropdown-menu span{
        display: inline-block;
        text-align: center;
    }
    ul.dropdown-menu span.col-xs-3{
        padding-top: 0px;
        padding-left: 0;
    }
    ul.dropdown-menu .sender_image{
        padding: 2px 2px 5px 2px;
        border-radius: 2px;
        border: solid  1px #ccc;
    }
    ul.dropdown-menu li{
        margin-top: 1px;
        margin-bottom: 1px;
        width: 100%;
        cursor: pointer;
    }
    ul.dropdown-menu li.row{       
        margin-left: 0;
        padding-left: 0;
        box-shadow: 1px 1px 2px 1px #eee;
    }
    ul.dropdown-menu li.divider{
        margin-top: 1px;
        margin-bottom: 1px;
        /*width: 100%;*/
    }
    ul.dropdown-menu h6{
        font-weight: bolder;
        text-align: center;
    }
    ul.dropdown-menu{
        padding: 0px 10px;
    }
    .request_count{
        position: absolute;
        top: 5px;
        right: -5px;
        border-radius: 100%;
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
            <i class="fa fa-play-circle"></i>  <span class="light">E -</span> Voting
        </a>
    </div>

    <!-- Top-right Menu Items -->
    <ul class="nav navbar-right top-nav">
        <?php 
            if ($_SESSION['adek_status'] === 'Admin'){
            $request_string_n ='
            <li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown" onclick="$(this).siblings(\'ul\').slideToggle();">
                    <i class="fa fa-bell-o" data-toggle="tooltip" data-title="pending requests"></i><b class="caret"></b>
                    <span class="label label-primary request_count" style="display:none"></span>
                </a>
                <ul class="dropdown-menu pull-right" style="min-width: 200px;">
                    <li>';
                        
                        //lets get pending requests but we must check if election has not concluded
                        $sender_id_query ="SELECT user_id FROM request WHERE election_id='$election_id'";
                        $sender_highdee =mysqli_query($connection2,$sender_id_query);
                        $sender_id =mysqli_fetch_row($sender_highdee)[0];
                        if($sender_id!=''){
                            $request_string='<h6>Pending Requests</h6></li>
                                           <li class="divider"></li>';
                            do{
                                //get email of current sender and display it
                                $sender_email_query="SELECT email FROM users WHERE user_id='$sender_id'";
                                $sender_email= mysqli_query($connection2,$sender_email_query);
                                $sender_email = mysqli_fetch_row($sender_email)[0];
                                $sender_pic_query="SELECT picture_name FROM users WHERE user_id='$sender_id'";
                                $sender_pic_name = mysqli_query($connection2,$sender_pic_query);
                                $sender_pic_name = mysqli_fetch_row($sender_pic_name)[0];
                                if ($sender_pic_name != NULL) {
                                    $img_url = '../images/users/'.$sender_pic_name;
                                }else $img_url = '../images/male.gif';
                                $specification=$sender_id.'_'.$election_id;
                                $request_string.='<li class="row ';
                                $request_string.=$specification;
                                $request_string.='" id="'.$sender_id.'">
                                                    <span class="col-xs-3">
                                                        <img class="sender_image" src="'.$img_url.'" alt="hey" width="30px" height="35px" >
                                                    </span>
                                                        <span class="col-xs-5 adekprofile">';
                                $request_string.=           $sender_email;
                                $request_string.=       '</span>';
                                $request_string.='<span class="col-xs-4" id="'.$date_diff.'">
                                                    <i class="fa fa-close text-danger rejectInvite"></i>
                                                    <i style="text-align: center;" class="fa fa-check text-success acceptInvite"></i>
                                                 </span> </li>
                                           <li class="divider"></li>' ;
                                           $request_count++;

                            }while($sender_id =mysqli_fetch_row($sender_highdee)[0]);
                            $request_string.='
                                             ';
                            $request_string_n.=$request_string;
                        }
                        else{
                            $request_string_n.= "<h5>"."You have no pending requests"."</h5>";
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
                    <img src="<?php echo $photo_fetched;?>" width="30px" height="30px" >
                </i>
                    <?php echo $myemail;?>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu userOptions" id="userOptions">
                <li>
                    <a href="viewuserprofile.php"><i class="fa fa-user"></i> Edit profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../php/logout.php"><i class="fa fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="sidebar collapse navbar-collapse navbar-right navbar-main-collapse" id="sidebar">
        <ul class="nav navbar-nav side-nav sidebar" id="MainMenu">
            <li class="col-md-12 ">
                <div class="row userProfile" id="userActions">
                    <div class="col-md-12 userActions">
                        <img src="<?php echo $photo_fetched;?>" alt="???" width="100px" height="100px" style="border-radius:100%;"><br><br>
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
<script src="../js/request.js"></script>
<script src="../js/file.js"></script>
<script type="text/javascript">
    function check_link(){
        var vote_link = $('#vote_link');
        var result_link = $('#result_link');
        var election_end1 = new Date('<?php echo $election_end1;?>');
        var election_start = new Date('<?php echo $electionStartDateTemp;?>');
        var nowDate = new Date();
        var hasVoted = '<?php echo $hasvoted;?>';
        var result_display = '<?php echo $result_display;?>';
        var contestant_link = $('#contestant_link');
        var status = '<?php echo $_SESSION['adek_status']; ?>';

        var link = location.href;
        var startslice = link.lastIndexOf("/");
        var endslice = link.lastIndexOf(".");
        var href = link.substring(startslice+1);

            if (election_start>nowDate) {
                vote_link.attr({'href':'#','class':'inactive'});
                result_link.attr({'href':'#','class':'inactive'});
            }else if (election_end1<nowDate) {
                vote_link.attr({'href':'#','class':'inactive'});
                result_link.attr({'href':'electionResult.php','class':'active'});
            }else if (election_start<nowDate<election_end1) {
                result_link.attr({'href':'electionResult.php','class':'active'});

                if (hasVoted === '0') {
                    vote_link.attr({'href':'voting.php','class':'active'});
                }else if (hasVoted === '1') {
                    vote_link.attr({'href':'#','class':'inactive'});
                }
            }

            if (status === 'Contestant') {
                contestant_link.attr({'href':'viewContestantProfile.php','class':'inactive'});
            }else{
                contestant_link.attr({'href':'#','class':'inactive'});
            }


        console.log(link+' '+startslice+' '+endslice+' '+href);

            var active_link = $('[href = "'+href+'"]');
            if (active_link != '') {
                active_link.parent('li').attr('class','active1');
            }else{
                $('#demo3_2, #demo3_3').attr('class','active');
                $('#demo3_2, #demo3_3').children('a').attr({'data-target':'#','class':"inactive"});
            }
            var request_count = '<?php echo $request_count;?>';
            if (request_count>0) {
                $('.request_count').css('display','inline');
                $('.request_count').html(request_count);
            }else{
                $('.request_count').css('display','none');
            }
    }
</script>
<script type="text/javascript">
    check_link();
    $(document).click(function(){
        $('ul.dropdown-menu').slideUp();
    });
</script>