<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$myId = $_SESSION['id'];
include("../config/connect.php");
include("../includes/time_function.php");
include("../includes/country_name_function.php");
include("../includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: ../index");
}
$_SESSION['user_photo'] = $row_author_photo;
if (is_dir("imgs/")) {
        $check_path = "";
    }elseif (is_dir("../imgs/")) {
        $check_path = "../";
    }elseif (is_dir("../../imgs/")) {
        $check_path = "../../";
    }
	$cid = filter_var(htmlspecialchars($_GET['cid']),FILTER_SANITIZE_STRING);
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
		  img {
  border-radius: 50%;
}.modal1{
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
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
  padding-top: 170px;
  left: 0;
  top: 0;
  width:100%;
  height: 100%; 
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}	
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
	  </style>
 
</head>
<body>
        <div class="input-field col s12">
          <input placeholder="Placeholder" id="searchC"  type="text" class="validate">
        </div>
<div id="m_channel_member">
</div>
<div id="m_channel_loading" class="scrollbar" style="position:absolute;display:none;top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;padding:12px;"></div>
<script>
cMember(<?php echo $cid ?>);
$('#searchC').keyup(function(){
	searchCmember(<?php echo $cid ?>);
});
function cMember(cid)
{
var requ = "loadCmember";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"../includes/group_channel_request.php",
    data:{'req':requ,'path':path,'cid':cid},
    beforeSend:function(){
   $('#m_channel_loading').html("<div style='text-align: center; padding: 15px;'><img src='../imgs/loading_video.gif'></div>");
    },
    success:function(data){
		 $('#m_channel_member').html(data);
		 $('#m_channel_loading').hide();
    }
});
}
function searchCmember(cid){
var requ = "channelSearchMember";
var path = "<?php echo $check_path; ?>";
var mSearch = $.trim($('#searchC').val());
if (mSearch != '') {
$('#m_channel_member').hide();
$('#m_channel_loading').show();
$.ajax({
    type:'POST',
    url:"../includes/group_channel_request.php",
    data:{'req':requ,'path':path,'mSearch':mSearch,'cid':cid},
    beforeSend:function(){
        $('#m_channel_loading').html("<div style='text-align: center; padding: 15px;'><img src='../imgs/loading_video.gif'></div>");
    },
    success:function(data){
     $('#m_channel_loading').html(data);
	 $('#m_channel_loading').show();
    }
});
}else{
   cMember(cid);
   $('#m_channel_member').show();
   $('#m_channel_loading').hide();
}	
}
</script>
</body>
</html>	