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
    <title><?= _MESSAGES; ?> | webapp</title>
    <meta charset="UTF-8">
    <meta name="description" content="This webapp is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="Notifications,social network,social media,This webapp,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
	<link rel='stylesheet' href='../addTabs.css' />
	<script src='../AddTabs.js'></script>
	<style>
.group{
    background: #fff;
    display:flex;
    max-width: 600px;
    position: absolute;
	margin:auto;
    left:0;
    right: 0;
    bottom: 0;
    top:53px;
}
.messages_col1{
	width:100%;
}
.mCol1_title{
    padding: 12px;
	border:100%;
}
.m_contacts_search{
    border: none;
    border-radius: 3px;
    background: #f2f2f2;
	padding:8px;
    outline: none;
    width: 100%;
    font-size: 13px;
}
.m_contacts_user{
    width: 36px;
    height: 36px;
    overflow: hidden;
    border-radius: 100%;
}
.m_contacts_user img{
    width: auto;
    height: 100%;
}
.m_contacts_table{
    width: 100%;
}
.m_contacts_table tr{
    cursor: pointer;
}
.m_contacts_table tr:hover{
    background: #f6f6f6;
    color: #000 ; 
}
.m_contacts_table tr td{
    padding: 8px;
}
.m_contacts_table tr td p{
    font-size: 14px;
    margin: 0;
}
.m_userActive{
    width: 13px;
    height: 13px;
    border: 2px solid #fff;
    border-radius: 20px;
    position: absolute;
    bottom: 5px;
}
.mNew_notifi{
    background: red;
    color: #fff;
    padding: 0px 4px;
    padding-top: 3px;
    border-radius: 20px;
}
	</style>
</head>
<body id="rohit">
<!--=============================[ NavBar ]========================================-->
<!--=============================[ Div_Container ]========================================-->
<!--<div style="text-align:center; background:gray;">
 <h3>MESSAGE</h3>
<div>
<hr/>
		</div>
</div>-->
 <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
	  <img src="../icon/back.png" style="width:30px;height:30px; float:left;margin-left:10px; margin-top:16px;display:none;" class="back">
        <a href="javascript:void(0)"  class="brand-logo message" ><?= _MESSAGES ; ?></a>
				
  
  <div class="message dropdown float-right">
    <span class="message"  data-toggle="dropdown"  style="float:right;margin-right:10px;cursor:pointer;">
    <i class="medium material-icons">more_vert</i>
  </span>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="group.php">Create Groups</a>
      <a class="dropdown-item" href="channel.php">Create Channel</a>
	  <a class="dropdown-item" href="msgSave.php">Saved Messages</a>
    </div>
  </div>
      </div>
    </nav>
  </div>
  <div>
<div style="margin:0px auto; max-width:600px;">
	 <div data-addui='tabs'>
    <div role='tabs'>
      <div><?= _FOR_YOU ?></div>
      <div><?= _FOLLOWING ?></div>
	    <div><?= _FOR_YOU ?></div>
    </div>
    <div role='contents'>
	    <div>
<div class="group" style="margin-top:50px;">
    	<div class="messages_col1">
    		<div class="mCol1_title">
    		<input type="text" class="m_contacts_search" id="mU_search" name="mU_search" placeholder="<?= _SEARCH ; ?>" />
    		</div>
			<div id="m_contacts" class="scrollbar" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto; padding:12px;">
            <p class="m_contacts_title"><?= _REQUEST  ?></p>
                <div id="m_contacts_requests">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
                <br>
                <p class="m_contacts_title" style="border-top: 1px solid #d0d4d8;"><?= _FRIENDS ; ?></p>
                <div id="m_contacts_friends">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
</div> 
<div id="m_contacts_search" class="scrollbar" style="position:absolute;display:none;top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;padding:12px;"></div>
</div> 
        </div>
		</div>
		<!----->	
     <div>
  	  <div class="container-fluid">
<div class="group" style="margin-top:50px;">
    	<div class="messages_col1">
			<div id="m_groups" class="scrollbar" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; overflow: auto; padding:12px;">
                <br>
                <p class="m_contacts_title"><?= _FRIENDS ; ?></p>
                <div id="m_contacts_group">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
</div> 
</div> 
        </div>
		</div>
</div>
<!----->
  <div>
	<div class="group" style="margin-top:50px;">
    	<div class="messages_col1">
    		<div class="mCol1_title">
    		<input type="text" class="m_contacts_channals" id="mG_search" name="mG_search" placeholder="<?= _SEARCH ; ?>" />
    		</div>
			<div id="m_channels" class="scrollbar" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto; padding:12px;">
                <p class="m_contacts_title"><?= _FRIENDS ; ?></p>
                <div id="m_contacts_channals">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
</div> 
<div id="m_channels_search" class="scrollbar" style="position:absolute;display:none;top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;padding:12px;"></div>
</div> 
        </div>
</div>
<!----->
</div>
</div>	
</div>  
</div>
<!--===============================[ End ]==========================================-->
<script type="text/javascript">
$(document).ready(function() {
   mLoadUsers();
   mLoadGroups();
   mLoadChannels();
   // refresh contacts details every 5 sec
    setInterval(mLoadUsers, 5000);
   //setInterval(mLoadGroups, 5000);
});
</script>
<script>
function mLoadUsers(){
mLoadUsers2();
var requ = "getUsers";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path},
    success:function(data){
     if (data =='') {
        $('#m_contacts_friends').html("<p style='margin: 0px 8px; text-align: center; color: grey; background: rgba(0, 0, 0, 0.03); padding: 8px 0px; border-radius: 3px;'><?= _NOTHINGSHOW ; ?></p>");
     }else{
     $('#m_contacts_friends').html(data);
     }
    }
});
}
function mLoadGroups(){
var requ = "getGroups";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path},
    success:function(data){
     if (data == '') {
        $('#m_contacts_group').html("<p style='margin: 0px 8px; text-align: center; color: grey; background: rgba(0, 0, 0, 0.03); padding: 8px 0px; border-radius: 3px;'><?= _NOTHINGSHOW ; ?></p>");
     }else{	 
     $('#m_contacts_group').html(data);
     }
    }
});
}
function mLoadChannels(){
var requ = "getChannel";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path},
    success:function(data){
     if (data == '') {
        $('#m_contacts_channals').html("<p style='margin: 0px 8px; text-align: center; color: grey; background: rgba(0, 0, 0, 0.03); padding: 8px 0px; border-radius: 3px;'><?= _NOTHINGSHOW ; ?></p>");
     }else{	 
     $('#m_contacts_channals').html(data);
     }
    }
});
}
function mLoadUsers2(){
var requ = "getUsers2";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path},
    success:function(data){
     if (data =='') {
        $('#m_contacts_requests').html("<p style='margin: 0px 8px; text-align: center; color: grey; background: rgba(0, 0, 0, 0.03); padding: 8px 0px; border-radius: 3px;'><?= _NOTHINGSHOW; ?></p>");
     }else{
     $('#m_contacts_requests').html(data);        
     }
    }
});
}
// on search contacts field [key up] do this
$('#mU_search').keyup(function(){
    mSearchUser();
});
// on search channel field [key up] do this
$('#mG_search').keyup(function(){
	mSearchChannel();
});
function mSearchUser(){
var requ = "searchUser";
var path = "<?php echo $check_path; ?>";
var mSearch = $.trim($('#mU_search').val());
if (mSearch != '') {
$('#m_contacts').hide();
$('#m_contacts_search').show();
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'mSearch':mSearch},
    beforeSend:function(){
        $('#m_contacts_search').html("<div style='text-align: center; padding: 15px;'><img src='"+path+"imgs/loading_video.gif'></div>");
    },
    success:function(data){
     $('#m_contacts_search').html(data);
	  $('#m_contacts_search').show();
    }
});
}else{
   mLoadUsers();
   $('#m_contacts').show();
   $('#m_contacts_search').hide();
}
}
function mSearchChannel(){
var requ = "searchChannel";
var path = "<?php echo $check_path; ?>";
var mSearch = $.trim($('#mG_search').val());
if (mSearch != '') {
$('#m_channels').hide();
$('#m_channels_search').show();
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'mSearch':mSearch},
    beforeSend:function(){
        $('#m_channels_search').html("<div style='text-align: center; padding: 15px;'><img src='"+path+"imgs/loading_video.gif'></div>");
    },
    success:function(data){
     $('#m_channels_search').html(data);
	  $('#m_channels_search').show();
    }
});
}else{
   mLoadChannels();
  $('#m_channels').show();
 $('#m_channels_search').hide();
}
}
</script>
</body>
</html>