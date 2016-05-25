<?php
session_start();
if(session_destroy()) { // destroying all session
header("Location:../html/index.php"); // Redirecting to home page
}
?>