<?php
$election_id =$result1 ="";
include('function.php');
include_once('connection.php');
include_once('session.php');

//getting the election id from the key passed to the url
	$election_id = "";
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

			$news_query = "SELECT * FROM news WHERE election_id='$election_id' ORDER BY date_created DESC";
			$result = mysqli_query($connection2, $news_query);
			$get_result = mysqli_fetch_row($result);
/*
			if(mysqli_num_rows($result) > 0){
				//output data of each row
					while($row = mysqli_fetch_assoc($result)){
						$posted_news .= $row['news']."<br>".$row['date_created'] . "<br>";
					}
			}else{

			}*/
			$posted_news = "";
			
			if($get_result){
				do{
					$news_id = $get_result[0];
						for($i=1; $i<2; $i++){
							$posted_news .= "<div class= 'me'>".$get_result[$i];
							for($i=2; $i<3; $i++){
								$posted_news .= "Posted on: " . $get_result[$i] . "<br>";
							}
						}
                    $encrypted_news_id=rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$get_result[0].rand(10000,99999).rand(100,999);
					$posted_news.="<label a href='#' onclick='news($encrypted_news_id)'>Modify</a></label><p></div><p>";
				}while($get_result=mysqli_fetch_row($result));

			}else{
				$posted_news = "";
			}
	
		//getting the news_id from the URL
			$news_id = "";
			if(isset($_GET['under'])){
				$new_id = $_GET['under'];
                $news_id= substr($new_id,9,strlen($new_id)-17);
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
			

	//fetching those posted news by admin to modify 
			$query_news = "SELECT news FROM news WHERE news_id='$news_id'";
		
				if($result_news = mysqli_query($connection2, $query_news)){

				
				/*fetch associative array */
					while($row = mysqli_fetch_assoc($result_news)){

						$news_fetched = $row['news'];
					}
				}
		//getting election_id from the saved session
			if(isset($_SESSION['election_id'])){
        		$key = $_SESSION['election_id'];
    		}


    	//posting the update of news	
			$post_update = $updateErr = "";
			if(!empty($_POST['submit_update']) && isset($_POST['submit_update'])){
				$updateErr = false;
					if(empty($_POST['post_update'])){
						$updateErr = true;
					}else{
						$post_update = $_POST['post_update'];
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
			if(isset($_SESSION['election_id'])){
        		$nwElection_id = $_SESSION['election_id'];
    		}


    		//deleting news from the database
			$post_update = $updateErr = "";
			if(!empty($_POST['submit_delete']) && isset($_POST['submit_delete'])){
				$updateErr = false;
					if(empty($_POST['post_update'])){
						$updateErr = true;
					}else{
						$post_update = $_POST['post_update'];
					}

				if(!$updateErr){
					$query_update = "DELETE FROM news WHERE news_id='$news_id'";
						if(mysqli_query($connection2, $query_update)){
							header("Location:postnews.php?key=".$nwElection_id);
						}else{
						
						}
				}

			}



	//fetching to the view contestant page
			$election_id = "";
			if(isset($_GET['key'])){
				$view_election_id = $_GET['key'];
                $election_id= substr($view_election_id,9,strlen($view_election_id)-17);
                $_SESSION['election_id_view'] = $election_id;
			}

			//querying for news
			$view_news_query = "SELECT * FROM news WHERE election_id='$election_id' ORDER BY date_created DESC";
			$view_result = mysqli_query($connection2, $view_news_query);
			$view_get_result = mysqli_fetch_row($view_result);
		
			$view_posted_news = "";
			
			if($view_get_result){
				do{
						for($i=1; $i<2; $i++){
							$view_posted_news .= "<div class= 'me'>".$view_get_result[$i];
							for($i=2; $i<3; $i++){
								$view_posted_news .= "Posted on: " . $view_get_result[$i] . "<br></div>";
							}
						}
					
				}while($view_get_result = mysqli_fetch_row($view_result));

			}else{
				$view_posted_news = "";
			}

			//querying for election name
			$view_election_query = "SELECT * FROM election  WHERE election_id = '$election_id'";
			$view_election = mysqli_query($connection2, $view_election_query);
			$view_election_name = mysqli_fetch_row($view_election);

			$election_name = $election_details = "";

			if($view_election_name){
				do{
					for($i=1; $i<2; $i++){
						$election_name .= $view_election_name[$i];
						for($i=2; $i<3; $i++){
							$election_details .= "Start Date: ".dateString($view_election_name[$i])."<br>";
							for($i=4; $i<5; $i++){
								$election_details .= "Start Time: ".timeString($view_election_name[$i])."<br>";
								for($i=3; $i<4; $i++){
									$election_details .= "End Date: ".dateString($view_election_name[$i])."<br>";
									for($i=5; $i<6; $i++){
										$election_details .= "End Time: ".timeString($view_election_name[$i]);
									}
								}
							}
						}
					}
				}while($view_election_name = mysqli_fetch_row($view_election));
			}else{
				$election_name = "";
			}
			//getting the user_id for a particular election
			$images_dir = "../images/users/";
			$election_user_id = "SELECT user_id FROM election WHERE election_id = '$election_id'";
			$user_id_result = mysqli_fetch_row(mysqli_query($connection2, $election_user_id));

			//querying to get the admin email
			$view_user = "SELECT * FROM  users WHERE user_id = '$user_id_result[0]'";
			$view_user_name = mysqli_query($connection2, $view_user);
			$view_user_details = mysqli_fetch_row($view_user_name);

			$election_admin_details = $election_admin_detail = "";

			if($view_user_details){
				do{
					for($i=1; $i<2; $i++){
						$election_admin_details .= "<div class='dem'>Name: ".$view_user_details[$i]."&nbsp";
						for($i=2; $i<3; $i++){
							$election_admin_details .= $view_user_details[$i]. "<br>";
							for($i=3; $i<4; $i++){
								$election_admin_details .= "Username: ".$view_user_details[$i]."<br>";
								for($i=4; $i<5; $i++){
									$election_admin_details .= "Email: ".$view_user_details[$i]."<br>";
									for($i=5; $i<6; $i++){
										$election_admin_details .= "Telephone: ".$view_user_details[$i]. "</div>";
										for($i=10; $i<11; $i++){
											$election_admin_detail .= "<div class='dem1'><img src=".$images_dir.$view_user_details[$i]." id='displayedPhoto'></div>";
										}
									}
								}
							}
						}
					}
				}while($view_user_details = mysqli_fetch_row($view_user_name));
			}else{
				$election_admin_details = "";
			}

		

?>