<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
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
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include "includes/head_imports_main.php";?>
   <link rel='stylesheet' href='addTabs.css' />
	<script src='AddTabs.js'></script>
	<link rel="stylesheet" href="css/style.css">
  <style>
  *{margin:0px;padding:0px;}
  #loading{
	position:fixed;
	width:100%;
	height:100vh;
	background:#fff url('../imgs/loading_video.gif') no-repeat center;
}
  </style>
</head>
<body onload="myFunction()">
<div id="loading"></div>

 <main role="main">
  <h4 style="text-align:center;"><?= _VIDEO ?></h4>
          <hr/>
		</main>  
<div style="margin:0px auto; max-width:560px;">
<div data-addui='tabs' style="clear: left;">

    <div role='tabs'>
      <div id="videoForyou"><?= _FOR_YOU ;?></div>
	  <div id="videoFollowing"><?= _FOLLOWING ?></div>
    </div>
    <div>
      <div id="videoPost">
	  <?php include("fetch_foryou_video.php"); ?>
        </div>
    </div>
  </div>
  </div>
  
  
 <div class="main-navigation">
    <nav>
        <ul>
            <li id="home"><a href="home" style="color:#6c757d;"><i class="fas fa-home fa-2x" ></i></a><p><?= _HOME ?></p></li>
			<li id="search"><a href="search.php" style="color:#6c757d;"><i class="fas fa-search fa-2x" ></i></a><p><?= _SEARCH ?></p></li>
            <li id="videoPage"><a href="videos.php" style="color:blue; text-decoration:none;"><i class="fas fa-video fa-2x"  ></i></a><p style="color:blue;"><?= _VIDEO ?></p></li>
            <li id="audio"><a href="audios.php" style="color:#6c757d;"><i  class="fas fa-music fa-2x" ></i></a><p><?= _AUDIOS ?></p></li>
		   <li id="notification"><a  href="notifications" style="color:#6c757d; text-decoration:none;"><i class="fas fa-bell fa-2x" ></i><p><?= _NOTIFICATION ?></p><span id="notificationsCount"></span></li></a>
	</ul>
    </nav>
</div>	
<script>
$(document).ready(function(){
  $("#videoForyou").click(function(){
    $("#videoPost").load("fetch_foryou_video.php", function(responseTxt, statusTxt, xhr){
      if(statusTxt == "success")

      if(statusTxt == "error")
        alert("Error: " + xhr.status + ": " + xhr.statusText);
    });
  });
  $("#videoFollowing").click(function(){
    $("#videoPost").load("includes/fetch_video_following.php", function(responseTxt, statusTxt, xhr){
      if(statusTxt == "success")

      if(statusTxt == "error")
        alert("Error: " + xhr.status + ": " + xhr.statusText);
    });
  });
});
</script>
<script>
var preloader= document.getElementById('loading');
function myFunction(){
	preloader.style.display='none';
}
</script>
</body>
</html>
