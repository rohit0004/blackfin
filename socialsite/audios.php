
<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/num_k_m_count.php");
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
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include "includes/head_imports_main.php";?>
  <link rel="stylesheet" href="css/style.css">
  <link rel='stylesheet' href='addTabs.css' />
<script src='AddTabs.js'></script>
  <style>
  *{margin:0px;padding:0px;}
 #loading{
	position:fixed;
	width:100%;
	height:100vh;
	background:#fff url('imgs/loading_video.gif') no-repeat center;
}
  </style>
</head>
<body onload="myFunction()">
<div id="loading"></div>

<div class="container">
<div>
 <main role="main">
  <h4 style="text-align:center;"><?= _AUDIOS ?></h4>
</div>
          <hr/>
		</main> 
		</div>
</div>  
<div style="margin:0px auto; max-width:560px;">
<div data-addui='tabs' style="clear: left;">

    <div role='tabs'>
      <div id="foryou"><?= _FOR_YOU ;?></div>
	  <div id="following"><?= _FOLLOWING ?></div>
    </div>
    <div id="audioPosts">
	  <div id="FetchingPostsDiv">
	 <?php	  include("audio_for_u.php"); ?>
    </div>
  </div>
  </div>
  </div>
  
   <div class="main-navigation">
    <nav>
        <ul>
            <li id="home"><a href="home" style="color:#6c757d;"><i class="fas fa-home fa-2x" ></i></a><p><?= _HOME ?></p></li>
			<li id="search"><a href="search.php" style="color:#6c757d;"><i class="fas fa-search fa-2x" ></i></a><p><?= _SEARCH ?></p></li>
            <li id="videoPage"><a href="videos.php" style="color:#6c757d;"><i class="fas fa-video fa-2x"  ></i></a><p ><?= _VIDEO ?></p></li>
            <li id="audio"><a href="audios.php" style="color:blue; text-decoration:none;"><i  class="fas fa-music fa-2x" ></i></a><p style="color:blue;"><?= _AUDIOS ?></p></li>
		   <li id="notification"><a  href="notifications" style="color:#6c757d; text-decoration:none;"><i class="fas fa-bell fa-2x" ></i><p><?= _NOTIFICATION ?></p><span id="notificationsCount"></span></li></a>
	</ul>
    </nav>
</div>	
  
<script>
$(document).ready(function(){
  $("#foryou").click(function(){
    $("#audioPosts").load("audio_for_u.php", function(responseTxt, statusTxt, xhr){
      if(statusTxt == "success")

      if(statusTxt == "error")
        alert("Error: " + xhr.status + ": " + xhr.statusText);
    });
  });
  $("#following").click(function(){
    $("#audioPosts").load("audio_fpllowing.php", function(responseTxt, statusTxt, xhr){
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