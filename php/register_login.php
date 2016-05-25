<?php

//Create connection
require_once("database.php");
include_once('connection.php');
include_once('function.php');
require_once "../PHPMailer/vendor/autoload.php";

//Check connection
if(!$connection2){
    die("Connection failed: " . mysqli_connect_error());
}

$fname=$lname=$username=$password1=$password2=$email=$phone=$sex=$lemail=$lpassword=$error=$lerror=$lmainError=$mainError=$confirmationMessage=$picture_name= $output =$output2= "";
    //check if user wants to be confirmed
    if(isset($_GET["confirm_me"])){
        $this_user_coded=$_GET["confirm_me"];
        $this_user_id=base64_decode((explode("_",$this_user_coded)[0]));
        $this_user_email=base64_decode(explode("_",$this_user_coded)[1]);
        //get the status of this user
        $status_query="SELECT status FROM users WHERE user_id='$this_user_id' AND email='$this_user_email'";
        $get_status=mysqli_fetch_row(mysqli_query($connection2,$status_query));
        $this_user_status=$get_status[0];
        //check if the id and email is nonsense
        if($this_user_status==""){
            //redirect to index.php
            header("Location:index.php");
        }elseif($this_user_status==1){
            $confirmationMessage="<span style='color: red'>Your account has already been activated.You can now login.</span>";
        }elseif($this_user_status==0){
            $update_status_query="UPDATE users SET status='1' WHERE user_id='$this_user_id'";
            if(mysqli_query($connection2,$update_status_query)){
                $confirmationMessage="<span style='color: #008000'>Account has been successfully activated.You can now login.</span>";
            }else{
                $confirmationMessage="<span style='color: red'>Account activation not successful.Click on the link in your email again.</span>";
            }
        }
    }

if(!empty($_POST["register"]) && isset($_POST["register"])) {

    $fname = mysqli_real_escape_string($connection2, $_POST["fname"]);
    $lname = mysqli_real_escape_string($connection2, $_POST["lname"]);
    $username = mysqli_real_escape_string($connection2, $_POST["username"]);
    $password1 = mysqli_real_escape_string($connection2, $_POST["password1"]);
    $password2 = mysqli_real_escape_string($connection2, $_POST["password2"]);
    $email = mysqli_real_escape_string($connection2, $_POST["email"]);
    $phone = mysqli_real_escape_string($connection2, $_POST["phone"]);
    $sex = mysqli_real_escape_string($connection2, $_POST["sex"]);

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
        $query = "SELECT email FROM users WHERE email='" . $email . "' ";
        $result = mysqli_query($connection2, $query);
        $query1 = "SELECT username FROM users WHERE username='".$username."' ";
        $result1 = mysqli_query($connection2, $query1);


        if (mysqli_num_rows($result) != 0 && mysqli_num_rows($result1)!=0) {
            $mainError = "Email and Username already exist";

        }else if(mysqli_num_rows($result)!=0){
            $mainError = "Email already exist";

        }else if(mysqli_num_rows($result1)){
            $mainError = "Username already exist";

        } else {
            //get datas to be encoded in mail
            $last_id=mysqli_fetch_array(mysqli_query($connection2,"SELECT MAX(user_id) FROM users"))[0]+1;
            $coded=base64_encode(($last_id))."_".base64_encode($email);
            //send confirmation mail
            $mail = new PHPMailer;

            //Enable SMTP debugging.
            $mail->SMTPDebug = 3;
            //Set PHPMailer to use SMTP.
            $mail->isSMTP();
            //Set SMTP host name
            $mail->Host = "smtp.gmail.com";
            //Set this to true if SMTP host requires authentication to send email
            $mail->SMTPAuth = true;
            //Provide username and password
            $mail->Username = "oauevoting@gmail.com";
            $mail->Password = "webo2016";
            //If SMTP requires TLS encryption then set it
            $mail->SMTPSecure = "tls";
            //Set TCP port to connect to
            $mail->Port = 587;

            $mail->From = "noreply@oauevoting.com";
            $mail->FromName = "OAU E-voting system.";
            $mail->addReplyTo("noreply@oauevoting.com");

            $mail->addAddress($email, strtoupper($fname)." ".$lname);

            $mail->isHTML(true);

            $mail->Subject = "Activate your online voting account.";
            $mail->Body = "Hello ".$username.".<br>
                 You are welcome to Obafemi Awolowo University online voting system.<br>
                 This is to notify you that your email address has been used to create an
                 account with us. Kindly ignore this mail if your account was used without your consent.
                 If not, click on <a href='http://localhost/E-votingOO/html/index.php?confirm_me=".$coded."'>Activate account.</a>
                  to activate your account.Thank you.";

            $mail->AltBody = "This is the plain text version of the email content";

            if($mail->send()){
                $sql = "INSERT INTO users(fname, lname, username, email, phone, password, gender)
                            VALUES('" . ucwords($fname) . "', '" . ucwords($lname) . "', '" . $username . "', '" . $email . "', '" . $phone . "', '" . $hashedpassword ."','" . $sex . "')";

                if (mysqli_query($connection2, $sql)) {
                    //Invite the signed up user for an election he has been invited
                    $output = "Account Created Successfully, Check Your Email For confirmation.";
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
                            $invite_date = $electionDetails[0]['date_created'];
                            if (!concluded($election_start,$election_time,7200)) {
                                $insertQuery = "INSERT INTO invites (user_id, election_id, invite_date) VALUES ('$last_id', '$electionId', '$invite_date')";
                                if (mysqli_query($connection2, $insertQuery)) {
                                    $deleteQuery = "DELETE FROM ignored WHERE email='$email' AND election_id='$electionId'";
                                    if (mysqli_query($connection2, $deleteQuery)) {
                                        $invite_message = "You have been invited to participate in an election";
                                        //header("Location:index.php#login");
                                    }
                                }
                            }
                        }
                    }
                    
                    header("Location:../html/index.php?key=".$output);

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

    $lemail = mysqli_real_escape_string($connection2, $_POST["lemail"]);
    $lpassword = mysqli_real_escape_string($connection2, $_POST["lpassword"]);

    $lerror = false;

    if(empty($lemail) || empty($lpassword)){
        $lmainError = "Invalid username or password ";
        $lerror = true;
    }else{
        $lhashedpassword = md5($lpassword);
    }


    if(!$lerror){
        $query2 = "SELECT email, password, status FROM users WHERE email='".$lemail."' AND password='".$lhashedpassword."'  ";
        $result2 =mysqli_query($connection2, $query2);


        if(mysqli_num_rows($result2) !=0){
            //check status
            $result2=mysqli_fetch_row($result2);
            if($result2[2]==0){
                $lmainError="Sorry, you are yet to confirm your email. A confirmation<br> mail has already
                                been sent to your mailbox.";
            }else{
                session_start();
                $_SESSION['login_user']=$lemail;
                $_SESSION['adek_link']='';
                $_SESSION['adek_status']='';
                header('Location:maindashboard.php');
            }


        }else{
            $lmainError = "Invalid username or password";
        }
    }

    mysqli_close($connection2); // closing connection
}


