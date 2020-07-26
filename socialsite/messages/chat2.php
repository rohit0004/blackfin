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
$userid = trim(filter_var(htmlentities($_GET['uid'])),FILTER_SANITIZE_NUMBER_INT);
echo $userid;
?>
<?php include "../includes/head_imports_main.php";?>
<div style="margin:0px auto; max-width:600px;">
			<!---->
    		<div class="messages_col3 scrollbar">
			</br>
			</br>
    		<div class="mCol3_userInfo">
    			<div style="position: relative;">
    			<div class="mCol3_userInfo_avatar">
    			</div>
    			<div class="mCol3_userActive" style="background: #ccc;"></div>
    			</div>
    			<h4 style="text-align: center;"><div style="width: 60%; height: 10px; background: rgba(217, 221, 224, 0.55); margin: auto;"></div></h4>
    			<p style="text-align:center;margin: 0px;color: gray"><div style="width: 40%; height: 10px; background: rgba(217, 221, 224, 0.55); margin: auto;"></div></p>
    		</div>
    		<div class="mCol3_bio" style="text-align:center;">
    			<div style="width: 80%; height: 10px; background: rgba(217, 221, 224, 0.55);"></div>
    			<div style="width: 60%; height: 10px; background: rgba(217, 221, 224, 0.55);margin-top: 8px;"></div>
    		</div>
    		</div>
			<!---->
    		<div class="mCol2_msgs scrollbar">
			<div id="m_messages">
			</div>
			<div id="m_userSeen" style="display:none;padding: 0px 8px; color: #545454; font-size: 12px;text-align: right;"><span class="fa fa-check"></span> seen</div>
			<div id="m_userTyping" class="m_msgU1" style="display:none;margin: 8px;margin-bottom: 15px;"><img src="<?php echo $check_path; ?>/imgs/typing.gif" style=" width: 30px; "></div>
			<div id="m_messages_loading" style='display:none;text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
		  </div>
</div>
<script>
$(document).ready(function() {
	
	mUserProfile(<?php echo $userid ?>, " ");
	mFetchMsgs(<?php echo $userid ?>, "click");
 });
 function mFetchMsgs(uid,type){
var requ = "fetchMsgs";
var path = "<?php echo $check_path; ?>";
var mCountToScroll = $('.m_msgTable').attr('data-count');
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'uid':uid},
    beforeSend:function(){
   if (type == "click") {
        $('#m_messages_loading').show();
        $('.selectToChat').hide();
    }else{}
    },
    success:function(data){
		alert(data)
    mTypingStatus(uid);
    $('#m_messages_loading').hide();
    $('#m_messages').html(data);
    mCheckSeen(uid);
    if ($('.m_msgTable').attr('data-count') != mCountToScroll) {
    $('.mCol2_msgs').animate({ scrollTop:$('.mCol2_msgs').prop('scrollHeight')}, 0);
    }
    }
}); 
}
function mUserProfile(uid,type){
var requ = "userProfile";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'uid':uid},
    dataType: "json",
    beforeSend:function(){
        if (type == "click") {
        $('.mCol3_userInfo').html(`
        <div style="position: relative;">
        <div class="mCol3_userInfo_avatar">
        </div>
        <div class="mCol3_userActive" style="background: #ccc;right:55%;"></div>
        </div>
        <h4 style="text-align: center;"><div style="width: 60%; height: 10px; background: rgba(217, 221, 224, 0.55); margin: auto;"></div></h4>
        <p style="text-align:center;margin: 0px;color: gray"><div style="width: 40%; height: 10px; background: rgba(217, 221, 224, 0.55); margin: auto;"></div></p>
            `);
        $('.mCol3_bio').html(`
        <div style="width: 80%; height: 10px; background: rgba(217, 221, 224, 0.55);"></div>
        <div style="width: 60%; height: 10px; background: rgba(217, 221, 224, 0.55);margin-top: 8px;"></div>
        `);
        }
    },
    success:function(data){
        $('.mCol3_userInfo').html(data[0]);
        $('.mCol3_bio').html(data[1]);
        $('.mCol2_title').html(data[2]);
    }
});
}
</script>