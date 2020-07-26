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
	$userid = htmlentities($_GET['id']);
	$groupid = htmlentities($_GET['g']);
	$channelid = htmlentities($_GET['c']);
if(!empty($channelid)){
	$id=htmlentities($channelid);
	$groupid=0;
	$channelid=0;
	//echo "<script> alert($channelid) </script>";
}
elseif(!empty($groupid)){
	$id=htmlentities($groupid);
	$groupid=0;
	$channelid=0;
	//echo "<script> alert($groupid) </script>";
}
else{$id=htmlentities($userid);
$groupid=0;
$channelid=0;
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
	.message{
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
    position: relative;
}
.messages_col3{
}.mCol1_title{
    padding: 12px;
	border:100%;
}
.mCol2_title{
    padding: 5px;
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
.m_msgUserImg{
    width: 23px;
    height: 23px;
    overflow: hidden;
    border-radius: 20px;
    border: 1px solid #ccc;
    background: #ccc;
    position: absolute;
    top: 10px;
}
.m_msgUserImg img{
    width: auto;
    height: 100%;
}
#m_msgTable:first-child{margin-bottom:65px;background:red;}
.m_msgTable{
    margin:0px;
    width: 100%;
	border-collapse:collapse;
	float:right;
}
.m_msgTable tr td{
    padding: 5px;
    padding-bottom: 3px;
}
.m_msgU1{
    max-width: 80%;
    background: #f6f6f6;
    padding: 8px 10px;
    border-radius: 20px;
    color: #5c5c5c;
    font-size: 14px;
    word-break: break-word;
    display: inline-block;
	float:right;
}
.m_msgU2{
	border: 1px solid black;
    max-width: 100%;
    padding: 8px 10px;
    border-radius: 20px;
    font-size: 14px;
    word-break: break-word;
    display: inline-block;
}
.mCol2_msgs{
    position: absolute;
    left: 0;
    right: 0;
    overflow: auto;
    overflow-x: hidden;
}
.m_sendField{
    border: 1px solid #eaeaea;
    border-left: 0;
    border-right: 0;
    position: relative;
}
.m_sendField textarea{
    width: 100%;
    direction: inherit;
    border: none;
    resize: none;
    outline: none;
    padding: 8px;
    height: 40px;
    padding-right: 38px;
}
.m_sendField_span{
    background: #fff;
    color: gray;
    font-size: 18px !important;
    position: absolute;
    right: 0px;
    padding: 10px;
    cursor: pointer;
}
.m_sendField_box{
    position:fixed;
    bottom: 0;
    left: 0;
    right: 0;
	background:red;
}
.m_replyField_box{
	position:fixed;
    bottom: 40;
    left: 0;
    right: 0;
	background:blue;
}
.mCol3_userInfo{
    padding-top: 1%;
}
.mCol3_bio{
    padding:6px
}
.mCol3_userInfo_avatar{
    width: 72px;
    height: 72px;
    overflow: hidden;
    margin: auto;
    border-radius: 100%;
    background: rgba(217, 221, 224, 0.55);
}
.mCol3_userInfo_avatar img{
    width: auto;
    height: 100%;
}
.mCol3_userActive{
    background: #4CAF50;
    width: 17px;
    height: 17px;
    border: 3px solid #fff;
    border-radius: 20px;
    position: absolute;
    bottom: 0;
    left: 55%;
}
.mCol3_userProfileLink,.mCol3_userProfileLink:hover,.mCol3_userProfileLink:focus{
    color: #000;
    font-weight: bold;
    text-decoration: none;
}
.selectToChat{
    margin: 15px;
    text-align: center;
    color: grey;
    background: rgba(0, 0, 0, 0.03);
    padding: 8px 0px;
    border-radius: 3px;
}
.m_contacts_title{
    margin: 0;
    color: gray;
    font-variant: all-small-caps;
    padding: 3px 8px;
    font-size: 15px;
}
.modal1{
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 200px;
  left: 0;
  top: 0;
  width:100%;
  height: 100%; 
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 30%;
}
@media only screen and (max-width: 720px){
  .modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
}
@media only screen and (max-width: 720px){
.modal1{
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 300px;
  left: 0;
  top: 0;
  width:100%;
  height: 100%; 
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}	
}
 .field_wrapper i { 
            position: absolute; 
			float:right;
        } 
.modal.bottom-sheet{
	max-height:60%;
	background:white;
	border-top-left-radius: 20px; 
    border-top-right-radius: 20px;
	padding-top:10px;
	overflow: auto;
}
</style>
<style> 
.m_msgTable:last-child {
  margin-bottom:55px;
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
	 <i class=" material-icons" style="float:left;margin-top:10px;">arrow_back</i>
	 <div style="margin-left:40px;">
        <a href="#!" class="mCol2_title"><?= _MESSAGES ; ?></a><br>
		<span style="float:left;margin-left:8px;">rohit</span>
		</div>
  </div>
<div class="container-fluid">      
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
		  <div id="reply">
		  </div>
		  <div class="m_SendField_box send_msg" style="display:block;">
							<div class="input-group">
								<div class="input-group-append" id="fileBtn">
									<span class="input-group-text attach_btn" style="margin:0 5px;height:35px;width: 35px;border-radius:50%;margin-top:0px;"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea  dir="auto"  name="" class="form-control" id="mSendField" data-id=""  placeholder="Type your message..." style="border-radius:40px;"></textarea>
								<div class="input-group-append" id="sendMeg">
									<span class="input-group-text send_btn" style="margin:0 10;" ><i class="fas fa-location-arrow"></i></span>
								</div>
							</div>
			</div>	
			 <div class="m_SendField_box edit_msg" style="display:none;">
							<div class="input-group">
								<div class="input-group-append" onclick="cancelEdit()">
									<span class="input-group-text attach_btn"><i class="fa fa-times"></i></span>
								</div>
								<textarea  dir="auto"  name="" class="form-control" id="mEditField"  data-id="" placeholder="Type your message..." style="height: 40px;" ></textarea>
								<div class="input-group-append" id="editMeg">
									<span class="input-group-text edit_btn"><i class="fas fa-location-arrow"></i></span>
								</div>
							</div>
			</div>	
</div>
</div>
<div id="fileSelect" class="modal1">
  <!-- Modal content -->
  <div class="modal-content">
  <form id="uploadForm" action="" method="post" enctype="multipart/form-data" style="margin: 0;">
  <p>Some text in the Modal..</p>
<div style="margin:10px;cursor: pointer;"><input type='file' id='image' class="fileUpload" name='imagefile'   accept="image/*"/>
<p  id='btn-upload'>Choose a Image</p>
</div>
 <div style="margin:10px;cursor: pointer;">
<input type='file' id='video' name='videofile' accept="video/*" class="fileUpload" style="width:0; height:0;"/>
<p  id='btn-video'>Choose a Video</p></div>
<div style="margin:10;cursor: pointer;">
<input type='file' id='audio' name='audiofile' accept="audio/*" class="fileUpload" style="width:0; height:0;"/>
<p  id='btn-audio'>Choose a Audio</p></div>
<div style="margin:10px;cursor: pointer;">
 <input type='file' id='pdf' name='pdffile' accept="pdf/*" class="fileUpload" style="width:0; height:0;"/>
 <p  id='btn-pdf'>Choose a Pdf</p>
</div>
<div style="margin:10px;cursor: pointer;">
 <p  id='btn-poll'>Create a Poll</p>
</div>
</form>
<span style="font-size:15px;text-align:right;" id="cancel">CANCEL</span>
</div>
</div>
	<div id="msgInfo" class="modal1">
		<div class="modal-content">
<p style="margin-bottom:0px;margin-left:10px;">QESTION</p>
    <div class="input-field">
      <input value="" id="poll_question" type="text" class="" placeholder="What's your poll question?">
    </div>
 <div  class="field_wrapper" id="w_poll">
						<div class="input-field">
						<a href="javascript:void(0);" class="add_button"  title="Add field"><i class="material-icons" style=" padding: 10px; min-width: 40px; ">add</i></a>
					    <input type="text" name="task[]" value="" id="your_poll" placeholder="You can create a poll." class="task">
						</input>
					     </div>
</div>
	 <div>
                        <input type="submit" class="btn" value="Create Poll" id="sendPoll" name='submit' style="display: flex; justify-content: center;margin: auto;">
    </div>
	    </div>
	</div>
<!--<div id="msgInfo" class="modal1">
</div>-->
<!--===============================[ End ]==========================================-->
<script type="text/javascript">
$(document).ready(function() {
	  $(document).scrollTop($(document).height()); 
	 $('#btn-upload').click(function(e){
        e.preventDefault();
        $('#file').click();}
    );
	 $('#btn-video').click(function(e){
        e.preventDefault();
        $('#video').click();}
    );
	 $('#btn-audio').click(function(e){
        e.preventDefault();
        $('#audio').click();}
    );
	 $('#btn-pdf').click(function(e){
        e.preventDefault();
        $('#pdf').click();}
    );
  $("#btn-poll").click(function(){
    $('#modal_box').modal();
    $('#modal_box').modal('open'); 
	modal.style.display = "none";
  });
    var maxField = 4; 
    var addButton = $('.add_button'); 
    var wrapper = $('.field_wrapper');
    var fieldHTML = '<div class="input-field"><a href="javascript:void(0);" class="remove_button"  title="Add field"><i class="material-icons" style=" padding: 10px; min-width: 40px; ">remove</i></a><input type="text" name="field_name[]" value="" id="your_poll" /></div>'; 
    var x = 1;
    $(addButton).click(function(){
        if(x < maxField){ 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
	mUserProfile(<?php echo $id ?>,"timer");
	mFetchMsgs(<?php echo $id ?>, "timer");
 });
  $(document).on('change', '.fileUpload', function(){
 	 var path = "<?php echo $check_path; ?>";
	 var req = "sendMsg";
	 var image = document.getElementById("image").files[0];
     var fileV = document.getElementById("video").files[0];
	 var fileA = document.getElementById("audio").files[0];
	 var filepdf = document.getElementById("pdf").files[0];
	 var form_data = new FormData();
	form_data.append('image', image);
	form_data.append('video', fileV);
	form_data.append('audio', fileA);
    form_data.append('filepdf', filepdf);
	form_data.append("uid",uid);
	form_data.append("path",path);
	form_data.append("req",req);
	   $.ajax({
    url:"<?php echo $check_path;?>includes/m_requests.php",
    method:"POST",
    data:form_data,
    contentType: false,
    cache: false,
    processData: false,
	success:function(data)
    {
	//mFetchMsgs(uid,"click");		
    modal.style.display = "none";
	mUserProfile(<?php echo $id ?>,"timer");
	mFetchMsgs(<?php echo $id ?>,"timer");
    }
   });
   });
   $("#sendMeg").on('click',function(){ 
	var uid=<?php echo $id ?>;
	var mid=$('#mSendField').data('id');
	var requ = "sendMsg";
	var path = "<?php echo $check_path; ?>";
	var msg = $.trim($('#mSendField').val());
	if (msg != '' && uid != 0) {
	$.ajax({
	type:'POST',
	url:"<?php echo $check_path; ?>includes/m_requests.php",
	data:{'req':requ,'path':path,'uid':uid,'mid':mid,'msg':msg},
	error: function(data) {
    alert("There was an error. Try again please!");
},
	success:function(data){
	if (data == "error") {
        alert('error');
    }
	else{
        $('#mSendField').val('');
        $('#mSendField').focus();$('#reply').html('');
		$('#mSendField').data('id','');
		mUserProfile(<?php echo $id ?>,"timer");
	    mFetchMsgs(<?php echo $id ?>,"timer");
         }		
	}
		});
		}
		else{
			alert("mC_userLink");
		}
    mRemoveTyping(<?php echo $id ?>);
	});
	///////for poll////
	$("#sendPoll").on('click',function(){
	var question = $.trim($('#poll_question').val());
	var uid=<?php echo $id ?>;
	//var mid=$('#mSendField').data('id');
	var path = "<?php echo $check_path; ?>";
	var requ = "sendMsg";
	var option = $("input[id='your_poll']")
              .map(function(){return $(this).val();}).get();
			  if(option != '' && question !=''){
				$.ajax({
				type:'POST',
				url:"<?php echo $check_path; ?>includes/m_requests.php",
				data:{'req':requ,'path':path,'uid':uid,'option':option,'question':question},
				error: function(data) {
				alert("There was an error. Try again please!");
				},
				success:function(data){
					alert(data);
					  msg.style.display = "none";
					  mFetchMsgs(<?php echo $id ?>,"timer");
					  
				}
					});
			  }
			  else{M.toast({html: 'Please enter question and option !.', classes: 'rounded'})
			  }
	})
	function pollAnswer(mid){
	var pAns =	$('input[name="option"]:checked').val();	
	var requ="pollAnswer";
	 $.ajax({
						type: 'POST',
						 url:"<?php echo $check_path;?>includes/m_requests.php",
						data: {'req':requ,'mid':mid,'pAns':pAns},
						error: function(data) {
		M.toast({html: 'There was an error. Try again please!', classes: 'rounded'})
	},
						success: function(data){
		mFetchMsgs(<?php echo $id ?>,"timer");
		M.toast({html: 'Your vote is submit!', classes: 'rounded'})		
	}
			});	 

	}
	////for edit /////
	$("#editMeg").on('click',function(){ 
	var mid=$('#mEditField').data('id');
	var requ = "updateMsg";
	var path = "<?php echo $check_path; ?>";
	var msg = $.trim($('#mEditField').val());
	if (msg != '' && mid != 0) {
	$.ajax({
	type:'POST',
	url:"<?php echo $check_path; ?>includes/m_requests.php",
	data:{'req':requ,'path':path,'mid':mid,'msg':msg},
	error: function(data) {
	alert("There was an error. Try again please!");
	},
	success:function(data){
	if (data == "error") {
				alert('error');
	}
	else{$('.send_msg').show();$('.edit_msg').hide();
        $('#mSendField').val('');
        $('#mSendField').focus(); mFetchMsgs(<?php echo $id ?>,"timer");
         }		
	}
		});
		}
		else{$('.send_msg').show();$('.edit_msg').hide();}
        mRemoveTyping(<?php echo $id ?>);
	});
// on send text field (textarea) keypress do this
/*$('#mSendField').keypress(function (e) {
    if (e.keyCode == 13) {
    	// on [shift + enter] pressed do this
        if (e.shiftKey) {
            return true;
        }
        // on enter button pressed do this
        mSendField($('.mCol2_title').attr('data-user'));
        mRemoveTyping($('.mCol2_title').attr('data-user'));
        this.style.height = '40px';
        $('.mCol2_msgs').css({'bottom':this.style.height});
        return false;
    }
});*/
/*function mSendField(uid){
var requ = "sendMsg";
var path = "<?php echo $check_path; ?>";
var msg = $.trim($('#mSendField').val());
if (msg != '' && uid != 0) {
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'uid':uid,'msg':msg},
	error: function(data) {
    alert("There was an error. Try again please!");
},
   	success:function(data){
 if (data == "error") {
        alert('error');
    }
	else{
        $('#mSendField').val('');
        $('#mSendField').focus();
		mUserProfile($('.mCol2_title').attr('data-user'),"timer");
	    mFetchMsgs($('.mCol2_title').attr('data-user'),"timer");
    }		
	}
});
}else{
    
}
}*/
// auto hight for send text filed (textarea) code
$('#mSendField').each(function () {
  this.setAttribute('style', 'padding-right:38px;padding-left:8px;height:40px;overflow-y:hidden;text-align:center;');
})/*.on('input', function () {
  this.style.height = '40px';
  this.style.height = (this.scrollHeight) + 'px';
  $('.mCol2_msgs').css({'bottom':this.style.height});
});*/
var lastTypedTime = new Date(0);
function mCheckTyping() {
    if (!$('#mSendField').is(':focus') || $('#mSendField').val() == '' || new Date().getTime() - lastTypedTime.getTime() > 5000) {
        mRemoveTyping($('.mCol2_title').attr('data-user'));
    } else {
        mSetTyping($('.mCol2_title').attr('data-user'));
    }
}
setInterval(mCheckTyping, 100);
$('#mSendField').keypress(function(){lastTypedTime = new Date();});
$('#mSendField').blur(mCheckTyping);
</script>
<script>
function cancelEdit(){
	$('.send_msg').show();
	$('.edit_msg').hide();
	$('.edit_msg').val('');
}
function cancelReply(){$('#reply').html('');$('#mSendField').data('id','');}
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
		var user = data.length;
		for(var i=0; i<user; i++){
                var username = data[i].userinfo;
                var name = data[i].bio;
                var email = data[i].fullname;
            }
		$('.mCol3_userInfo').html(username);
        $('.mCol3_bio').html(name);
        $('.mCol2_title').html(email);
            
	}
});
}
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
function mCheckSeen(uid){
var requ = "checkSeen";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'uid':uid},
    success:function(data){
    if (data > 0) {
        $('#m_userSeen').show();

    }else{
        $('#m_userSeen').hide();
    }
    }
}); 
}
// typing [ststus] message from user
function mTypingStatus(uid){
var requ = "checkTyping";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'uid':uid},
    success:function(data){
    if (data > 0) {
        $('.mCol2_msgs').animate({ scrollTop:$('.mCol2_msgs').prop('scrollHeight')}, 0);
        $('#m_userTyping').show();
    }else{
        $('#m_userTyping').hide();
    }
    }
}); 
}

function mSetTyping(uid){
var requ = "mTyping";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'uid':uid},
    success:function(data){
    }
});
}
function mRemoveTyping(uid){
var requ = "mUnTyping";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_requests.php",
    data:{'req':requ,'path':path,'uid':uid},
    success:function(data){
    }
});
}
</script>
<script>
var modal = document.getElementById("fileSelect");
var btn = document.getElementById("fileBtn");
btn.onclick = function() {
  modal.style.display = "block";
}
document.getElementById("cancel").onclick=function(){
modal.style.display = "none";	
}
var msg = document.getElementById("msgInfo");
var poll = document.getElementById("btn-poll");
poll.onclick = function() {
  msg.style.display = "block";
}
window.onclick = function(event) {
  if (event.target == msg) {
    msg.style.display = "none";
  }
}
</script>
<?php include "../includes/endJScodes.php"; ?>
</body>
</html>