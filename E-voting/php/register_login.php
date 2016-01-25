<?php

//Create connection
include('connection.php');

//Check connection
if(!$connection2){
    die("Connection failed: " . mysqli_connect_error());
}

$fname=$lname=$username=$password1=$password2=$email=$phone=$sex=$lemail=$lpassword=$error=$lerror=$lmainError=$mainError="";
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


            $sql = "INSERT INTO users(fname, lname, username, email, phone, password)
                            VALUES('" . $fname . "', '" . $lname . "', '" . $username . "', '" . $email . "', '" . $phone . "', '" . $hashedpassword . "')";


            if (mysqli_query($connection2, $sql)) {
                header("Location:index.php");



            } else {
                echo "Account creation unsuccessful";
                header("Location:signup.php");
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
        $query2 = "SELECT email, password FROM users WHERE email='".$lemail."' AND password='".$lhashedpassword."'  ";
        $result2 =mysqli_query($connection2, $query2);


        if(mysqli_num_rows($result2) !=0){
            session_start();
            $_SESSION['login_user']=$lemail;
            header('Location:maindashboard.php');

        }else{
            $lmainError = "Invalid username or password";
        }
    }

    mysqli_close($connection2); // closing connection
}


?>
