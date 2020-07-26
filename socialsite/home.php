<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$myId = $_SESSION['id'];
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/time_function.php");
include ("includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: index");
}
$tc = filter_var(htmlentities($_GET['tc']),FILTER_SANITIZE_STRING);
if (is_dir("imgs/")) {
        $check_path = "";
    }elseif (is_dir("../imgs/")) {
        $check_path = "../";
    }elseif (is_dir("../../imgs/")) {
        $check_path = "../../";
    }
    $checkvisible_sql = "SELECT * FROM view WHERE novisible=:myId";
    $checkvisible = $conn->prepare($checkvisible_sql);
    $checkvisible->bindParam(':myId',$myId,PDO::PARAM_INT);
    $checkvisible->execute();
	while($visiblepost= $checkvisible->fetch(PDO::FETCH_ASSOC)){
		$viewpost_id=$visiblepost['post_id'];
		$postviewer=$visiblepost['viewer'];
		$postvisible=$visiblepost['novisible'];
	}
	$checkschedule_sql = "SELECT schedule FROM wpost";
    $checkschedule = $conn->prepare($checkschedule_sql);
    $checkschedule->execute();
	$checkschedule_Num=$checkschedule->rowCount();
	while($schedulepost= $checkschedule->fetch(PDO::FETCH_ASSOC)){
		$postschedule=$schedulepost['schedule'];
	}
	/*if($postvisible == $myId){
		"SELECT * FROM wpost WHERE ( p_privacy = :p_privacy) AND post_id !=:viewpost_id ORDER BY post_time DESC"
	}]
	elseif($checkschedule_Num > 0){
	"SELECT * FROM wpost WHERE ( p_privacy = :p_privacy) AND post_time=postschedule ORDER BY post_time DESC"	
	}
	else{
		"SELECT * FROM wpost WHERE ( p_privacy = :p_privacy) ORDER BY post_time DESC"
	}
	*/
?>
<html>
<head>
    <title>Home | Webapp</title>
    <meta charset="UTF-8">
    <meta name="description" content="This webapp is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,This webapp,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/head_imports_main.php";?>
	<link rel='stylesheet' href='addTabs.css' />
	<script src='AddTabs.js'></script>
	<script src='jquery.maxlength.js'></script>	
	<style>
	html, body {
   max-width: 100%;
    overflow-x: hidden;
}
.notiAlert{
    position: absolute;
    background: #f76363;
    color: #fff;
    padding: 10px 15px;
    width: 110px;
    text-align: center;
    border-radius: 100px;
    margin: 5px;
    cursor: default;
}
#loading{
	position:fixed;
	width:100%;
	height:100vh;
	background:#fff url('imgs/loading_video.gif') no-repeat center;
}
.Activetab{
  border-bottom: 5px solid #1376d4;
}
.discover{
	display:none;
}
.modal.bottom-sheet{
	max-height:60%;
	background:white;
	border-top-left-radius: 20px; 
    border-top-right-radius: 20px;
	padding-top:10px;
	overflow: auto;
}
.report.modal.bottom-sheet{
	max-height:50%;
	background:white;
	border-top-left-radius: 20px; 
    border-top-right-radius: 20px;
	padding-top:10px;
	overflow: auto;
}
@media only screen and (max-width: 600px) {
  .report.modal.bottom-sheet{
	max-height:40%;
	background:white;
	border-top-left-radius: 20px; 
    border-top-right-radius: 20px;
	padding-top:10px;
	overflow: auto;
}
}

#modal_box{
	max-height:60%;
}
.galleryItem img {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.galleryItem{
    color: #797478;
    font: 10px/1.5 Verdana, Helvetica, sans-serif;
    float: left;    
    width:50%;
	height:200px;
	background: #ccc;
}
@media only screen and (max-width : 720px),
only screen and (max-device-width : 720px){
    .galleryItem {height:150px;}
}
  .field_wrapper i { 
            position: absolute; 
			float:right;    } 
	</style>
</head>
<body style="background:white;">
<div  class = "rohit" style=" height:50px; position:fixed; width:100%; padding-bottom:30px; box-shadow: 0px 0px 18px rgba(63, 81, 181, 0.16);">
  <a class="" href="#"  style=" margin-top:10px;">Navbar Navbar</a>
  <a href="#modal_box" class="modal-trigger">
  <div style="float:right; margin-right:10px; margin-top:5px;">
                       <i class="medium material-icons">more_vert</i>   
                        </div></a>
  <a href="<?php echo $check_path; ?>u/<?php echo $_SESSION['Username']; ?>">
  <div style="width: 43px;height: 43px;border-radius: 50%; float:right; margin-right:10px; margin-top:5px; border-radius: 100%;">
                            <img style="width:auto;height: 100%; border-radius: 100%;" src="<?php echo $check_path.'imgs/user_imgs/'.$_SESSION['Userphoto']; ?>">
  </div></a>
</div>

<!---... -->
<div id="modal_box" class="modal bottom-sheet" style="height:60%; background:white; padding-top:5px;  overflow: auto;">
		  <div style="margin:0px auto; max-width:720px;">
		  <div class="container-fluid"> 		
<div class="center">
<div class="homeLinks" style="text-align:left;">
<a href="./settings"><p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/2699.png" /> <?php echo _SETTING; ?><i class="madium material-icons" style="float:right;">chevron_right</i></p> </a>
<a href="./settings?tc=language"><p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/1f998c4.png"/> <?php echo _LANGUAGE; ?></p></a>
<a href="./group"><p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/team.png" />Group  <i class="madium material-icons" style="float:right;">chevron_right</i></p></a>
<p class="homeLinks_title" style="margin-top:5px; border-bottom:none;"><?php echo _MYNOTEPAD; ?></p>
<a href="./mynotepad/new"><p class="homelinksP_borderL postIcon" style="margin-top:5px;"><img src="imgs/main_icons/270f.png" /> <?php echo _NEW_NOTE; ?>  <i class="madium material-icons" style="float:right;">chevron_right</i></p></a>
<?php
$msid = $_SESSION['id'];
$get_notes_sql="SELECT id,note_title FROM mynotepad WHERE author_id=:msid ORDER BY note_time DESC LIMIT 3";
$get_notes = $conn->prepare($get_notes_sql);
$get_notes->bindParam(':msid',$msid,PDO::PARAM_INT);
$get_notes->execute();
$notesCount = $get_notes->rowCount();
while($note_i = $get_notes->fetch(PDO::FETCH_ASSOC)){
$get_note_id = $note_i['id'];
$get_note_title = $note_i['note_title'];
?>
<a href="./mynotepad/"><p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/1f5d2.png" /> <?php if(strlen($get_note_title) > 20 ){$noteitem = substr($get_note_title, 0,20)."...";}else{$noteitem = $get_note_title;} echo $noteitem; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a>
<?php
}
?>
<a href="./mynotepad/"><p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/1f4d1.png" /> <?php echo _SEE_ALL_NOTES."<span>".thousandsCurrencyFormat($notesCount)."</span>"; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a>
<p class="homeLinks_title" style="margin-top:5px; border-bottom:none;"><?php echo _MORE; ?></p>
<a href="./posts/saved"><p class="homelinksP_borderL postIcon" style="margin-top:5px;"><img src="imgs/main_icons/1f516.png" /> <?php echo _SAVE_POSTS; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a>
<a href="page/supportbox"><p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/1f4e5.png" /> <?php echo _SUPPORT_BOX; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a>
<a href="page/report"><p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/1f4e4.png" /> <?php echo _REPORT_A_PROBLEM; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a>
<a href="logout.php"> <p class="homelinksP_borderL postIcon"><img src="imgs/main_icons/logout.png" />  </p></a>
    </div>
</div>        
		</div>
</div>
</div>
<!---... -->
<nav class="discover" >
    <div class="nav-wrapper">
      <form>
        <div class="input-field">
          <input id="search" type="search" required class="navbar_search"  id="searchq">
          <label class="label-icon" for="search"><i class="material-icons">search</i></label>
        </div>
      </form>
    </div>
</nav>
<div class="container-fluid">
 
 <?php switch ($tc) { ?>
<?php case 'search':
if($tc == 'search'){
		echo"
		<style>
		.rohit{display:none;}.discover{display:block;}
		</style>";
	}
	 ?>
<div>
 <div id="Search"  style="height: auto;">

      <div>
  <div style="margin:0px auto; max-width:600px;">
  <div class="navbar_fetchBox" id="search_r">
  <div  id="getSearchResult" class="scrollbar" style="overflow: auto;max-height: 450px;"></div>
  <p  id="LoadingSearchResult" style="background: url(imgs/loading_video.gif) center center no-repeat;width: 100%;height: 80px;margin: 0px;display: none;"></p>
  </div>
  <div  id="roh">
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
    $follow_btn = "<span id='followUnfollow_$id_4User' style='cursor:pointer'><span class=\"unfollow_btn\" onclick=\"followUnfollow('$id_4User')\"><span class=\"fa fa-check\"></span>  "._FOLLOWING." </span></span>";
}else{
    $follow_btn = "<span id='followUnfollow_$id_4User' style='cursor:pointer'><span class=\"follow_btn\" onclick=\"followUnfollow('$id_4User')\"><span class=\"fa fa-plus-circle\"></span>  "._FOLLOW."</span></span>";
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
<td style='padding:5px 5px;'><div><img src=\"imgs/user_imgs/$userphoto_4User\" alt=\"$fullname_4User\" /></div></td>
<td style=''><a href=\"u/$username_4User\" class='user_follow_box_a'><p>$fullname_4User $verifypage_var<br><span style='color:gray;'>@$username_4User</span></a></td>
<td style='width: 100%;'><span style='float:right;'>$fbtn</span></td>
</tr>
</table>
";
}
?>
  
	  </div>
       </div>
  </div>
	</div>
</div>
<?php break; ?>
<!--====================[ Languages section ]======================-->
<?php case 'video': ?>
<div style="margin-top:70px;">
<div id="Video"  style="height: auto;">
<div style="margin:0px auto; max-width:600px;">
 <div data-addui='tabs'>
    <div role='tabs'>
      <div><?= _FOR_YOU ?></div>
      <div><?= _FOLLOWING ?></div>
    </div>
    <div role='contents'>
      <div>
	  
 <?php
$s_id = $_SESSION['id'];
$check_path = filter_var(htmlspecialchars($_POST['path']),FILTER_SANITIZE_STRING);
$plimit = filter_var(htmlspecialchars($_POST['plimit']),FILTER_SANITIZE_NUMBER_INT);
$p_privacy = "0";
$emptypost = "";
$vpsql = "SELECT * FROM wpost INNER JOIN wpvideo ON  wpost.post_id = wpvideo.post_id  WHERE ( wpost.p_privacy = :p_privacy)  ORDER BY post_time DESC";
$view_posts = $conn->prepare($vpsql);
$view_posts->bindValue(':p_privacy', $p_privacy, PDO::PARAM_INT);
$view_posts->execute();
$view_postsNum = $view_posts->rowCount();
if ($view_postsNum > 0) {
	include "includes/fetch_posts.php";
}else{
	echo "0";
}
?>
	  
       </div>
 <div>
<?php
$s_id = $_SESSION['id'];
$check_path = filter_var(htmlspecialchars($_POST['path']),FILTER_SANITIZE_STRING);
$plimit = filter_var(htmlspecialchars($_POST['plimit']),FILTER_SANITIZE_NUMBER_INT);
$p_privacy = "2";
$vpsql = "SELECT * FROM wpost INNER JOIN wpvideo ON  wpost.post_id = wpvideo.post_id  AND wpost.author_id IN 
(SELECT uf_two FROM follow WHERE uf_one=:s_id) AND  ( wpost.p_privacy = :p_privacy) ORDER BY post_time DESC";
$view_posts = $conn->prepare($vpsql);
$view_posts->bindValue(':s_id', $s_id, PDO::PARAM_INT);
$view_posts->bindValue(':p_privacy', $p_privacy, PDO::PARAM_INT);
$view_posts->execute();
$view_postsNum = $view_posts->rowCount();
if ($view_postsNum > 0) {
	include "includes/fetch_posts.php";
}else{
	echo "0";
}
?>

      </div>
    </div>
  </div>
  
  </div>
    
</div>
</div>
<?php break; ?>
<?php case 'audio': ?>
<div style="margin-top:70px;">
<div id="Audio"  style="height: auto;">
   
   <div>
<div style="margin:0px auto; max-width:600px;">
 <div data-addui='tabs'>
    <div role='tabs'>
      <div><?= _FOR_YOU ?></div>
      <div><?= _FOLLOWING ?></div>
    </div>
    <div role='contents'>
      <div>
	  
	  <?php
$s_id = $_SESSION['id'];
$check_path = filter_var(htmlspecialchars($_POST['path']),FILTER_SANITIZE_STRING);
$plimit = filter_var(htmlspecialchars($_POST['plimit']),FILTER_SANITIZE_NUMBER_INT);
$p_privacy = "2";
$emptypost = "";
$vpsql = "SELECT * FROM wpost WHERE post_audio IS NOT NULL AND p_privacy != :p_privacy  ORDER BY post_time DESC";
$view_posts = $conn->prepare($vpsql);
$view_posts->bindValue(':p_privacy', $p_privacy, PDO::PARAM_INT);
$view_posts->execute();
$view_postsNum = $view_posts->rowCount();
if ($view_postsNum > 0) {
	include "includes/fetch_posts.php";
}else{
	echo "0";
}
?>
	  
       </div>
      <div>
	  
	 <?php
$s_id = $_SESSION['id'];
$check_path = filter_var(htmlspecialchars($_POST['path']),FILTER_SANITIZE_STRING);
$plimit = filter_var(htmlspecialchars($_POST['plimit']),FILTER_SANITIZE_NUMBER_INT);
$p_privacy = "2";
$emptypost = "";
$vpsql = "SELECT * FROM wpost WHERE  post_audio!= ? AND author_id IN 
(SELECT uf_two FROM follow WHERE uf_one=?) AND p_privacy != ? ORDER BY post_time DESC";
$params = array("$emptypost","$s_id", "$p_privacy");
$view_posts = $conn->prepare($vpsql);
$view_posts->execute($params);
$view_postsNum = $view_posts->rowCount();
if ($view_postsNum > 0) {
	include "includes/fetch_posts.php";
}else{
	echo "0";
}
?> 
	  	</div> 
        </div>
    </div>
  </div>
  </div> 
  </div>
<?php break; ?>
<?php case 'notification': ?>
<div>
<div id="Notification"  style="height: auto;">
 
 <div>
 <main role="main">
  <h4 style="text-align:center;"><?= _NOTIFICATION ?></h4>
</div>
          <hr/>
		</main> </div>
<div style="margin:0px auto; max-width:600px;">
  <div>
  <div style="padding: 16px 10px; display:none; max-width:720px;" id="nav_Noti_Btn" ><span class="fa fa-bell"></span> <?= _NOTIFICATION ?><span ></span></div>
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
 
</div>
<?php break; ?>
<!--====================[ General section ]======================-->
<?php default: ?>

<div id="Home"  style="height: auto;">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ... nncbbhb hjzb hvjz home
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    	<div style="margin:0px auto; max-width:600px;">
	 <div class="write_post" style="margin-top:60px;">
                <?php echo $err_success_Msg; ?>
                    <?php include("includes/w_post_form.php"); ?>
                </div>
  <div data-addui='tabs'>
  <div>
    <div role='tabs'>
      <div id="foryoupost"><?= _FOR_YOU ;?></div>
      <div id="followingpost"><?= _FOLLOWING ?></div>
      <div id="group_post" onclick="getfile('modal')">Groups</div>
    </div>
	</div>
    <div role='contents'>
      <div>
	  <div id="foryou">
			</div>
			<div id="m_post_loading" style='text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
       </div>
	
	   <!---->
	  
      <div>
	  <div id="following_home">
	  <div id="m_post_loading" style='text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
			</div>
       </div>
	  
	 
      <div>  
	<div id="groups_post_home">
	<div id="m_post_loading" style='text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
			</div>
       </div>
	   
	 
       </div>
    </div>
  </div>
	
  
  </div>
  
   
<?php  break; } ?>

 </div>
 
</div>
</div>
<!-- floating 
<div class="fixed-action-btn" style="right: 23px; bottom: 65px;">
  <a class="btn-floating btn-large red" href="messages/message">
    <i class="large material-icons">message</i>
  </a>
</div>  -->
<div class="fixed-action-btn" style="right: 23px; bottom: 65px;">
  <a class="btn-floating btn-large red" id="messages">
    <i class="large material-icons">message</i>
  </a>
</div> 
<!-- floating -->.
<div id="nav_newNotify" data-show='0'>
</div>
	<div style="" id='nSound'></div>					
 <div   style=" position: fixed;bottom: 0; width: 100%;">
    <footer class="page-footer" style="padding-top:0;">  
<ul class="tabs tabs-fixed-width transparent white-text z-depth-1" >
  <li class="tab  white-text" ><a href="?tc=home" id="a_home" class=" white-text <?php if($tc == 'home' or $tc == ''){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">home</i></a></li>
  <li class="tab "><a href="?tc=search" id="a_search" class=" white-text <?php if($tc == 'search'){echo 'Activetab';} ?>" ><i class="material-icons" style="line-height: 1.6;">search</i> </a></li>
  <li class="tab "><a href="?tc=video" id="a_video" class=" white-text <?php if($tc == 'video'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">ondemand_video</i></a></li>
  <li class="tab "><a href="?tc=audio" id="a_audio" class=" white-text <?php if($tc == 'audio'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">audiotrack</i></a></li>
  <li class="tab "><a href="?tc=notification" id="a_notification" class=" white-text <?php if($tc == 'notification'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">notifications</i></a></li>
</ul>
  </footer>
</div>
<!-- Compiled and minified JavaScript -->
<script>
 function getfile(data) {
        var file= data+'.html';
        $('#groups_post_home').load(file);
        history.pushState(null, null, file);
    }
$("#messages"). click(function(){
$('body').load(messages/message.php);
  history.pushState(null, null, file);
  alert("load");
});	
$(document).ready(function(){
      $('.modal').modal();
var pathname = window.location.href;
//alert(pathname);
    });
	foryou();followingHome();groupsHome();
	$('#foryoupost').on('click',function(){
	 foryou();
	});  
	$('#following_home').on('click',function(){
	followingHome();
	});  
function foryou(){$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/fetch_posts.php",
    beforeSend:function(){
	$('#m_post_loading').show();
    },
    success:function(data){
   $('#m_post_loading').hide();
   $('#foryou').html(data);
    }
}); }	
function followingHome(){$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/fetch_following_home.php",
    beforeSend:function(){
    },
    success:function(data){
   $('#m_post_loading').hide();
   $('#following_home').html(data);
    }
}); }	
/*function groupsHome(){$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/group_post_home.php",
    beforeSend:function(){
    },
    success:function(data){
   $('#m_post_loading').hide();
   $('#groups_post_home').html(data);
    }
}); }*/	
function video(){$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/fetch_posts.php",
    beforeSend:function(){
    },
    success:function(data){
   // $('#m_messages_loading').hide();
    $('#m_post_loading').hide();
    $('#m_messages').html(data);
	//alert(data);
    }
}); }	

</script>   
     <script type="text/javascript">
function chNewMsgs(){
var requ = "checkUnseenMsgs";
var path = "<?php echo $dircheckPath; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $dircheckPath; ?>includes/m_requests.php",
    data:{'req':requ,'path':path},
    success:function(data){
     $('#messagesCount').html(data);
    }
});
}
chNewMsgs();
// setInterval every 5 sec
function refRequests(){
    chNewMsgs();
    chNoti();
}
setInterval(refRequests,5000);
</script>
<script>
var preloader= document.getElementById('loading');
function myFunction(){
	preloader.style.display='none';
}
</script>
<!---- search --->
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
<!---->
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
