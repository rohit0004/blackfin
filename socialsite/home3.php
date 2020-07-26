<script> 
var mysid= localStorage.getItem('sessionid');
var sid=mysid;
if(sid!=""){
}
else{
	
}
</script>
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
	<script src='jquery.maxlength.js'>
</script>	
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
.custom_display {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}	
..post{
	background:green;
}	
.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
  padding-top: 60px;
}
	
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
<body style="background:red;">
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
   <!--    <nav>
            <div class="nav-wrapper">
              <a href="#!" class="brand-logo center">Logo</a>
             <a href="#" data-target="slide-out" class="sidenav-trigger show-on-large"><i class="material-icons">menu</i></a>
            </div> 
		</nav> 
  <!----->
  <ul id="slide-out" class="sidenav">
    <li><div class="user-view" style="background:red;">
      <a href="#user"><img class="circle" src="https://www.w3schools.com/howto/img_avatar.png" style=""></a>
      <a href="#name"><span class="white-text name">John Doe</span></a>
      <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a>
    </div></li>
	<div class="homeLinks" style="text-align:left;">
    <li><a href="settings2.php"><i class="material-icons">settings</i> <?php echo _SETTING; ?></a></li>
    <li><a href="#!"><i class="material-icons">language</i> <?php echo _LANGUAGE; ?></a></li>
	<li><a href="group"><i class="material-icons">group</i>Groups</a></li>
	<li><a href="posts/saved"><i class="material-icons">bookmark</i><?php echo _SAVE_POSTS; ?></a></li>
	<li><a href="page/supportbox"><i class="material-icons">add_box</i><?php echo _SUPPORT_BOX; ?></a></li>
	<li><a href="page/report"><i class="material-icons">report_problem</i><?php echo _REPORT_A_PROBLEM; ?></a></li>
	<li><a href="display.php" ><i class="material-icons">brush</i>Custom display</a></li>
    <li><a href="logout.php"><i class="material-icons">language</i>logout</a></li>
	</div>
 </ul>	
<div id="wrapper"></div>
    <script>
    // Storing HTML code block in a variable
    var codeBlock =  '<div   style="width: 100%; position:fixed; background:red;" id="tabmenu">' +
                        '<ul class="tabs tabs-fixed-width transparent white-text z-depth-1" >' +
                        ' <a href="#" data-target="slide-out" class="sidenav-trigger" style=""><i class="material-icons" style="margin-top:10px;margin-left:20px;">menu</i></a>' +
                        ' <li class="tab  white-text" ><a href="?tc=home" id="a_home" class=" white-text <?php if($tc == 'home' or $tc == ''){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">home</i></a></li>'
						+'<li class="tab "><a href="?tc=search" id="a_search" class=" white-text <?php if($tc == 'search'){echo 'Activetab';} ?>" ><i class="material-icons" style="line-height: 1.6;">search</i> </a></li>'
						+'<li class="tab "><a href="?tc=video" id="a_video" class=" white-text <?php if($tc == 'video'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">ondemand_video</i></a></li>'
						+'<li class="tab "><a href="?tc=audio" id="a_audio" class=" white-text <?php if($tc == 'audio'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">audiotrack</i></a></li>'
						+'<li class="tab "><a href="<?php echo $check_path; ?>u/<?php echo $_SESSION['Username']; ?>" id="a_notification" class=" white-text <?php if($tc == 'notification'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">notifications</i></a></li>'
						+'</ul>'+
                    '</div>';
	var bottomtab =  '<div   style="width: 100%; position:fixed;bottom:0; background:red;" id="tabmenu">' +
                        '<ul class="tabs tabs-fixed-width transparent white-text z-depth-1" >' +
                        ' <a href="#" data-target="slide-out" class="sidenav-trigger" style=""><i class="material-icons" style="margin-top:10px;margin-left:20px;">menu</i></a>' +
                        ' <li class="tab  white-text" ><a href="?tc=home" id="a_home" class=" white-text <?php if($tc == 'home' or $tc == ''){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">home</i></a></li>'
						+'<li class="tab "><a href="?tc=search" id="a_search" class=" white-text <?php if($tc == 'search'){echo 'Activetab';} ?>" ><i class="material-icons" style="line-height: 1.6;">search</i> </a></li>'
						+'<li class="tab "><a href="?tc=video" id="a_video" class=" white-text <?php if($tc == 'video'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">ondemand_video</i></a></li>'
						+'<li class="tab "><a href="?tc=audio" id="a_audio" class=" white-text <?php if($tc == 'audio'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">audiotrack</i></a></li>'
						+'<li class="tab "><a href="<?php echo $check_path; ?>u/<?php echo $_SESSION['Username']; ?>" id="a_notification" class=" white-text <?php if($tc == 'notification'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">notifications</i></a></li>'
						+'</ul>'+
                    '</div>';				
					
    
    // Inserting the code block to wrapper element
    document.getElementById("wrapper").innerHTML = codeBlock
    </script> 
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
echo "show following video";
?>
	  
       </div>
 <div>
<?php
echo "show following video";
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
   <!---message-->
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
 <!---message-->  
  </div>
<?php break; ?>
<?php case 'notification': ?>
<div>
<?php
echo "notificatioon";
?>
</div>
<?php break; ?>
<!--====================[ General section ]======================-->
<?php default: ?>
<div id="Home"  style="height: auto;">
    	<div style="margin:0px auto; max-width:600px;">
		<div class="write_post" style="margin-top:60px;">
           <?php echo $err_success_Msg; ?>
        <?php //include("includes/w_post_form.php"); ?>
              </div>
		<div id="default_menu"></div>   
		</div>
  </div>

<?php  break; } ?>

 </div>
 
</div>
</div>
<script>
    // Storing HTML code block in a variable
	var bottomtab =  '<div   style="width: 100%; position:fixed;bottom:0; background:red;" id="tabmenu">' +
                        '<ul class="tabs tabs-fixed-width transparent white-text z-depth-1" >' +
                        ' <a href="#" data-target="slide-out" class="sidenav-trigger" style=""><i class="material-icons" style="margin-top:10px;margin-left:20px;">menu</i></a>' +
                        ' <li class="tab  white-text" ><a href="?tc=home" id="a_home" class=" white-text <?php if($tc == 'home' or $tc == ''){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">home</i></a></li>'
						+'<li class="tab "><a href="?tc=search" id="a_search" class=" white-text <?php if($tc == 'search'){echo 'Activetab';} ?>" ><i class="material-icons" style="line-height: 1.6;">search</i> </a></li>'
						+'<li class="tab "><a href="?tc=video" id="a_video" class=" white-text <?php if($tc == 'video'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">ondemand_video</i></a></li>'
						+'<li class="tab "><a href="?tc=audio" id="a_audio" class=" white-text <?php if($tc == 'audio'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">audiotrack</i></a></li>'
						+'<li class="tab "><a href="<?php echo $check_path; ?>u/<?php echo $_SESSION['Username']; ?>" id="a_notification" class=" white-text <?php if($tc == 'notification'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">notifications</i></a></li>'
						+'</ul>'+
                    '</div>';		

var bydefault=
' <div data-addui="tabs"><div><div role="tabs"><div id="foryoupost"><?= _FOR_YOU ;?></div><div id="followingpost"><?= _FOLLOWING ?></div>'+
      '<div id="group_post" onclick="getfile("modal")">Groups</div>'+
   '</div>'+
	'</div>'+
    '<div role="contents">'+
     ' <div>'+
	  '<div id="foryou">'+
			'</div>'+
			'<div id="m_post_loading" style="text-align: center; padding: 15px;"><img src="<?php echo $check_path; ?>imgs/loading_video.gif"></div>'+
       '</div>'+
	
	   <!---->
	  
      '<div>'+
	  '<div id="following_home">'+
	  '<div id="m_post_loading" style="text-align: center; padding: 15px;"><img src="<?php echo $check_path; ?>imgs/loading_video.gif"></div>'+
			'</div>'+
       '</div>'+
	  
	 
     '<div>' +
	'<div id="groups_post_home">'+
	'<div id="m_post_loading" style="text-align: center; padding: 15px;"><img src="<?php echo $check_path; ?>imgs/loading_video.gif"></div>'+
			'</div>'+
       '</div>'+
       '</div>'+
    '</div>';
  
    // Inserting the code block to wrapper element
 document.getElementById("default_menu").innerHTML = bydefault
 </script> 
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
<div id="bottom_menu"></div>	
<script>
    // Storing HTML code block in a variable
	var bottomtab =  '<div   style="width: 100%; position:fixed;bottom:0; background:red;" id="tabmenu">' +
                        '<ul class="tabs tabs-fixed-width transparent white-text z-depth-1" >' +
                        ' <a href="#" data-target="slide-out" class="sidenav-trigger" style=""><i class="material-icons" style="margin-top:10px;margin-left:20px;">menu</i></a>' +
                        ' <li class="tab  white-text" ><a href="?tc=home" id="a_home" class=" white-text <?php if($tc == 'home' or $tc == ''){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">home</i></a></li>'
						+'<li class="tab "><a href="?tc=search" id="a_search" class=" white-text <?php if($tc == 'search'){echo 'Activetab';} ?>" ><i class="material-icons" style="line-height: 1.6;">search</i> </a></li>'
						+'<li class="tab "><a href="?tc=video" id="a_video" class=" white-text <?php if($tc == 'video'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">ondemand_video</i></a></li>'
						+'<li class="tab "><a href="?tc=audio" id="a_audio" class=" white-text <?php if($tc == 'audio'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">audiotrack</i></a></li>'
						+'<li class="tab "><a href="<?php echo $check_path; ?>u/<?php echo $_SESSION['Username']; ?>" id="a_notification" class=" white-text <?php if($tc == 'notification'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">notifications</i></a></li>'
						+'</ul>'+
                    '</div>';				   
    // Inserting the code block to wrapper element
    document.getElementById("bottom_menu").innerHTML = bottomtab
 </script> 
<!-- <div   style=" position: fixed;bottom: 0; width: 100%;">
    <footer class="page-footer" style="padding-top:0;">  
<ul class="tabs tabs-fixed-width transparent white-text z-depth-1" >
  <li class="tab  white-text" ><a href="?tc=home" id="a_home" class=" white-text <?php if($tc == 'home' or $tc == ''){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">home</i></a></li>
  <li class="tab "><a href="?tc=search" id="a_search" class=" white-text <?php if($tc == 'search'){echo 'Activetab';} ?>" ><i class="material-icons" style="line-height: 1.6;">search</i> </a></li>
  <li class="tab "><a href="?tc=video" id="a_video" class=" white-text <?php if($tc == 'video'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">ondemand_video</i></a></li>
  <li class="tab "><a href="?tc=audio" id="a_audio" class=" white-text <?php if($tc == 'audio'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">audiotrack</i></a></li>
  <li class="tab "><a href="?tc=notification" id="a_notification" class=" white-text <?php if($tc == 'notification'){echo 'Activetab';} ?>"><i class="material-icons" style="line-height: 1.6;">notifications</i></a></li>
</ul>
  </footer>
</div>-->
<!-- Compiled and minified JavaScript -->
<script>
 localStorage.setItem('sessionid', "<?php echo $myId ?>");
var retrievedObject = localStorage.getItem('homebackground');
document.body.style.background = retrievedObject;
var postbg = localStorage.getItem('postbackground');
$('#foryou').on("click",".post",function(){
	$("#foryou .post").css("background-color", postbg);
});
 $(".user-view").css("background-color", retrievedObject);
 //$(".homeLinks").css("background-color", postbg);
 function getfile(data) {
        var file= data+'.html';
        $('#groups_post_home').load(file);
    }
$("#messages"). click(function(){
$('body').load(messages/message.php);
  history.pushState(null, null, file);
  alert("load");
});	
$(document).ready(function(){
	 $('.sidenav').sidenav({
	  edge	:	'right',	 
      closeOnClick: true, 
      draggable: true 
    });
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
// Get the modal
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0]; 
btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script> 
</body>
</html>
