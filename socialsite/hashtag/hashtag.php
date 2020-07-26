<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("../config/connect.php");
include ("../includes/time_function.php");
include ("../includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: ../home");
}
if (is_dir("imgs/")) {
        $check_path = "";
    }elseif (is_dir("../imgs/")) {
        $check_path = "../";
    }elseif (is_dir("../../imgs/")) {
        $check_path = "../../";
    }
?>
<html lang="en">
<head>
  <title><?php echo "Hashtag - ".$_GET['tag'];if($_GET['tag'] == 'search'){echo "Hashtag";} ?> | Wallstant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include "../includes/head_imports_main.php";?>
  <link rel="stylesheet" href="../css/home.css">
  <style>
  *{margin:0px;padding:0px;}
.roh{  padding-right:10px;margin-top:6px; display: block;float:left; margin-left:5px;cursor:pointer;}
a {
    text-decoration: none;
    color: inherit;
    margin: 0;
}
.main-navigation {
    width: 100%;
    background:white;
    text-align: center;
    position: fixed;
    bottom: 0;
	box-shadow: 0px 0px 18px rgba(63, 81, 181, 0.16);
}

nav ul {
    list-style: none;
    padding: 0;
    color: gray;
    margin: 0;
}

nav li {
    display: inline-block;
    width: calc(100vw / 5.6);
    padding: 7px;
}

nav p {
    margin: 0;
    font-size: .9em;
}

nav li:hover {
    transform: scale(1.2);
    transition: 1s;
}


@media (max-width: 782px){
    nav li {
        width: calc(100vw / 5.6);
        
    }
    .fa-2x {
        font-size: 1.8em;
    }
    nav p{
        display: none;
    }
}
.selected_ht{
    background: rgba(0, 144, 255, 0.8);
    padding: 3px 5px;
    border-radius: 3px;
    box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.06);
    color: #ffffff;
    cursor: pointer;
    text-decoration: none;
    }
    .selected_ht:hover,.selected_ht:focus{
    color: #ffffff;
    text-decoration: none;
    }
  </style>
</head>
<body>
<div class="container">
<div>
 <main role="main">
  <h4 style="text-align:center;">Videos</h4>
</div>
          <hr/>
		</main> 
		</div>
</div>  
<div class="container">
<div style="margin:0px auto; max-width:560px;">
<?php
$s_id = $_SESSION['id'];
if(isset($_GET['tag'])){
$q = "#".htmlentities($_GET['tag'], ENT_QUOTES);
$search_sql = "SELECT * FROM wpost WHERE post_content LIKE ? AND p_privacy != ? AND p_privacy != ? ORDER BY post_time DESC LIMIT 8";
$params = array("%$q%", "1", "2");
$view_posts = $conn->prepare($search_sql);
$view_posts->execute($params);
$search_num = $view_posts->rowCount();
if ($search_num > 0) {
$isHashTagPage="yep";
include "../includes/fetch_posts.php";
}else{
?>
<div class="post">
<table class='user_follow_box'>
<tr>
<td><img src='../imgs/main_icons/2139.png' style='border-radius: 100%;width:52px;height:52px;' /></td>
<td style='width: 100%;'>
<p><?php echo _NOTHINGSHOW ; ?><br><span style='font-size: small;color:gray;'><?php echo _HASHTAG_NOT_AVAILABLE; ?></span></p>
</td>
</tr>
<tr style="margin: 10px">
<td></td>
    <td>
<hr>
<?php
$s_country = $_SESSION['country'];
$s_country = str_replace(' ', '_', $s_country);
echo "
    <a href='../hashtag/"._NEWS."' class='selected_ht' title='#"._NEWS."'>#"._NEWS."</a>&nbsp;
    <a href='../hashtag/"._tv."' class='selected_ht' title='#"._tv."'>#"._tv."</a> &nbsp;
    <a href='../hashtag/"._STORE."' class='selected_ht' title='#"._STORE."'>#"._STORE."</a> &nbsp;
    <a href='../hashtag/$s_country' class='selected_ht' title='$s_country'>#$s_country</a> &nbsp;
    <a href='../hashtag/"._NEW."' class='selected_ht' title='#"._NEW."'>#"._NEW."</a> &nbsp;
    <a href='../hashtag/"._JOB."' class='selected_ht' title='#"._JOB."'>#"._JOB."</a> &nbsp;
    "; ?>
    </td>
</tr>
</table>
</div>
<?php 
}
}
?>
  </div>
  </div>
 <!-- <div class="main-navigation">
    <nav>
        <ul>
            <li><a href="home.html"><i class="fas fa-home fa-2x"></i></a><p>Home</p></li>
			<li><a href="search.html"><i class="fas fa-search fa-2x"></i></a><p>Search</p></li>
            <li><a href="videos.html"><i class="fas fa-video fa-2x" style="color:blue;"></i></a><p style="color:blue;">Vidoes</p></li>
            <li><a href="audios.html"><i class="fas fa-music fa-2x"></i></a><p>Audios</p></li>
            <li><a href="#"><i class="fas fa-bell fa-2x"></i></a><p>Notification</p></li>
	 </ul>
    </nav>
</div>-->
<?php include "../includes/endJScodes.php"; ?>
</body>
</html>
