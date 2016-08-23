<?php

//Create connection
require_once("database.php");
include_once('connection.php');
include_once('function.php');
if (!$connection1)
{
    die(
    "We are really sorry to inform you that the server is currently down. This will be fixed as soon as possible. We
    hereby apologise for every inconveniences caused. Thank you.");
}

$fname=$lname=$username=$password1=$password2=$email=$phone=$sex=$lemail=$lpassword=$error=$lerror=$lmainError=$mainError=$confirmationMessage=$picture_name= $output =$output2= "";
    //check if user wants to be confirmed
    if(isset($_GET["confirm_me"])){
        $this_user_coded=$_GET["confirm_me"];
        $this_user_id=base64_decode((explode("_",$this_user_coded)[0]));
        $this_user_email=base64_decode(explode("_",$this_user_coded)[1]);
        $lemail=$this_user_email;
        //get the status of this user
        $this_user_status=getAllMembers("users",["status"],["user_id","=",$this_user_id],0,"AND",["email","=",$this_user_email])[0]["status"];
        //check if the id and email is nonsense
        if($this_user_status==""){
            //redirect to index.php
            header("Location:index.php");
        }elseif($this_user_status==1){
            $confirmationMessage="<span style='color: red'>Your account has already been activated.You can now login.</span>";
        }elseif($this_user_status==0){
            $update_status_query="UPDATE users SET status='1' WHERE user_id='$this_user_id'";
            if($connection1->query($update_status_query)){
                $confirmationMessage="<span style='color: #008000'>Account has been successfully activated.You can now login.</span>";
            }else{
                $confirmationMessage="<span style='color: red'>Account activation not successful.Click on the link in your email again.</span>";
            }
        }
    }

if(!empty($_POST["register"]) && isset($_POST["register"])) {

    $fname = removeSpace(stripcslashes($_POST["fname"]));
    $lname = removeSpace(stripcslashes($_POST["lname"]));
    $username = removeSpace2(stripcslashes($_POST["username"]));
    $password1 = removeSpace2(stripcslashes($_POST["password1"]));
    $password2 = removeSpace2(stripcslashes($_POST["password2"]));
    $email = removeSpace2(stripcslashes($_POST["email"]));
    $phone = removeSpace2(stripcslashes($_POST["phone"]));
    $sex = stripcslashes($_POST["sex"]);

    $error = false;

    //Validating create account form

    if(!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname)){
        $mainError = "Name is not valid";
        $error = true;
    }

    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $mainError = "Only letters and numbers are required";
        $error = true;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mainError = "Invalid email address";
        $error = true;
    }

    if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone)) {
        $mainError = "Invalid phone number";
        $error = true;
    }

    if($password1<>$password2){
        $mainError = "Password does not match";
        $error = true;
    }else{
        $hashedpassword = md5($password1);
    }


    if(empty($fname) || empty($lname) || empty($username) || empty($password1) || empty($password2) || empty($email) || empty($phone) || empty($sex)) {
        $mainError = "All fields are required";
        $error = true;
    }

    //Querying table users in eVoting database

    if(!$error) {
        $result = getAllMembers("users",["email"],["email","=",$email]);
        $result1 = getAllMembers("users",["email"],["username","=",$username]);


        if (count($result) != 0 && count($result1)!=0) {
            $mainError = "Email and Username already exist";

        }else if(count($result)!=0){
            $mainError = "Email already exist";

        }else if(count($result1)){
            $mainError = "Username already exist";

        } else {
            //get data's to be encoded in mail
            $last_id=getAllMembers("users",["MAX(user_id)"])[0]["MAX(user_id)"]+1;
            $coded=base64_encode(($last_id))."_".base64_encode($email);
//            //send confirmation mail
            $recipient_name = strtoupper($fname)." ".$lname;
            $subject = "Activate your online voting account.";
            $body = "Hello ".$username.".<br>
                 You are welcome to Obafemi Awolowo University online voting system.<br>
                 This is to notify you that your email address has been used to create an
                 account with us. Kindly ignore this mail if your account was used without your consent.
                 If not, click on <a href='http://evoting.oauife.edu.ng/html?confirm_me=".$coded."'>Activate account.</a>
                  to activate your account.Thank you.";

//            $mail->AltBody = "";
            if(SendEmail($email,$recipient_name,$subject,$body)){
                $sql = "INSERT INTO users(fname, lname, username, email, phone, password, gender)
                            VALUES('" . ucwords($fname) . "', '" . ucwords($lname) . "', '" . $username . "', '" . $email . "', '" . $phone . "', '" . $hashedpassword ."','" . $sex . "')";

                if ($connection1->query($sql)) {
                    //Invite the signed up user for an election he has been invited
                    $output = "<span style='color: #008000'>Account created successfully. Check Your email For verification.</span>";
                    $electionId=$election_start=$election_time=$invite_message="";
                    $invite_query= $connection1->prepare("SELECT * FROM ignored WHERE email='$email'");
                    $invite_query->execute();
                    $invite_result=$invite_query->setFetchMode(PDO::FETCH_ASSOC);
                    $invite_result=$invite_query->fetchAll();

                    if(!empty($invite_result)){
                        for($i=0;$i<count($invite_result);$i++) {
                            $electionId = $invite_result[$i]['election_id'];
                            $electionDetails = getElectionDetails($electionId);
                            $election_start = $electionDetails[0]['election_start_date'];
                            $election_time = $electionDetails[0]['election_time_from'];
                            $invite_date = $invite_result[$i]["ignored_date"];
                            if (!concluded($election_start,$election_time,7200)) {
                                $insertQuery = "INSERT INTO invites (user_id, election_id, invite_date) VALUES ('$last_id', '$electionId', '$invite_date')";
                                if ($connection1->query($insertQuery)) {
                                    $deleteQuery = "DELETE FROM ignored WHERE email='$email' AND election_id='$electionId'";
                                    $connection1->query($deleteQuery);

                                }
                            }
                        }
                    }

//                    header("Location:../html/index.php?key=".$output);
                    $fname=$lname=$email=$username=$phone=$password1=$password2=$sex="";

                } else {
                    $mainError = "Account creation unsuccessful";
                    /*header("Location:../html/signup.php#register");*/
                }
            }else{
                //the mail was not sent due to some issues,probably network
                $mainError="Your connection is lost. Ensure you have an active internet connection";
            }

        }
    }


}
//Querying table users from eVoting database for login

if(!empty($_POST["login"]) && isset($_POST["login"])){


    $lemail = stripcslashes($_POST["lemail"]);
    $lpassword = stripcslashes($_POST["lpassword"]);

    $lerror = false;

    if(empty($lemail) || empty($lpassword)){
        $lmainError = "Invalid email or password. ";
        $lerror = true;
    }else{
        $mistake = [
            'Hackinwale.adetola@gmail.com',
            'Dgreatkenny@gmail.com',
            'Sofiebereshepherd@gmail.com',
            'Saopayne@gmail.com',
            'Afolabi.michael@ymail.com',
            'Afomic1@gmail.com',
            'Bellomuba.rak0@gmail.com',
            'Olaiyaezekiel@gmail.com',
            'Adeniranyusufabdullateef@gmail.com',
            'Oladayo225@gmail.com',
            'Drniyi4u@gmail.com',
            'Eopeyemie@gmail.com',
            'Hafizferanmi@gmail.com',
            'Odunlamisamuel4@gmail.com',
            'Ifyveronica7@gmail.com',
            'Olaiyaomotayo009@yahoo.com',
            'Donleyduke2@gmail.com'
        ];
        if (in_array(ucwords($lemail),$mistake))
        {
            $lhashedpassword = md5(ucwords($lpassword));
            $lemail = ucwords($lemail);
        }else
        {
            $lhashedpassword = md5($lpassword);
        }
    }


    if(!$lerror){

        $result2 = getAllMembers("users",["email","status"],["email","=",$lemail],0,"AND",["password","=",$lhashedpassword]);


        if(count($result2) > 0){
            //check status
            $status = $result2[0]["status"];
            if($status == 0){
                $lmainError="Sorry, you are yet to confirm your email. A confirmation<br> mail has already
                                been sent to your mailbox.";
            }else{
                session_start();
                $_SESSION['login_user']=$result2[0]["email"];
                $_SESSION['adek_link']='';
                $_SESSION['adek_status']='';
                header('Location:maindashboard.php');
            }


        }else{
            $lmainError = "Invalid email or password.";
        }
    }

}


?>
