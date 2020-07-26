<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Kolkata'); 
session_start();
$s_id = $_SESSION['id'];
$page="post";
$v_time = time();
$current_time   = time();
$visible_hours="+23 hour +16 minutes +18seconds";
$startTime = date("Y-m-d H:i:s");
echo 'Starting Time: '.$startTime;

//add 1 hour to time
$cenvertedTime = date('Y-m-d H:i:s',strtotime($visible_hours,strtotime($startTime)));
//display the converted time
echo 'Converted Time (added 1 hour): '.$cenvertedTime;

include("../config/connect.php");
include("../includes/fetch_users_info.php");
include ("../includes/time_function.php");
include ("../includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: ../index");
}
if (is_dir("imgs/")) {
    $check_path = "";
}elseif (is_dir("../imgs/")) {
    $check_path = "../";
}elseif (is_dir("../../imgs/")) {
    $check_path = "../../";
}
?>
<html>
<head>
    <title>Post | Webapp</title>
    <meta charset="UTF-8">
    <meta name="description" content="This webapp is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,Wallstant,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
	<style>
	html, body {
    max-width: 100%;
    overflow-x: hidden;
}
.modal.bottom-sheet{
	max-height:60%;
	background:white;
	border-top-left-radius: 20px; 
    border-top-right-radius: 20px;
	padding-top:10px;
	overflow: auto;
}
.galleryItem img {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.galleryItem{
    color: #797478;
    font: 10px/1.5 Verdana, Helvetica, sans-serif;
    float: left;    
    width:50%;
	height:200px;	
}
@media only screen and (max-width : 720px),
only screen and (max-device-width : 720px){
    .galleryItem {height:150px;}
}
.header{width:100%;padding:10px 0; background:#f9f9f9;box-shadow:0 0 10px 2px rgba(0,0,0,0.1);position:fixed;background:red;padding-bottom:13px;}
.header img {width:20px;position:absolute;top:10px; cursor:pointer;}
.header p{color:#007aff;text-align:center;}
.report{
	margin-top:40px;
}
	</style>
</head>
<body>
<div class="header">
  <img src="imag/image2.jpg" class="menu-icon">
  <p>MEET APP </p>
</div>
<div class="container-fluid">
<div style="margin:0px auto; max-width:600px;">
        <div>
        <?php
                $post_id = filter_var(htmlentities($_GET['pid']), FILTER_SANITIZE_NUMBER_INT);
				$group_id = filter_var(htmlentities($_GET['gid']), FILTER_SANITIZE_NUMBER_INT);
				if($group_id=="" or $group_id==0){
                $checkFromPost_sql = "SELECT * FROM wpost WHERE post_id = ?";
				}else{
					 $checkFromPost_sql = "SELECT * FROM wgpost WHERE post_id = ?";
				}
                $checkFromPost_params = array($post_id);
                $view_posts = $conn->prepare($checkFromPost_sql);
        $view_posts->execute($checkFromPost_params);
        include "../includes/fetch_notify_post.php";
        ?>
		</div>
		<?php
		if (!empty($image)){
	     echo "image inclue in this post";
          }
		 elseif(!empty($video)){
				echo "vieo inclue in this post";
			}
			else{
				echo "text include;";
			}
		?>
		<?php
	$visible_sql = "SELECT visible FROM wpost WHERE post_id=:post_id";
	$visible = $conn->prepare($visible_sql);
    $visible->bindParam(':post_id',$post_id,PDO::PARAM_INT);
    $visible->execute();
	$visible_time=$visible->rowCount();
	while($visible_post =$visible->fetch(PDO::FETCH_ASSOC)){
			$postvisible=$visible_post['visible'];
			/*$minutes_to_add = 2 . 'S';
			$time = new DateTime();
			$time->add(new DateInterval('PT' . $minutes_to_add));
			$stamp = $time->format('Y-m-d H:i:s');
			echo $stamp;*/
				//echo $postvisible;
	}
	echo $postvisible;
    $checkview_sql = "SELECT * FROM view WHERE viewer=:s_id AND post_id=:post_id";
    $checkview = $conn->prepare($checkview_sql);
    $checkview->bindParam(':s_id',$s_id,PDO::PARAM_INT);
    $checkview->bindParam(':post_id',$post_id,PDO::PARAM_INT);
    $checkview->execute();
    $checknum = $checkview->rowCount();
	echo $checknum;
    if ($checknum > 0) {
		
    }
	else{		
	echo $postvisible;
  /*  $view_sql = "INSERT INTO view (viewer,post_id,view_time) VALUES (:s_id, :post_id,:v_time)";
    $view = $conn->prepare($view_sql);
    $view->bindParam(':s_id',$s_id,PDO::PARAM_INT);
    $view->bindParam(':post_id',$post_id,PDO::PARAM_INT); 
	$view->bindParam(':v_time',$v_time,PDO::PARAM_INT); 
    $view->execute();
        // update likes number
        $views_sql = "SELECT id FROM view WHERE post_id=:post_id";
        $views = $conn->prepare($views_sql);
        $views->bindParam(':post_id',$post_id,PDO::PARAM_INT);
        $views->execute();
        $views_num = $views->rowCount();
        $makeChangeSql = "UPDATE wpost SET p_view=:views_num WHERE post_id=:post_id";
        $makeChange = $conn->prepare($makeChangeSql);
        $makeChange->bindParam(':views_num',$views_num,PDO::PARAM_INT);
        $makeChange->bindParam(':post_id',$post_id,PDO::PARAM_INT);
        $makeChange->execute();
		
		$visible_sql = "SELECT visible FROM wpost WHERE post_id=:post_id";
		$visible = $conn->prepare($visible_sql);
        $visible->bindParam(':post_id',$post_id,PDO::PARAM_INT);
        $visible->execute();
		$visible_time=$visible->rowCount();
		while($visible_post =$visible->fetch(PDO::FETCH_ASSOC)){
			$postvisible=$visible_post['visible'];
			/*$minutes_to_add = 2 . 'S';
			$time = new DateTime();
			$time->add(new DateInterval('PT' . $minutes_to_add));
			$stamp = $time->format('Y-m-d H:i:s');
			echo $stamp;*/
				echo $postvisible;
		}
	
		if($postvisible != 0){
		$viewVisibleSql = "UPDATE view SET novisible=:s_id WHERE view_time <= :postvisible";
        $setVisible = $conn->prepare($viewVisibleSql);
        $setVisible->bindParam(':s_id',$s_id,PDO::PARAM_INT);
        $setVisible->bindParam(':postvisible',$postvisible,PDO::PARAM_INT);
        if($setVisible->execute()){echo "excute";}
		else{echo "not excute";};
		}
		else{
			
		}*/
	}
?>		
		
</div>
</div>
<?php include "../includes/endJScodes.php"; ?>
</body>
</html>
