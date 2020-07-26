
<?php
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/time_function.php");
include ("includes/num_k_m_count.php");
$s_id = $_SESSION['id'];
$check_path = filter_var(htmlspecialchars($_POST['path']),FILTER_SANITIZE_STRING);
$plimit = filter_var(htmlspecialchars($_POST['plimit']),FILTER_SANITIZE_NUMBER_INT);
$p_privacy = "2";
$emptypost = "";
$vpsql = "SELECT * FROM wpost WHERE  post_audio!= ? AND author_id IN 
(SELECT uf_two FROM follow WHERE uf_one=?) AND p_privacy != ? ORDER BY post_time DESC";
$params = array("$emptypost","$s_id", "$p_privacy");
$view_posts = $conn->prepare($vpsql);
$view_posts->execute($params);
$view_postsNum = $view_posts->rowCount();
if ($view_postsNum > 0) {
	include "includes/fetch_posts.php";
}else{
	echo "0";
}
?>