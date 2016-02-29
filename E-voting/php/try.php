<?php
include ('connection.php');
include_once('database.php');
include_once('function.php');
//$assoc_query="SELECT * FROM election WHERE  election_id='1'";
//$assoc= mysqli_fetch_object(mysqli_query($connection2,$assoc_query));
////print_r($assoc);
//print $assoc->election_name;
//print trim("adasd asfda"," ");
//echo str_replace(" ",""," sdgs gsdg");
//print strcmp('aba','Aba');
//print_r(mysqli_fetch_assoc(mysqli_query($connection2,"SELECT election_name FROM election")));
//print stripslashes("i-. am' a boy");

//
$array= array('bad'=>'mus','gab'=>'riel');
//print_r(array_values($array));

//
$array1=array('1','h','ddf','fdsd','jhj','hd','14');
//$array2=array();print count($array2);
//unset($array2[0]);
//print_r($array2);
// print_r(array_intersect($array1,$array2));
//print count($array1);
//if(count(array_unique($array1))<count($array1))
//    print 'has repeated';
//else
//    print 'no repeated';
//function getAllPosts($election_id,$connection){
//    $post_query=$connection->prepare("SELECT post_key,post FROM posts WHERE election_id='$election_id'");
//    $post_query->execute();
//    $allPosts=$post_query->setFetchMode(PDO::FETCH_ASSOC);
//    $allPosts=$post_query->fetchAll();
//return $allPosts;
//
//}
//print_r(getAllPosts(28,$connection1));
//function to check attachment,put this in database.php
//function attached($tableName,$user_id,$election_id){
//    global $connection1;
//    $query=$connection1->prepare("SELECT * FROM $tableName WHERE user_id='$user_id' AND election_id='$election_id'");
//    $query->execute();
//    $query->setFetchMode(PDO::FETCH_ASSOC);
//    $status=$query->fetchColumn();
//    if(!empty($status)){
//        return $tableName;
//    }else{
//        return null;
//    }
//}
//$att=attached('election',3,1);
//print empty($att);
//lets check if a particular election is totally public for a user,put this in function.php
//function publicDisplayable($user_id,$election_id){
//    $table_lists=array('election','joined','invites','request');
//    $displayable='totally public';
//    for($i=0;$i<count($table_lists);$i++){
//        $attached=attached($table_lists[$i],$user_id,$election_id);
//        if(!empty($attached)){
//            $displayable= null;
//            break;
//        }
//    }
//    return $displayable;
//}

//print publicDisplayable(1,20);
//get all public elections
//$all_elections=$connection1->prepare("SELECT * FROM election");
//$all_elections->execute();
//$all_elections->setFetchMode(PDO::FETCH_ASSOC);
//$all_elections=$all_elections->fetchAll();
//$number_of_all_elections=count($all_elections);
//$user_id=1;
////get created election
//$tables=array('election','joined','invites','request');
//$created_elections=$joined_elections=$request_elections=$invited_elections=array();
//for($index=0;$index<count($tables);$index++){
//    for($indices=0;$indices<$number_of_all_elections;$indices++){
//        if(attached($tables[$index],$user_id,$all_elections[$indices]['election_id'])==='election'){
//            array_push($created_elections,$all_elections[$indices]);
//        }elseif(attached($tables[$index],$user_id,$all_elections[$indices]['election_id'])==='joined'){
//            array_push($joined_elections,$all_elections[$indices]);
//        }elseif(attached($tables[$index],$user_id,$all_elections[$indices]['election_id'])==='invites'){
//            array_push($invited_elections,$all_elections[$indices]);
//        }elseif(attached($tables[$index],$user_id,$all_elections[$indices]['election_id'])==='request'){
//            array_push($request_elections,$all_elections[$indices]);
//        }
//    }
//}
//$public_index=array('election_name','election_start_date','election_time_from','election_end_date','election_time_to','election_pin');
//for($i=0;$i<count($public_index);$count++){
//    if(explode("_",$public_index[$i])[2]==='date'){
//        echo 'date';
//    }
//}
//array_pop($public_elections);
//unset($public_elections[1]);
//print_r($invited_elections);

//if(count($created_elections)>0){
//    $created_elections_display.="<table>
//                                                    <tr>
//                                                        <th>Name</th>
//                                                        <th>Start Date</th>
//                                                        <th>End Date</th>
//                                                        <th>Start Time</th>
//                                                        <th>End Time</th>
//                                                        <th>Pin</th>
//														<th></th>
//                                                    </tr>";
//    for($create=0;$create<count($created_elections);$create++){
//        $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$created_elections[$create]['election_id'].rand(10000,99999).rand(100,999);
//        $created_elections_display.="<tr >";
//        $created_elections_display.="<td style='padding: 0 20px 5px 2px;border: none'>".$created_elections[$create]['election_name']."</td>
//                                     <td style='padding: 0 20px 5px 2px;border: none'>".dateString($created_elections[$create]['election_start_date'])."</td>
//                                     <td style='padding: 0 20px 5px 2px;border: none'>".dateString($created_elections[$create]['election_end_date'])."</td>
//                                     <td style='padding: 0 20px 5px 2px;border: none'>".timeString($created_elections[$create]['election_time_from'])."</td>
//                                     <td style='padding: 0 20px 5px 2px;border: none'>".timeString($created_elections[$create]['election_time_to'])."</td>
//                                     <td style='padding: 0 20px 5px 2px;border: none'>".$created_elections[$create]['election_pin']."</td>
//                                     <td><a href='#' onclick='created($key)'>Edit </a></td>";
//        $created_elections_display.="</tr>";
//    }
//}else{
//    $created_elections_display.="You are yet to create an election.";
//}

//for($i=0;$i<10;$i++){
//    print $i;
//    if($i===11){
//        break;
//    }
//}
?>
<!--<div >-->
<!--<form class="form-horizontal" role="form" id="706641944" action="--><?php //echo htmlspecialchars($_SERVER["PHP_SELF"])?><!--" method="post">-->
<!---->
<!--             <input type="radio" name="the Actual Post" value="contestant1">   <img src="../images/pic1.png" width=10% height="">-->
<!--            </div>-->
<!--            <div class = "col-xs-6 col-sm-4">-->
<!--                <input type="radio" name="the Actual Post" value="contestant2">   <img src="../images/pic1.png" width="10%" height="">-->
<!--            </div>-->
<!--            <div class = "col-xs-6 col-sm-4">-->
<!--                <input type="radio" name="the Actual Post" value="contestant3">   <img src="../images/pic1.png" width="10%" height="">-->
<!--            </div>-->
<!--            <input class="btn btn-primary" value="Cast Vote" type="submit" name="submit">-->
<!--</form>-->
<?php
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//        if(isset($_POST["the+Actual+Post"])){
//            $contestant_id= $_POST["the+Actual+Post"];
//            echo $contestant_id;
//        }
//
//
//}
$election_start=getElectionDetails(2)[0]['election_start_date'];
$election_time= getElectionDetails(2)[0]["election_time_from"];
$election_date_created=getElectionDetails(2)[0]['date_created'];
    echo $election_start;
    echo $election_time;
    echo $election_date_created;
if(){

}
    strtotime(date("Y-m-d"))== (strtotime($election_start) && (strtotime($election_time)-(60*60*3))<strtotime(date("H:i:s")))
?>