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
	$gid = filter_var(htmlspecialchars($_GET['gid']),FILTER_SANITIZE_STRING);
	if($gid=="search_box"){
		
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
	<script  src="../js/app.js"></script>
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
.modal.bottom-sheet{
	max-height:60%;
	background:white;
	border-top-left-radius: 20px; 
    border-top-right-radius: 20px;
	padding-top:10px;
	overflow: auto;
}
	  </style>
 
</head>
<body>
<a  id ="modal_box">Modal Bottom Sheet Style</a>

<!-- Modal Structure -->
<div id="search_box" class="modal  bottom-sheet" style="height:100vh; background:white; padding-top:0;">
        <div class="input-field col s12">
          <input placeholder="Placeholder" id="searchU"  type="text" class="validate">
        </div>
<div id="m_group_member">
</div>
<div id="m_members_search" class="scrollbar" style="position:absolute;display:none;top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;padding:12px;"></div>
</div>

<div id="g_profiles">
</div>
<div id="g_profiles_loading" style='display:none;text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
<script>
gProfile(<?php echo $gid ?>);
gMember(<?php echo $gid ?>);
$('#searchU').keyup(function(){
	searchMember(<?php echo $gid ?>);
});
function gMember(gid)
{
var requ = "searchMember";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"../includes/group_channel_request.php",
    data:{'req':requ,'path':path,'gid':gid},
    beforeSend:function(){
   $('#m_members_search').html("<div style='text-align: center; padding: 15px;'><img src='../imgs/loading_video.gif'></div>");
    },
    success:function(data){
		 $('#m_group_member').html(data);
		 $('#m_members_search').hide();
    }
});
}
function searchMember(gid){
var requ = "getSearchMember";
var path = "<?php echo $check_path; ?>";
var mSearch = $.trim($('#searchU').val());
if (mSearch != '') {
$('#m_group_member').hide();
$('#m_members_search').show();
$.ajax({
    type:'POST',
    url:"../includes/group_channel_request.php",
    data:{'req':requ,'path':path,'mSearch':mSearch,'gid':gid},
    beforeSend:function(){
        $('#m_members_search').html("<div style='text-align: center; padding: 15px;'><img src='../imgs/loading_video.gif'></div>");
    },
    success:function(data){
     $('#m_members_search').html(data);
	 $('#m_members_search').show();
    }
});
}else{
   gMember(gid);
   $('#m_group_member').show();
   $('#m_members_search').hide();
}
}
function gUpdate(gid){
var groupName = $.trim($('#group_name').val());	
var groupDis = $.trim($('#group_dis').val());	
var edit=$("input[type='radio']:checked").val();
var send=$("input[type='radio']:checked").val();
var requ = "groupUpdate";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_group_request.php",
    data:{'gid':gid,'groupName':groupName,'groupDis':groupDis,'edit':edit,'send':send,'req':requ,'path':path},
    success:function(data){
	modal.style.display = "none";	
   gProfile(<?php echo $gid ?>,"timer");
   
    }
});
}
if (window.history && window.history.pushState) {
    $('#modal_box').on('click', function (e) {
		 $('#search_box').modal();
         $('#search_box').modal('open'); 
        window.history.pushState('forward', null, './<?php echo $gid ?>');
    });
    $(window).on('popstate', function () {
			history.replaceState(null, null, '');
          $('#search_box').modal('close'); 
    });
}
</script>
</body>
</html>	