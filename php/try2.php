<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/29/16
 * Time: 3:22 PM
 */
//include('connection.php');
////$start_time=$_POST["start_hour"]+$_POST["start_period"].':'.$_POST["start_minute"].':'.$_POST["start_second"];
////$end_time =$_POST["end_hour"]+$_POST["end_period"].':'.$_POST["end_minute"].':'.$_POST["end_second"];
////print $start_time.'<br>'.$end_time;
////print $_POST['time'];
//$has_started_query="SELECT election_start_date FROM election WHERE election_id='1'";
//$has_started= mysqli_query($connection2,$has_started_query);
//$has_started= mysqli_fetch_row($has_started)[0];
//print strtotime($has_started);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment Attempt</title>
    <script type="text/javascript" src="Assignment.js"></script>
</head>
<body>
<h1>Welcome To Library of Books</h1>
<p id="display"></p>
<script>
//    function Library(){
//        var name;
//        var location;
//        function Bookself(){
//
//        }
//    }
//    document.getElementById("display").innerHTML="t";
//    document.getElementById("display").innerHTML="this is the";
//    console.log("this is a book");
</script>
<?php
$uploadErr="";$success="";$contestant_picture_name = "";
if(isset($_POST["upload"])) {
    $target_dir ="../images/contestants/";
    if (!empty($_FILES["image"]["name"])) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        $folderIsWritable = is_writable($target_dir);
        if ($folderIsWritable) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                //$uploadErr = "File is an image " . $check["mime"];
                if (!($imageFileType != 'jpeg' || $imageFileType != "png" || $imageFileType != "gif" || $imageFileType != "jpg")) {
                    $uploadErr = "Only images with jpeg, png, gif, or jpg is allowed";
                    $uploadOK = 0;
                } elseif (($_FILES["image"]["size"] ==0 || $_FILES["image"]["size"] < 35000)) {
                    $uploadErr = "Only images with minimum size of 20kb and max size of 500kb are allowed";
//                } elseif (file_exists($target_file)) {
//                    $uploadErr = "The file with the same name as the file being uploaded is already existing";
                } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $contestant_picture_name = basename($_FILES["image"]["name"]);
                    $success = "The file was successfully uploaded";
                    $uploadOK = 1;
                } else {
                    $success = "The file was not successfully uploaded.";
                }

            } else {
                $uploadOK = 0;
                $uploadErr = "File is not an image";
            }

        } else {
            trigger_error("Sorry cannot currently write to folder images");
            $success = "false";
        }
    } else {
        $uploadErr = "No image file has been chosen yet please choose a valid picture.";
    }
}
?>
<pre>
<?php
if(isset($_POST["upload"])){
    print_r($_FILES["image"]);
}
?>
</pre>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
    <p>
        <input type="file" name="image">
        <?php echo $uploadErr?><?php echo $success; ?>
    </p>
    <p>
        <input type="submit" name="upload" value="upload">
    </p>
    <p>
        <img src="" alt="image is here" height="200px" width="200px">
    </p>
    <p>
        <img src="" alt="image is here" height="200px" width="200px">
    </p>
</form>



</body>
</html>