<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/26/16
 * Time: 11:00 AM
 */
//start session
session_start();
if(isset($_SESSION['login_user'])){
    $myemail = $_SESSION['login_user'];
    if(isset($_POST["pin"])){
        //open mysqli connection
        include_once('connection.php');
        //collect pin
        $election_pin=$_POST['pin'];
        //check if pin is valid
        $election_pin_query="SELECT election_id,election_pin FROM election WHERE election_pin='$election_pin'";
        $election_query= mysqli_query($connection2,$election_pin_query);
        $election = mysqli_fetch_row($election_query);
       //check if election is present
        if($election){
            //get user_id
            $user_id_query= "SELECT user_id FROM users WHERE email='$myemail'";
            $user_hidee= mysqli_query($connection2,$user_id_query);
            $user_id= mysqli_fetch_row($user_hidee);

            //check if user have joined the election before
            $if_joined_query= "SELECT joined_id FROM joined WHERE user_id='$user_id[0]' AND election_id='$election[0]'";
            $if_joined = mysqli_query($connection2,$if_joined_query);
            $joined = mysqli_fetch_row($if_joined);

            //check if request has been sent before
            $if_request_query= "SELECT request_id FROM request WHERE user_id='$user_id[0]' AND election_id='$election[0]'";
            $if_request = mysqli_query($connection2,$if_request_query);
            $request= mysqli_fetch_row($if_request);

            //check if if is the admin that is making a request to join his/her created election
            $if_admin_query="SELECT election_id FROM election WHERE user_id='$user_id[0]' AND election_id='$election[0]'";
            $if_admin=mysqli_query($connection2,$if_admin_query);
            $admin = mysqli_fetch_row($if_admin);

            //check if election has started
            $has_started_query="SELECT election_start_date FROM election WHERE election_id='$election[0]'";
            $has_started= mysqli_query($connection2,$has_started_query);
            $has_started= mysqli_fetch_row($has_started)[0];

            if(count($joined)===1){
                echo '<p >You are already a part of this election.There is no need to send request.Thank you.</p>';

            }elseif(count($request)===1){
                echo 'You have already send a request to the admin of this election.Just hold on till your request is granted.Thank you.';

            }elseif(count($admin)===1){
                echo 'You are the admin of this election.There is no need to send any invite.';
            }elseif(strtotime(date('Y-m-d'))>=(strtotime($has_started))-strtotime(date('0-0-1'))){
               echo 'Voting for this election will commence in less 24hrs.Therefore your request cannot be processed.';
            }else{
                //insert data into request table
                $insert_query= "INSERT INTO request (request_id,user_id,election_id) VALUES (NULL,'$user_id[0]','$election[0]')";
                $insertion= mysqli_query($connection2,$insert_query);
                //check if request is successfully processed
                if(mysqli_affected_rows($connection2)===1){
                    // inform user request has been sent
                    echo '<p style="color: #008000">Request has been passed  to the admin successfully.</p>';
                }else{
                    //inform user to join election through other means cos this method is currently not available
                   echo 'Request processing not successful.The problem will be fixed soon.Send your request later or contact the admin to add you up manually.';
                }
            }
        }else{
            echo 'INVALID PIN.';
        }
    }
}
