<?php
$election_id =$result1 =$result_display ="";
include_once('session.php');
include_once('connection.php');
include_once('function.php');
include('database.php');

//getting the election id from the key passed to the url
$election_id = $result_tag = $election_details_for_admin ="";
if(isset($_GET['key'])){
    $key=$_GET['key'];
    $_SESSION['election_key']=$key;
    $election_id = substr($key,9,strlen($key)-17);
    $_SESSION['election_id']=$election_id;
}

//Posting of news by the admin
$post_news = $error = "";

if(!empty($_POST["post_submit"]) && isset($_POST["post_submit"])){
    $error = false;

//checking if the post field is empty
    if(empty($_POST['post_news'])){
        $error = true;
    }else{
        $post_news = $_POST['post_news'];
    }

//getting user_id via the email used to login
    $getUser_id = "SELECT user_id FROM users WHERE email='$myemail'";
    $user_id = mysqli_fetch_row(mysqli_query($connection2, $getUser_id));

    //inserting into the database

    if(!$error){
        $sql = "INSERT INTO news(news, election_id)
						VALUES('".$post_news."', '".$election_id."')";

        if(mysqli_query($connection2, $sql)){

            header("Location:postnews.php?key=".$key);
        }
    }
}



//fetcching and displaying the news posted by the admin
$posted_news = $adminPhoto = $profile1 = "";
$images_dir = "../images/users/";
$news_query = "SELECT * FROM news WHERE election_id='$election_id' ORDER BY date_created DESC";
$admin_user_id = "SELECT user_id FROM election WHERE election_id='$election_id'";
$user_id =mysqli_query($connection2,$admin_user_id);
$user_id=mysqli_fetch_row($user_id);
$admin_photo = "SELECT fname, lname, picture_name FROM users WHERE user_id='$user_id[0]'";
if($result_admin = mysqli_query($connection2,$admin_photo)){
    while($row1 = mysqli_fetch_assoc($result_admin)){
        if($result = mysqli_query($connection2, $news_query)){
            while($row = mysqli_fetch_assoc($result)){
                $add = $row['news_id'];
                $adminPhoto = $images_dir.$row1['picture_name'];
                $date_time = explode(" ", $row['date_created']);
                $date = getDateInterval($date_time[0]);
                $time = timeString($date_time[1]);
                $posted_news.="<div class='me' style='margin-bottom:10px;' >"."<br><div id='dem$add' style='padding-left:2%;'><label id=$add style='overflow:hidden;text-overflow:ellipsis;'>".$row['news']."</label><br>".$date."&nbsp".$time."&nbsp<br>";
                /* $encrypted_news_id=rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$row['news_id'].rand(10000,99999).rand(100,999);*/
                $posted_news.="<a href='#' onclick='editNews($add)'>Edit</a>&nbsp&nbsp<a href='#' onclick='deleteNews($add)'>Delete</a></div><div id='other$add'><form method='post'><textarea name='modify_news' id='modify_news$add' style='display:none; margin-bottom:5px;min-width:90%;margin-left:1%;'></textarea><input type='submit' value='Update News' name='update_news' id='update_news$add' style='display: none;float:left;'><input type='submit' value='Confirm Delete' name='delete_news' id='delete_news$add' style='display: none;float:left;'><input type='button' value='Cancel' id='cancel_delete_news$add' onclick='cancelNews($add)' style='display: none;margin-left:40%;'><input type='text' name='id' id='getid$add' style='display:none'></form></div></div>";
            }
        }

    }
}





//getting the news_id from the URL
$news_id = "";
if(empty($_POST['id'])){

}else{
    $news_id = $_POST['id'];

    /*if(isset($_GET['under'])){
        $new_id = $_GET['under'];
        $news_id= substr($new_id,9,strlen($new_id)-17);*/
    //check if the $news_id is actually an id for a particular news for the election,else redirect to postnews.php with the latest key value
    if(isset($_SESSION['election_id'])){
        $nwElection_id = $_SESSION['election_id'];
        $election_id=substr($nwElection_id,9,strlen($nwElection_id)-17);

    }
    $check_news_query="SELECT * FROM news WHERE news_id='$news_id' AND election_id='$election_id'";
    $news= mysqli_fetch_row(mysqli_query($connection2,$check_news_query));
    if(empty($news)){
        header("Location:postnews.php?key=".$nwElection_id);
    }
}
/*}*/


//fetching those posted news by admin to modify
$query_news = "SELECT news FROM news WHERE news_id='$news_id'";
if($result_news = mysqli_query($connection2, $query_news)){
    /*fetch associative array */
    while($row = mysqli_fetch_assoc($result_news)){
        $news_fetched = $row['news'];
    }
}



//getting election_id from the saved session
/*if(isset($_SESSION['election_id'])){
    $key = $_SESSION['election_id'];
}*/

//posting the update of news
$post_update = $updateErr = "";
if(!empty($_POST['update_news']) && isset($_POST['update_news'])){
    $updateErr = false;
    if(empty($_POST['modify_news'])){
        $updateErr = true;
    }else{
        $post_update = $_POST['modify_news'];
    }

    if(!$updateErr){
        $query_update = "UPDATE news SET news='$post_update' WHERE news_id='$news_id'";
        if(mysqli_query($connection2, $query_update)){
            header("Location:postnews.php?key=".$key);
        }else{

        }
    }

}

//getting election_id from the saved session
/*if(isset($_SESSION['election_id'])){
    $nwElection_id = $_SESSION['election_id'];
}*/


//deleting news from the database
$post_update = $updateErr = "";
if(!empty($_POST['delete_news']) && isset($_POST['delete_news'])){
    $updateErr = false;
    /*if(empty($_POST['post_news'])){
        $updateErr = true;
    }else{
        $post_update = $_POST['post_news'];
    }*/

    if(!$updateErr){
        $query_delete = "DELETE FROM news WHERE news_id='$news_id'";
        if(mysqli_query($connection2, $query_delete)){
            header("Location:postnews.php?key=".$key);
        }else{

        }
    }

}

if(!empty($_POST['cancel_delete_news']) && isset($_POST['cancel_delete_news'])){
    header("Location:postnews.php?key=".$key);
}



//fetching to the view contestant page
$election_id = "";
if(isset($_GET['key'])){
    $view_election_id = $_GET['key'];
    $election_id= substr($view_election_id,9,strlen($view_election_id)-17);
    $_SESSION['election_id_view'] = $election_id;
}

//querying for news
$view_posted_news = "";
$view_news_query = "SELECT * FROM news WHERE election_id='$election_id' ORDER BY date_created DESC";
if($result_admin = mysqli_query($connection2,$admin_photo)){
    while($row1 = mysqli_fetch_assoc($result_admin)){
        if($view_result = mysqli_query($connection2, $view_news_query)){
            while($row=mysqli_fetch_assoc($view_result)){
                $adminPhoto = $images_dir.$row1['picture_name'];
                $date_time1 = explode(" ", $row['date_created']);
                $date1 = getDateInterval($date_time1[0]);
                $time1 = timeString($date_time1[1]);
                $view_posted_news.="<div class='me' style='margin-bottom:10px; ' >"."<br><label style='overflow:hidden;text-overflow:ellipsis;'>".$row['news']."</label><br>".$date1."&nbsp".$time1."<br></div>";
            }
        }
    }
}

//querying for election name
$election_name = $election_details_test = "";
$view_election_query = "SELECT * FROM election  WHERE election_id = '$election_id'";
if($view_election = mysqli_query($connection2, $view_election_query)){
    while($row = mysqli_fetch_assoc($view_election)){
        $election_name .= $row['election_name'];
        $_SESSION['election_name']=$election_name;
        $election_details_test .= "<label>Start Date:</label> ".dateString($row['election_start_date'])."<br><label>Start Time:</label> ".timeString($row['election_time_from'])."<br><label>End Date:</label> &nbsp".
            dateString($row['election_end_date'])."<br><label>End Time:</label> ".timeString($row['election_time_to'])."<br><label>Number of Voters: </label> ".count(getAllMembers("joined", ['election_id'], ['election_id', '=', $election_id])).
        "<br><label>Number of Contestants: </label> ".count(getAllMembers("contestants", ['contestant_id'], ['election_id', '=', $election_id]));
    }
}


//getting the user_id for a particular election
$election_admin_details = $election_admin_detail = "";
$images_dir = "../images/users/";
$election_user_id = "SELECT user_id FROM election WHERE election_id = '$election_id'";
$user_id_result = mysqli_fetch_row(mysqli_query($connection2, $election_user_id));

//querying to get the admin email
$view_user = "SELECT * FROM  users WHERE user_id = '$user_id_result[0]'";
if($view_user_name = mysqli_query($connection2, $view_user)){
    while($row = mysqli_fetch_assoc($view_user_name)){
        $election_admin_details .= "<div class='col-md-6'><label>Name:</label> ".$row['lname']."&nbsp".$row['fname']."<br><label>Username:</label> ".$row['username']."<br><label>Email:</label> ".$row['email']."<br><label>Telephone:</label> ".$row['phone']."</div>";
        $election_admin_detail .= "<div class='col-md-4'><img src=".$images_dir.$row['picture_name']." width='100px' height='100px' style='border-radius:100%;' id='displayedPhoto'></div>";
    }
}

//checking for the link vote
$hasvoted=hasvoted(user_id($myemail), $election_id);
//determining when to make the view profile link visible or not'
$checkContestant1 = checkContestant(user_id($myemail), $election_id);
if(!empty($checkContestant1)){
    $profile1 = "<a href='viewprofile.php' class='active'>View Profile</a>";
}else{
    $profile1 = "";
}

//get post table
$all_posts= getAllPosts($election_id);
$total_contestants=0;
$posts_table='<div class="table-responsive contestants_table" style="max-height: 220px">
                 <table class="table table-striped">
                     <thead >
                         <tr>
                            <th>Post</th>
                            <th>Pin</th>
                            <th>Number of Contestants</th>
                         </tr>
                     </thead>
                     <tbody>';
for($i=0;$i<count($all_posts);$i++){
$posts_table.='<tr>
                   <td>'.$all_posts[$i]["post"].'</td>
                   <td>'.$all_posts[$i]["post_key"].'</td>
                   <td>'.count(getAllContestants($all_posts[$i]["post_id"])).'</td>
                </tr>';
    $total_contestants+=count(getAllContestants($all_posts[$i]["post_id"]));
}
$posts_table.='</tbody>
                 </table>
               </div>';


?>