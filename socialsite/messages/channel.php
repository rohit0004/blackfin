<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("../config/connect.php");
include("../includes/fetch_users_info.php");
include ("../includes/time_function.php");
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
    <title><?= _MESSAGES; ?> | Socilsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="Socilsite is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="Notifications,social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
	<style>
	</style>
</head>
<body>
<!--<div class="header">
  <img src="imag/image2.jpg" class="menu-icon">
  <p>MEET APP </p>
</div>-->
<div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
	  <img src="../icon/back.png" style="width:30px;height:30px; float:left;margin-left:10px; margin-top:16px;" class="back">
      </div>
    </nav>
  </div>
<div style="margin:0px auto; max-width:600px;" id="participent">
      <div class="card" style="height:auto">
        <div>
		 <div class="container-fluid">
		 <input type="text" class="channel_name" id="channel_name" name="channel_name" placeholder="Enter  name" />
		 <input type="text" class="channel_dis" id="channel_dis" name="channel_dis" placeholder="Dscription.." />
		 <span style="font-size:11px;margin-top:30px;">Enter a channel name and optional channel discription.</span>
		 <hr>
		 <p> Channel privacy</p>
		 <p>
      <label>
        <input name="c_privacy" type="radio" checked  id="c_privacy" value="0"/>
        <span>Public</span>
		</br>
		<span style="margin-left:35px;">Public channels can finds in search.</span>
      </label>
    </p>
    <p>
      <label>
        <input name="c_privacy" type="radio" id="c_privacy" value="1"/>
        <span>Private</span></br>
		<span style="margin-left:35px;">Private channels not show in search only join by link.</span>
      </label>
     </p>
	
		</div>
          <a class="btn-floating halfway-fab waves-effect waves-light red" id="createChannel"><i class="material-icons">add</i></a>
        </div>
      </div>
 </div>  
<script>
$("#createChannel" ).click(function() {	
var channelName = $.trim($('#channel_name').val());	
var channelDis = $.trim($('#channel_dis').val());	
var channelPrivacy = $.trim($('input[type="radio"]:checked').val());	
var requ = "createChannel";
var path = "<?php echo $check_path; ?>";
if (channelName == '') {
	 M.toast({html: 'Please enter channel name!', classes: 'rounded'})
}
else{
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_group_request.php",
    data:{'channelName':channelName,'channelDis':channelDis,'channelPrivacy':channelPrivacy,'req':requ,'path':path},
    success:function(data){
    $('#channel_name').val('');
	$('#channel_dis').val('');
	 M.toast({html: 'Successfully create a channel!', classes: 'rounded'})
	url: "data.php"
    }
});	
}
});
</script>
</body>
</html>