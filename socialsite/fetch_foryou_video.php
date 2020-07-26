 <?php
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/time_function.php");
$s_id = $_SESSION['id'];
$check_path = filter_var(htmlspecialchars($_POST['path']),FILTER_SANITIZE_STRING);
$plimit = filter_var(htmlspecialchars($_POST['plimit']),FILTER_SANITIZE_NUMBER_INT);
$p_privacy = "2";
$emptypost = "";
$vpsql = "SELECT * FROM wpost WHERE post_vid IS NOT NULL AND p_privacy != :p_privacy  ORDER BY post_time DESC";
$view_posts = $conn->prepare($vpsql);
$view_posts->bindValue(':p_privacy', $p_privacy, PDO::PARAM_INT);
$view_posts->execute();
$view_postsNum = $view_posts->rowCount();
if ($view_postsNum > 0) {
	include "includes/fetch_posts.php";
}else{
	echo "0";
}