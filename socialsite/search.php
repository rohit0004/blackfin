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
	
	<link rel="stylesheet" href="css/style.css">
  <style>
  *{margin:0px;padding:0px;}
.navbar_search{
border-bottom: 1px solid #f48fb1;
 box-shadow: 0px 0px 18px rgba(63, 81, 181, 0.16);
width:100%;
 display: block;
 float:left;
}
.navbar_fetchBox{
    display: none;
    position: absolute;
    background: #ffffff;
    margin: 0px 8px;
    height: auto;
    max-height: 600px;
    max-width: 480px;
    border-radius: 2px;
	width:480px;
	top:50;
	
}
.navbar_fetchBox a,.fetchNotifications a{
    text-decoration: none;
}
.navbar_fetchBox a:hover,.navbar_fetchBox a:focus,.fetchNotifications a:hover,.fetchNotifications a:focus{
    text-decoration: none;
}
.navbar_fetchBox p,.fetchNotifications p{
    margin: 0;
    color: rgba(0, 0, 0, 0.88);
    font-size: 16px;
    padding: 5px;
    width: 100%;
}
.navbar_fetchBox span,.fetchNotifications span{
    color: rgba(0, 0, 0, 0.57);
}
#sqresultItem:hover{
    background: rgba(0, 0, 0, 0.03);
}   
.navbar_fetchBoxUser{
    overflow: hidden;
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 100px;
    margin: 8px;
}
.navbar_fetchBoxUser img{
    width: auto;
    height: 100%;
}
/* ################### Scrollbar style [navbar_fetchBoxUser] ################### */
.scrollbar::-webkit-scrollbar{
    height:10px;
    width:5px;
    border-radius: 20px;
    background: transparent;
        transition: all 0.3s ease;
}
.scrollbar::-webkit-scrollbar:hover{
    background: #c6c7ca;
    width: 10px !important;
}
.scrollbar::-webkit-scrollbar-thumb{
    background:#a0a0a0;
    border-radius: 20px;
}
.user_follow_box{
    padding: 8px;
    width: 100%;
    display: block;
    background: #ffffff;
}
.user_follow_box tbody{
    width: 100%;
}
.user_follow_box:hover,.user_follow_box:focus{
    background: #eceef3;
}
.user_follow_box tr td div{
    width: 60px;
    height: 60px;
    border-radius: 100%;
    border: 1px solid rgba(0, 0, 0, 0.07);
    overflow: hidden;
}
.user_follow_box tr td div img{
    width: auto;
    height: 100%;
}
.user_follow_box_a{
    text-decoration: none;
    color: #000000;
}
.user_follow_box_a:hover,.user_follow_box_a:focus{
    text-decoration: none;
    color: #000000;
}
.user_follow_box tr td p{
    margin: 0px 25px;
}
  </style>
</head>
<body>

<!-- Search form -->
<div>
<input type="text" class="navbar_search" class="form-control" id="searchq" dir="auto"  name="navbar_search" placeholder="Search..." style="padding:10px;">
</div>
  <div>
  <div style="margin:0px auto; max-width:560px;">
  <div class="navbar_fetchBox" id="search_r">
  <div  id="getSearchResult" class="scrollbar" style="overflow: auto;max-height: 450px;"></div>
  <p  id="LoadingSearchResult" style="background: url(imgs/loading_video.gif) center center no-repeat;width: 100%;height: 80px;margin: 0px;display: none;"></p>
  </div>
  <div  class="post" id="roh">
  <?php
$all_users_sql = "SELECT * FROM signup ORDER BY id DESC";
$all_users = $conn->prepare($all_users_sql);
$all_users->execute();
while ($fetch_users = $all_users->fetch(PDO::FETCH_ASSOC)) {
$id_4User = $fetch_users['id'];
$fullname_4User = $fetch_users['Fullname'];
$username_4User = $fetch_users['Username'];
$userphoto_4User = $fetch_users['Userphoto'];
$verify_4User = $fetch_users['verify'];
$csql = "SELECT id FROM follow WHERE uf_one=:s_id AND uf_two=:id_4User";
$c = $conn->prepare($csql);
$c->bindParam(':s_id',$s_id,PDO::PARAM_INT);
$c->bindParam(':id_4User',$id_4User,PDO::PARAM_INT);
$c->execute();
$c_num = $c->rowCount();
if ($c_num == 1){
    $follow_btn = "<span id='followUnfollow_$id_4User' style='cursor:pointer'><span class=\"unfollow_btn\" onclick=\"followUnfollow('$id_4User')\"> "._FOLLOWING." </span></span>";
}else{
    $follow_btn = "<span id='followUnfollow_$id_4User' style='cursor:pointer'><span class=\"follow_btn\" onclick=\"followUnfollow('$id_4User')\"> "._FOLLOW."</span></span>";
}
if ($verify_4User == "1"){
$verifypage_var = $verifyUser;
}else{
$verifypage_var = "";
}
if($id_4User != $_SESSION['id']){
    $fbtn = $follow_btn;
}else{
    $fbtn = '';
}
echo "
<table class='user_follow_box'>
<tr>
<td><div><img src=\"imgs/user_imgs/$userphoto_4User\" alt=\"$fullname_4User\" /></div></td>
<td style='width: 70%;'><a href=\"u/$username_4User\" class='user_follow_box_a'><p>$fullname_4User $verifypage_var<br><span style='color:gray;'>@$username_4User</span></a></td>
<td style='width: 100%;'><span style='float:right;'>$fbtn</span></td>
</tr>
</table>
";
}
?>
	  </div>
       </div>
  </div>
  
  
  
  
  


<script>
$(".navbar_search").keyup(function() {
var sbar = $(this).val();
var dircheckPath = "<?php echo $dircheckPath; ?>";
if(sbar == ''){
$("#getSearchResult").hide();
$("#roh").show();
}
else{
$.ajax({
type: "POST",
url: "<?php echo $dircheckPath; ?>includes/searchq.php",
data: {'search_user':sbar,'dircheckPath':dircheckPath},
cache: false,
beforeSend:function(){
    $('#LoadingSearchResult').show();
	$("#roh").hide();
    $('#getSearchResult').hide();
},
success: function(html){
$('#LoadingSearchResult').hide();
$("#roh").hide();
$("#getSearchResult").html(html).show();
}});
}return false; 
});
$("#searchq").click(function(e){
    $("#search_r").show();
     e.stopPropagation();
});
$("#search_r").keyup(function(e){
    e.stopPropagation();
});
</script>
 <script>
 function followUnfollow(id){
  $.ajax({
        type:'POST',
        url:"<?php echo $dircheckPath; ?>includes/f_action.php",
        data:{'id':id},
        beforeSend:function(){
             $('#followUnfollow_'+id).html("<button class=\"unfollow_btn\"><?php echo _FOLLOWING  ?></button>");
        },
        success:function(fmsg){
            $('#followUnfollow_'+id).html(fmsg);
        },
        error:function(){
            alert('Some problem occured, please try again.');
        }
    });
}
</script>
</body>
</html>
