
 <?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/time_function.php");
if(!isset($_SESSION['Username'])){
    header("location: index");
}
if (is_dir("imgs/")) {
        $check_path = "";
    }elseif (is_dir("../imgs/")) {
        $check_path = "../";
    }elseif (is_dir("../../imgs/")) {
        $check_path = "../../";
    }
?> 
	
<?php
session_start();
$s_id = $_SESSION['id'];
$p_privacy = "0";
$vpsql = "SELECT * FROM wpost WHERE ( p_privacy = :p_privacy)  ORDER BY post_time DESC ";
$view_posts = $conn->prepare($vpsql);
$view_posts->bindValue(':p_privacy', $p_privacy, PDO::PARAM_INT);
$view_posts->execute();
$view_postsNum = $view_posts->rowCount();
if ($view_postsNum > 0) {
	include "includes/fetch_posts.php";
}else{
	echo "0";
}
?>