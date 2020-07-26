<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/time_function.php");
include ("includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: index");
}
if (is_dir("imgs/")) {
    $dircheckPath = "";
}elseif (is_dir("../imgs/")) {
    $dircheckPath = "../";
}elseif (is_dir("<?php echo $dircheckPath; ?>imgs/")) {
    $dircheckPath = "<?php echo $dircheckPath; ?>";
}
?>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php include "includes/head_imports_main.php";?>
	<link rel="stylesheet" href="css/home.css">
  <style>
  *{margin:0px;padding:0px;}
  </style>
</head>
<body>
<div class="container">
<div>
 <main role="main">
  <h4 style="text-align:center;"><?= _NOTIFICATION ?></h4>
</div>
          <hr/>
		</main> </div>
<div style="margin:0px auto; max-width:560px;">
  <div>
  <div style="padding: 16px 10px; display:none; max-width:720px;"id="nav_Noti_Btn" ><span class="fa fa-bell"></span> <?= _NOTIFICATION ?><span ></span></div>
                <div class="navbar_fetchBox" id="notifications_box">
                <div id="notifications_rP" class="scrollbar" >
                    <div id="notifications_r" data-load="0">
                        <div id="notifications_data"></div>
                        <p style='width: 100%;border:none;display:none' id="notifications_loading" align='center'><img src='<?php echo $dircheckPath; ?>imgs/loading_video.gif' style='width:20px;box-shadow: none;height: 20px;'></p>
                        <p id="notifications_noMore" style='color:#9a9a9a;font-size:14px;text-align:center;display:none;'><?php echo _NO_NOTIFICATIONS; ?></p>
                        <input type="hidden" id="notifications_load" value="0"> 
                    </div>
                </div>
            </div>

   <div id="nav_newNotify" data-show='0'></div>
   </div>
  </div>
  <div class="main-navigation">
    <nav>
        <ul>
            <li id="home"><a href="home"><i class="fas fa-home fa-2x" ></i></a><p><?= _HOME ?></p></li>
			<li id="search"><a href="search.php"><i class="fas fa-search fa-2x" ></i></a><p><?= _SEARCH ?></p></li>
            <li id="videoPage"><a href="videos.php"><i class="fas fa-video fa-2x"  ></i></a><p><?= _VIDEO ?></p></li>
            <li id="audio"><a href="audios.php"><i  class="fas fa-music fa-2x" ></i></a><p><?= _AUDIOS ?></p></li>
		   <li id="notification"><a  style="color:blue; text-decoration:none;"><i class="fas fa-bell fa-2x" ></i><p><?= _NOTIFICATION ?></p><span id="notificationsCount"></span></li></a>
	</ul>
    </nav>
</div>	
<div style="" id='nSound'></div>
<script type="text/javascript">
$(function(){
    $('#nav_Noti_Btn').trigger('click');
});
</script>
<script>
function getNotifications(obj,reqToFetch){
var path = "<?php echo $dircheckPath; ?>";
var whatF = "fetch";
var load = $('#'+obj+'_load').val();
$.ajax({
type: "POST",
url: "<?php echo $dircheckPath; ?>includes/fetch_notifybox.php",
data: {'what':whatF,'path':path,'load':load},
cache: false,
beforeSend:function(){
    if (reqToFetch == "getNew") {
        $("#"+obj+"_data").html('');
    }
    $("#"+obj+"_loading").show();
    $("#notifi_loadmoreBtn").hide();
},
success: function(data){
    if (data == "0"){
        $("#"+obj+"_noMore").show();
    }else{
        if (reqToFetch == "loadMore") {
            $("#"+obj+"_data").append(data);
        }
        if (reqToFetch == "getNew") {
            $("#"+obj+"_data").html(data);
        }
        $("#notifi_loadmoreBtn").show();
    }
    
    $("#"+obj+"_loading").hide();
    document.getElementById(obj+"_load").value = Number(load)+10;
}});
}
// ============================================ on click notification ============================================
$("#nav_Noti_Btn").click(function(e){
if ($('#notifications_r').attr("data-load") == "0"){
getNotifications('notifications','getNew');
$('#notifications_r').attr("data-load","1");
}
$("#notificationsCount").html('');
$('#nav_newNotify').attr('data-show','0');
$('#nav_newNotify').show();
e.stopPropagation();

});
// ============================================ notifications on scroll >> loadmore ============================
$("#notifications_rP").scroll(function(){
    var o = document.getElementById('notifications_rP');
    if(o.offsetHeight + o.scrollTop + 1 >= o.scrollHeight){
        getNotifications('notifications','loadMore');
    }
});
// ============================================ check notifications ============================================
function chNoti(){
var path = "<?php echo $dircheckPath; ?>";
var whatCh = "check";
$.ajax({
type: "POST",
url: "<?php echo $dircheckPath; ?>includes/fetch_notifybox.php",
data: {'what':whatCh,'path':path},
cache: false,
success: function(data){
if (data != '0') {
$("#notificationsCount").html("<span class='redAlert_notify_msgs'>"+data+"</span>");
if ($('#nav_newNotify').attr('data-show') != data) {
if ($('#nav_newNotify').attr('data-show') < data) {
$('#notifications_r').attr("data-load","0");
$('#notifications_load').val(0);
$('#nav_newNotify').html("<div class='notiAlert'><span class='fa fa-bell'></span> "+data+"</div>");
$('#nav_newNotify').fadeIn(function(){
var soundPath = path+"media/mp3/notification_bell3";
$('#nSound').html('<audio autoplay="autoplay"><source src="' + soundPath + '.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="' + soundPath +'.mp3" /></audio>');
}).delay(5000).fadeOut(function(){
$('#nSound').html('');
$('#nav_newNotify').html("");
});
}
$('#nav_newNotify').attr('data-show',data);
}
}else{
$("#notificationsCount").html('');  
$('#nav_newNotify').attr('data-show','0');
}
}});
}
chNoti();
</script>
</body>
</html>
