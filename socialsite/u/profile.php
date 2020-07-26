<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$myId = $_SESSION['id'];
include("../config/connect.php");
include("../includes/fetch_users_info.php");
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
	
$id=$row_id;
?>
<html>
<head>
    <title> | Socilsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
    <?php include "../includes/head_imports_main.php";?>
    <link rel='stylesheet' href='../addTabs.css' />
	<script src='../AddTabs.js'></script>
	<link rel='stylesheet' href='../css/style.css'/>
	<style>
	html, body {
    max-width: 100%;
    overflow-x: hidden;
}
#loading{
	position:fixed;
	width:100%;
	height:100vh;
	background:#fff url('../imgs/loading_video.gif') no-repeat center;
}
.bottom-sheet{
  max-height: 100% !important;
}

.bottom-sheet .row{
  width: 50%;
  margin: 0px auto;
}

.bottom-sheet #feedbackStatus{
  font-weight: bold
}
.model{
	padding-top:0;
}
@media screen and (max-width: 560px) {
.sidenav{
	position: fixed;
    width: 400px;
    left: 0px;
    top: 0px;
    margin: 0px;
    z-index: 999;
    overflow-y: auto;
    transform: translateX(-105%);
}
}
.sidenav{
	position: fixed;
    width: 300px;
    left: 0px;
    top: 0px;
    margin: 0px;
    z-index: 999;
    overflow-y: auto;
    transform: translateX(-105%);
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
}
@media only screen and (max-width : 720px),
only screen and (max-device-width : 720px){
    .galleryItem {height:100px;}
}
	</style>
</head>
<script>
function myFunction() {
 $('#modal_box').modal();
  $('#modal_box').modal('open'); 
}
function following(){
	$('#modal_box1').modal();
  $('#modal_box1').modal('open'); 	
}
</script>
<body style="background:white;">
<div></div>
<!--sidebar-->
         <nav>
            <div class="nav-wrapper">
              <a href="#!" class="brand-logo center">Logo</a>
              
             <a href="#" class="sidenav-trigger show-on-large" data-target="menu-side">
               <i class="material-icons">menu</i>
             </a>
            </div>
          </nav>   
           <div class="container section">
             <ul class="sidenav" id="menu-side">
 
		   
             </ul>
           </div>
<!--sidebar-->
<!-- followers -->
<div id="modal_box" class="modal bottom-sheet" style="height:100vh; background:white; padding-top:0;">
   <a style="float:left; margin:10px;" href="#!" class=" modal-action modal-close  modal-close"> <i class="medium material-icons">expand_more</i></a>
   <div style="text-align:center; margin:20px;">
 <h5><?php echo $row_fullname; ?></h5>
</div>
 <div style="margin:0px auto; max-width:600px;">
   <div class="profile_cneterCol_2">
   <div id="followers_section">
<?php
if ($_SESSION['id'] == $row_id) {
    $followers_paragraph = _YOUR_FOLLOWER;
}
else{
    if ($_SESSION['id'] != $row_id) {
    $followers_paragraph = _FOLLOWERS_TITLE." $row_fullname";
    }else{
    $followers_paragraph = "$row_fullname "._FOLLOWERS_TITLE."";
    }

}
?>
<p class="small_caps_paragraph" style="margin-left:10px; font-size:large;"><?php echo $followers_paragraph; ?></p>
<?php
$s_id = $_SESSION['id'];
$getfollowers_sql = "SELECT * FROM follow WHERE uf_two=:row_id";
$getfollowers = $conn->prepare($getfollowers_sql);
$getfollowers->bindParam(':row_id',$row_id,PDO::PARAM_INT);
$getfollowers->execute();
$num_followers = $getfollowers->rowCount();
if ($num_followers == 0) {
echo "<p style='color:gray;padding:5px;margin:0;font-size:18px;text-align:center;'>"._NOTHINGSHOW."</p>";
}else{
while ($getfollow = $getfollowers->fetch(PDO::FETCH_ASSOC)) {
$getfollow_id = $getfollow['uf_one'];
$ufollowers_sql = "SELECT * FROM signup WHERE id=:getfollow_id";
$ufollowers = $conn->prepare($ufollowers_sql);
$ufollowers->bindParam(':getfollow_id',$getfollow_id,PDO::PARAM_INT);
$ufollowers->execute();
if ($getfollow_id == $_SESSION['id']) {
    if ($_SESSION['verify'] == "1") {
     $verifypage_var = $verifyUser;
    }else{
     $verifypage_var = "";
    }
echo "
<table class='user_follow_box'>
<tr>
<td class='user_info_tdi'><div><img src=\"../imgs/user_imgs/".$_SESSION['Userphoto']."\" alt=\"".$_SESSION['Fullname']."\" /></div></td>
<td style='width: 70%;'><a href=\"".$_SESSION['Username']."\" class='user_follow_box_a'><p>".$_SESSION['Fullname']." ".$verifypage_var."<br><span style='color:gray;'>@".$_SESSION['Username']."</span></a></td>
</tr>
</table>
";
}
while ($fetch_followers = $ufollowers->fetch(PDO::FETCH_ASSOC)) {
$id_followers = $fetch_followers['id'];
$fullname_followers = $fetch_followers['Fullname'];
$username_followers = $fetch_followers['Username'];
$userphoto_followers = $fetch_followers['Userphoto'];
$verify_followers = $fetch_followers['verify'];
$followBtn_sql = "SELECT id FROM follow WHERE uf_one=:s_id AND uf_two=:id_followers";
$followBtn = $conn->prepare($followBtn_sql);
$followBtn->bindParam(':s_id',$s_id,PDO::PARAM_INT);
$followBtn->bindParam(':id_followers',$id_followers,PDO::PARAM_INT);
$followBtn->execute();
$followBtn_num = $followBtn->rowCount();
if ($followBtn_num > 0){
    $follow_btn = "<span id='followUnfollow_$id_followers' style='cursor:pointer'><button class=\"unfollow_btn\" onclick=\"followUnfollow('$id_followers')\"><span class=\"fa fa-check\"></span> "._FOLLOWING."</button></span>";
}else{
    $follow_btn = "<span id='followUnfollow_$id_followers' style='cursor:pointer'><button class=\"follow_btn\" onclick=\"followUnfollow('$id_followers')\"><span class=\"fa fa-plus-circle\"></span> "._FOLLOW."</button></span>";
}
if ($verify_followers == "1"){
$verifypage_var = $verifyUser;
}else{
$verifypage_var = "";
}
if($id_followers != $_SESSION['id']){
       echo "
<table class='user_follow_box post' style='background: #fbf5f5;'>
<tr>
<td class='user_info_tdi'><div style='margin-left:10px;'><img src=\"../imgs/user_imgs/$userphoto_followers\" alt=\"$fullname_followers\" /></div></td>
<td style='width: 70%;'><a href=\"$username_followers\" class='user_follow_box_a'><p>$fullname_followers $verifypage_var<br><span style='color:gray;'>@$username_followers</span></a></td>
<td style='width: 100%;'><span style='float:right; margin-right:10px;'>$follow_btn</span></td>
</tr>
</table>
";
}
}
}
}
?>
</div>
   </div>
</div>

<br>
<br>
</div>
 
<!--- following-->
<div id="modal_box1" class="modal bottom-sheet" style="height:100vh; background:white; padding-top:0;">
  <a style="float:left; margin:10px;" href="#!" class=" modal-action modal-close  modal-close"> <i class="medium material-icons">expand_more</i></a>
   <div style="text-align:center; margin:20px;">
 <h5><?php echo $row_fullname; ?></h5>
</div>
 <div style="margin:0px auto; max-width:600px; ">
   <div class="profile_cneterCol_2">
 <div id="followeing_section">
<?php
if ($_SESSION['id'] == $row_id) {
    $following_paragraph = _PEOPLE_WHO_YOU_R_FOLLOWING;
}else{
    if ($row_gender == "Male") {
        $genser_f = _HE;
    }elseif($row_gender == "Female"){
        $genser_f = _SHE;
    }
    $following_paragraph = _PEOPLE_THAT." $genser_f"._ARE_FOLLOWING;
}
?>
<p class="small_caps_paragraph" style="font-size:large;"><?php echo $following_paragraph; ?></p>
<?php
$s_id = $_SESSION['id'];
$getfolloweing_sql = "SELECT * FROM follow WHERE uf_one=:row_id";
$getfolloweing = $conn->prepare($getfolloweing_sql);
$getfolloweing->bindParam(':row_id',$row_id,PDO::PARAM_INT);
$getfolloweing->execute();
$num_followers = $getfolloweing->rowCount();
if ($num_followers == 0) {
echo "<p style='color:gray;padding:15px;margin:0;font-size:18px;text-align:center;'>"._NOTHINGSHOW."</p>";
}
else{
while ($getfolloweing_fetch = $getfolloweing->fetch(PDO::FETCH_ASSOC)) {
$getfolloweing_id = $getfolloweing_fetch['uf_two'];
$ufolloweing_sql = "SELECT * FROM signup WHERE id=:getfolloweing_id";
$ufolloweing = $conn->prepare($ufolloweing_sql);
$ufolloweing->bindParam(':getfolloweing_id',$getfolloweing_id,PDO::PARAM_INT);
$ufolloweing->execute();
if ($getfolloweing_id == $_SESSION['id']) {
    if ($_SESSION['verify'] == "1") {
     $verifypage_var = $verifyUser;
    }else{
     $verifypage_var = "";
    }
echo "
<table class='user_follow_box post' style='background: #fbf5f5;'>
<tr>
<td class='user_info_tdi'><div><img src=\"../imgs/user_imgs/".$_SESSION['Userphoto']."\" alt=\"".$_SESSION['Fullname']."\" /></div></td>
<td style='width: 70%;'><a href=\"".$_SESSION['Username']."\" class='user_follow_box_a'><p>".$_SESSION['Fullname']." ".$verifypage_var."<br><span style='color:gray;'>@".$_SESSION['Username']."</span></a></td>
</tr>
</table>
";
}
while ($fetch_followeing = $ufolloweing->fetch(PDO::FETCH_ASSOC)) {
$id_followeing = $fetch_followeing['id'];
$fullname_followeing = $fetch_followeing['Fullname'];
$username_followeing = $fetch_followeing['Username'];
$userphoto_followeing = $fetch_followeing['Userphoto'];
$verify_followeing = $fetch_followeing['verify'];
$followBtn_sql = "SELECT id FROM follow WHERE uf_one=:s_id AND uf_two=:id_followeing";
$followBtn = $conn->prepare($followBtn_sql);
$followBtn->bindParam(':s_id',$s_id,PDO::PARAM_INT);
$followBtn->bindParam(':id_followeing',$id_followeing,PDO::PARAM_INT);
$followBtn->execute();
$followBtn_num = $followBtn->rowCount();
if ($followBtn_num > 0){
    $follow_btn = "<span id='followUnfollow_$id_followeing' style='cursor:pointer'><button class=\"unfollow_btn\" onclick=\"followUnfollow('$id_followeing')\"><span class=\"fa fa-check\"></span> "._FOLLOWING."</button></span>";
}else{
    $follow_btn = "<span id='followUnfollow_$id_followeing' style='cursor:pointer'><button class=\"follow_btn\" onclick=\"followUnfollow('$id_followeing')\"><span class=\"fa fa-plus-circle\"></span> "._FOLLOW."</button></span>";
}
if ($verify_followeing == "1"){
$verifypage_var = $verifyUser;
}else{
$verifypage_var = "";
}
if($id_followeing != $_SESSION['id']){
       echo "
<table class='user_follow_box post' style='background: #fbf5f5;' id='UserUnfollow_$id_followeing'>
<tr>
<td class='user_info_tdi'><div style='margin-left:10px;'><img src=\"../imgs/user_imgs/$userphoto_followeing\" alt=\"$fullname_followeing\" /></div></td>
<td style='width: 70%;'><a href=\"$username_followeing\" class='user_follow_box_a'><p>$fullname_followeing $verifypage_var<br><span style='color:gray;'>@$username_followeing</span></a></td>
<td style='width: 100%;'><span style='float:right;margin-right:10px;'>$follow_btn</span></td>
</tr>
</table>
";
}
}
}
}
?>
</div>
   </div>
</div>

<br>
<br>
 </div>
 
<!--- following-->  
<?php
if (filter_var(htmlspecialchars($_GET['u']),FILTER_SANITIZE_STRING) == $row_username) {
?>
<!---->

  <!---->
<div class="container-fluid">
 <!-- <span style="font-size:30px;cursor:pointer; background:white;position:fixed;width:100%;margin-top:0px; padding:10px;box-shadow: 0px 0px 18px rgba(63, 81, 181, 0.16);" onclick="openNav()">&#9776; SocialSite</span>-->
 <div style="margin:0px auto; max-width:600px; ">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<?php
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/';
            $website_row = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row_website);
            ?>
				
				<div  class="pic" style="">
				<div class="profile-userpic profile_ppicture" style="text-align:center;">
		  <?php

            if ($row_id == $_SESSION['id']) {
            ?>
			<div id="uploaded_image">
			<img class="img-fluid z-depth-2 rounded-circle  image"  id="profilePhotoPreview"  src="<?php echo '../imgs/user_imgs/'.$row_user_photo; ?>"
          data-holder-rendered="true"  style="display:block; margin: auto auto; width:100px;height:100px;">
		  </div>
				 <div class="bottom-right">
				<?php
				include "../includes/uploadprofilephoto.php";
				?>
				<?php
				
				echo "
                <div class=\"change_user_photo\">

                <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">
                <label style='margin:0;'>
                    <p style='margin:0;color: #000;text-align: center;'><span class=\"fa fa-camera\"></span> "._UPLOAD."</p>
                    <input style=\"display: none;\" type=\"file\" accept=\"image/png, image/jpeg, image/jpeg\" name=\"photo_field\" onchange='profilePhoto(this);' />
                </label>
                <button type=\"submit\" name=\"submit_photo\" id='submitProfilePhoto' style='display:none;' >
                <span class='fa fa-check' style='
                background:rgba(62, 187, 74, 0.88);width: 100%;border-radius: 3px;padding: 2px;color: #fff;'> <span style='font-family: sans-serif;'>"._SAVE."
                <span></span></span></span></button>
                </form>
                </div>
                ";
				?>
				 </div>
				 <?php
			}
			else{
			?>
         <img class=" img-fluid z-depth-2 rounded-circle " alt="100x100" src="<?php echo '../imgs/user_imgs/'.$row_user_photo; ?>"
          data-holder-rendered="true"  style="display:block; margin: auto auto;width:100px;height:100px;">
		  	 <?php
			}
			?>
			 <?php
            if ($row_username == $_SESSION['Username']) {
                $userActive = "#4CAF50";
            }
			else{
                if ($row_online == "1") {
                    $userActive = "#4CAF50";
                }else{
                    $userActive = "#ccc";
                }
            }
            ?>
				<div class="userActive" style="background:<?php echo $userActive.';'?>">
				</div>
				
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
					<h4 style="margin-top:8px; margin-bottom:0px;"><?php echo $row_fullname;?></h4>
					
					</div>
					<div class="profile-usertitle-job">
						<p style="margin-top:0px;">@<?php echo $row_username;?></p>
					</div>
				</div>
				 <?php
                if($row_id == $_SESSION['id']){
                    echo "<span style='cursor:pointer;width:30%;display:inline-flex; margin-top:5px;'><a href='../settings?tc=edit_profile' class=\"silver_flat_btn\" style='width:100%;'><span class=\"fa fa-cog\"></span> "._EDIT_PROFILE."</a></span>";
                }
                ?>
				 <?php
               if($row_id != $_SESSION['id']){
                $csql = "SELECT id FROM follow WHERE uf_one=:s_id AND uf_two=:row_id";
                $c = $conn->prepare($csql);
                $c->bindParam(':s_id',$s_id,PDO::PARAM_INT);
                $c->bindParam(':row_id',$row_id,PDO::PARAM_INT);
                $c->execute();
                $c_num = $c->rowCount();
                if ($c_num > 0){
                    echo "<span id='followUnfollow_$row_id' style='cursor:pointer;display:inline-flex; width:30%; margin-top:5px;'><button class=\"unfollow_btn\" onclick=\"followUnfollow('$row_id')\"><span class=\"fa fa-check\"></span> "._FOLLOWING."</button></span>";
                }else{
                    echo "<span id='followUnfollow_$row_id' style='cursor:pointer;width:30%;display:inline-flex; margin-top:5px;'><button class=\"follow_btn\" onclick=\"followUnfollow('$row_id')\"><span class=\"fa fa-plus-circle\"></span> "._FOLLOW."</button></span>";
                }
                /*$sql = "SELECT id FROM r_star WHERE u_id = :uid AND p_id =:pid";
                $starCheck = $conn->prepare($sql);
                $starCheck->bindParam(':uid',$myId,PDO::PARAM_INT);
                $starCheck->bindParam(':pid',$row_id,PDO::PARAM_INT);
                $starCheck->execute();
                $starCheckExist = $starCheck->rowCount();
                if ($starCheckExist > 0) {
                echo "<span id='rate_star'><button class='follow_btn' onclick='starPage(\"$myId\",\"$row_id\")' style='width:100%;margin:0px 3px;border-color:#ffc107;padding:10px 15px;' title='".lang('unFavoritePage')."'><span class='fa fa-star' style='color:#FFC107;font-size:18px;'></span></button></span>";
                
                }else{
                echo "<span id='rate_star'><button class='follow_btn' onclick='starPage(\"$myId\",\"$row_id\")' style='width:100%;margin:0px 3px;padding:10px 15px;' title='".lang('addToFavoritePages')."'><span class='fa fa-star-o' style='color:#bbbbbb;font-size:18px;'></span></button></span>";
                }*/
                }
                ?>
				</div>	
							 <div class="profile_menu1">
			<?php
                $posts_num_sql = "SELECT post_id FROM wpost WHERE author_id=:row_id";
                $posts_num = $conn->prepare($posts_num_sql);
                $posts_num->bindParam(':row_id',$row_id,PDO::PARAM_INT);
                $posts_num->execute();
                $posts_num_int = $posts_num->rowCount();
                //=====================================================================
                $stars_num_sql = "SELECT id FROM likes WHERE liker=:row_id ";
                $stars_num = $conn->prepare($stars_num_sql);
                $stars_num->bindParam(':row_id',$row_id,PDO::PARAM_INT);
                $stars_num->execute();
                $stars_num_int = $stars_num->rowCount();
                //=====================================================================
                $followers_sql = "SELECT id FROM follow WHERE uf_two=:row_id";
                $followers = $conn->prepare($followers_sql);
                $followers->bindParam(':row_id',$row_id,PDO::PARAM_INT);
                $followers->execute();
                $followers_num = $followers->rowCount();
                //=====================================================================
                $following_sql = "SELECT id FROM follow WHERE uf_one=:row_id";
                $following = $conn->prepare($following_sql);
                $following->bindParam(':row_id',$row_id,PDO::PARAM_INT);
                $following->execute();
                $following_num = $following->rowCount();
                ?>
             <div class="container center" style="max-width: 480px; padding-top:10px;" >
			  <div class="row">
				<div class="col-4">
				<center><?php echo thousandsCurrencyFormat($posts_num_int); ?></center> 
			  <center> <p style="text-size:100px;">posts</p></center> 
				</div>
				<div class="col-4">
				<div onclick="myFunction()">
			   <center><?php echo thousandsCurrencyFormat($followers_num); ?></center>
			   <center>Followers</center></div>
				</div>
				<div class="col-4">
				<div onclick="following()">
			   <center> <?php echo thousandsCurrencyFormat($following_num); ?> </center> 
				 <center>Following<center> </div>
				</div>
			  </div>
			</div>
        </div>
		
				 <div class="user_info">
		<?php
            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/';
            $website_row = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $row_website);
            ?>
          
		<!--	<p>Nothing to show About Rohit</p>-->
			<table>
	
			<?php
            if(empty($row_school) && empty($row_work0) && empty($row_work) && empty($row_country) && empty($row_birthday) && empty($row_website)){}
            if (!empty($row_school)){echo "<tr><td class='user_info_tdi'><i class=\"fa fa-graduation-cap\"></i></td><td>"._STUDIES."$row_school<td></tr>";}
            if (!empty($row_work0) || !empty($row_work)){echo "<tr><td class='user_info_tdi'><i class=\"fa fa-briefcase\"></i></td><td>"._WORKING."$row_work0 "._AT." $row_work<td></tr>";}
            if (!empty($row_country)){echo "<tr><td class='user_info_tdi'><i class=\"fa fa-map-marker\"></i></td><td>"._LIVES_IN." $row_country<td></tr>";}
            if (!empty($row_birthday)){echo "<tr><td class='user_info_tdi'><i class=\"fa fa-calendar\"></i></td><td>"._BORN_0N." $row_birthday<td></tr>";}
            if (!empty($website_row)){echo "<tr><td class='user_info_tdi'><i class=\"fa fa-globe\"></i></td><td>$website_row<td></tr>";}
            ?>
           </table>
     
        </div>
          <div class="user_info">
                      
       <!--    <p>Nothing to show Bio</p>-->
            <?php
            if (!empty($row_bio)){echo "
                <p>$row_bio</p>
            ";}else{
            }
            ?>	
        </div>
	 
	</div>
	
            <div class="profile-content">
			    <div data-addui='tabs'>
    <div role='tabs'>
      <div>Posts</div>
	  <div>Images</div>
	  <div>Videos</div>
	  <div>Audio</div>
    </div>
	
    <div role='contents'>
      <div>
	  <div id="posts_section">
<?php echo $err_success_Msg; ?>
<!--========================================================================-->
             
				 <div id="FetchingPostsDiv">
	 <?php	  include("../includes/fetch_posts_profile.php"); ?>
	 <?php
if ($posts_num_int < 1) {
if ($_SESSION['id'] == $row_id) {
echo "
<div class='post'>
<p style='color: gray;text-align: center;padding: 15px;margin: 0px;'>"._YOU_HAVE_NOT_POSTING_ANYTHING.".</p>
</div>
";
 }else{
echo "
<div class='post'>
<p style='color: gray;text-align: center;padding: 15px;margin: 0px;'>$row_fullname "._HAS_NOT_POSTED_ANYTHING.".</p>
</div>
";
 } 
}
?>
                </div>
        </div>
	  </div>
     <div>
			
            <?php
            $u_id = $row_id;
            $emptyImg = '';  
            $getphotos_sql = "SELECT * FROM wpimage WHERE author_id = :u_id  ORDER BY post_time DESC";
            $getphotos = $conn->prepare($getphotos_sql);
            $getphotos->bindParam(':u_id',$u_id,PDO::PARAM_INT);
            $getphotos->execute();
            $getphotosCount = $getphotos->rowCount();
            ?>
            
            <?php
            if ($getphotosCount < 1) {
               if ($_SESSION['id'] == $row_id) {
				echo "
				<div class='post'>
				<p style='color: gray;text-align: center;padding: 15px;margin: 0px;'>"._YOU_HAVE_NOT_POSTING_ANYTHING_IMAGE.".</p>
				</div>
				";
				 }else{
				echo "
				<div class='post'>
				<p style='color: gray;text-align: center;padding: 15px;margin: 0px;'>$row_fullname "._HAS_NOT_POSTED_ANYTHING_IMAGE.".</p>
				</div>
				";
				 } 
            }
            while ($fetchMyPhotos = $getphotos->fetch(PDO::FETCH_ASSOC)) {
				$fetch_id = $fetchMyPhotos['id'];
                $fetch_post_id = $fetchMyPhotos['post_id'];
                $fetch_author_id = $fetchMyPhotos['author_id'];
                $fetch_post_img = $fetchMyPhotos['p_img'];
                $fetch_post_time = $fetchMyPhotos['post_time'];
                $timeago = time_ago($fetch_post_time);
                
                $quesql = "SELECT * FROM signup WHERE id=:fetch_author_id";
                $query = $conn->prepare($quesql);
                $query->bindParam(':fetch_author_id', $fetch_author_id, PDO::PARAM_INT);
                $query->execute();
                while ($author_fetch = $query->fetch(PDO::FETCH_ASSOC)) {
                    $author_fetch_id = $author_fetch['id'];
                    $author_fetch_username = $author_fetch['Username'];
                    $author_fetch_fullname = $author_fetch['Fullname'];
                    $author_fetch_userphoto = $author_fetch['Userphoto'];
                    $author_fetch_verify = $author_fetch['verify'];
                }
            ?>
            <div class="userPhotosProfile">
           <a href='../posts/post?pid=<?php echo $fetch_post_id ?>' ><img  id="lightboxImg.<?php echo $fetch_post_id ?>" src="../<?php echo $fetch_post_img; ?>" />	</a>			
            </div>
			 <?php
            }   
            ?>
	 </div>
	 
	 
	  <div>
	    <?php
            $u_id = $row_id;
            $getphotos_sql = "SELECT * FROM wpvideo WHERE author_id=:u_id  ORDER BY post_time_ DESC";
            $getphotos = $conn->prepare($getphotos_sql);
            $getphotos->bindParam(':u_id',$u_id,PDO::PARAM_INT);
            $getphotos->execute();
            $getphotosCount = $getphotos->rowCount();
            ?>
            <?php
            if ($getphotosCount < 1) {
               if ($_SESSION['id'] == $row_id) {
				echo "
				<div class='post'>
				<p style='color: gray;text-align: center;padding: 10px; width:100%;'>"._YOU_HAVE_NOT_POSTING_ANYTHING_VIDEO.".</p>
				</div>
				";
				 }else{
				echo "
				<div class='post'>
				<p style='color: gray;text-align: center;padding: 10px;margin: 0px;'>$row_fullname "._HAS_NOT_POSTED_ANYTHING_VIDEO.".</p>
				</div>
				";
				 } 
            }
            while ($fetchMyPhotos = $getphotos->fetch(PDO::FETCH_ASSOC)) {
                $fetch_post_id = $fetchMyPhotos['post_id'];
                $fetch_author_id = $fetchMyPhotos['author_id'];
                $fetch_post_author_photo = $fetchMyPhotos['post_author_photo'];
                $fetch_post_vid = $fetchMyPhotos['p_video'];
                $fetch_post_time = $fetchMyPhotos['post_time'];
                $timeago = time_ago($fetch_post_time);
                $fetch_post_status = $fetchMyPhotos['p_status'];
                
                $quesql = "SELECT * FROM signup WHERE id=:fetch_author_id";
                $query = $conn->prepare($quesql);
                $query->bindParam(':fetch_author_id', $fetch_author_id, PDO::PARAM_INT);
                $query->execute();
                while ($author_fetch = $query->fetch(PDO::FETCH_ASSOC)) {
                    $author_fetch_id = $author_fetch['id'];
                    $author_fetch_username = $author_fetch['Username'];
                    $author_fetch_fullname = $author_fetch['Fullname'];
                    $author_fetch_userphoto = $author_fetch['Userphoto'];
                    $author_fetch_verify = $author_fetch['verify'];
                }
            ?>
            <div class="userVideosProfile">
            <a href='../posts/post?pid=<?php echo $fetch_post_id ?>' ><video  src="../<?php echo $fetch_post_vid; ?>"/>
			</a>
            </div>
			<?php
            }   
            ?>
       </div>
	   <div>
	    <?php
            $u_id = $row_id;
            $emptyVid = '';
            $getaudios_sql = "SELECT * FROM wpost WHERE author_id=:u_id AND post_audio != :emptyVid ORDER BY post_time DESC";
            $getaudios = $conn->prepare($getaudios_sql);
            $getaudios->bindParam(':u_id',$u_id,PDO::PARAM_INT);
            $getaudios->bindParam(':emptyVid',$emptyVid,PDO::PARAM_STR);
            $getaudios->execute();
            $getaudiosCount = $getaudios->rowCount();
            ?>
            <?php
            if ($getaudiosCount < 1) {
               if ($_SESSION['id'] == $row_id) {
				echo "
				<div class='post'>
				<p style='color: gray;text-align: center;padding: 10px; width:100%;'>"._YOU_HAVE_NOT_POSTING_ANYTHING_AUDIO.".</p>
				</div>
				";
				 }else{
				echo "
				<div class='post'>
				<p style='color: gray;text-align: center;padding: 10px;margin: 0px;'>$row_fullname "._HAS_NOT_POSTED_ANYTHING_AUDIO.".</p>
				</div>
				";
				 } 
            }
            while ($fetchMyAudios = $getaudios->fetch(PDO::FETCH_ASSOC)) {
                $fetch_post_id = $fetchMyAudios['post_id'];
                $fetch_author_id = $fetchMyAudios['author_id'];
                $fetch_post_author = $fetchMyAudios['post_author'];
                $fetch_post_author_photo = $fetchMyAudios['post_author_photo'];
                $fetch_post_audio = $fetchMyAudios['post_audio'];
                $fetch_post_time = $fetchMyAudios['post_time'];
                $fetch_post_content = $fetchMyAudios['post_content'];
                $timeago = time_ago($fetch_post_time);
                $fetch_post_status = $fetchMyAudios['p_status'];
                
                $quesql = "SELECT * FROM signup WHERE id=:fetch_author_id";
                $query = $conn->prepare($quesql);
                $query->bindParam(':fetch_author_id', $fetch_author_id, PDO::PARAM_INT);
                $query->execute();
                while ($author_fetch = $query->fetch(PDO::FETCH_ASSOC)) {
                    $author_fetch_id = $author_fetch['id'];
                    $author_fetch_username = $author_fetch['Username'];
                    $author_fetch_fullname = $author_fetch['Fullname'];
                    $author_fetch_userphoto = $author_fetch['Userphoto'];
                    $author_fetch_verify = $author_fetch['verify'];
                }
            ?>
            <div class="userAudiosProfile">
                <audio src="../imgs/<?php echo $fetch_post_audio;  ?>" controls/>
            </div>
			<?php
            }   
            ?>
	   
        </div>
	  
    </div>
  
            </div>
			
			</div>
			
</div>
</div>
<br>
<br>
<?php
}else{
?>
<style type="text/css">
body{
background: #fff;
}
.error_page_btn{
background: whitesmoke;
padding: 8px;
border-radius: 3px;
color: #6b6b6b;
text-decoration: none;
box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.05);
transition: background 0.1s , color 0.1s;
}
.error_page_btn:hover, .error_page_btn:focus{
background: #4a708e;
color: #fff;
text-decoration: none;
}
.error_div{
padding: 15px;
max-width: 800px;
color: #383838;
box-shadow: none;
border: 1px solid rgba(217, 217, 217, 0.36);
}
</style>
<div align="center" style="margin-top: 150px;margin-bottom: 150px;">
<div class="post error_div" align="center">
<h1 style="font-weight: bold;"><img src="../imgs/main_icons/1f915.png" style="width:80px;height:80px;" /> <?php echo _SORRY_THIS_PAGE_NOT_AVAILABLE; ?></h1>
<h3><?php echo _PROFILE_PAGE_NOT_FOUND ; ?></h3><br>
<a href="javascript:history.back()" class="error_page_btn"><?php echo _GO_BACK_PREVIOUS_PAGE; ?></a>
</div></div>
<?php
}
?>
<script>
function profilePhoto(imgUrl) {
    if (imgUrl.files && imgUrl.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profilePhotoPreview').attr('src', e.target.result);
            $('#submitProfilePhoto').css({"display":"inline-block"});
        }

        reader.readAsDataURL(imgUrl.files[0]);
    }
}
// ////////// lightboxImg /////////
function lightbox(pid){
	alert(pid);
}
function lightboxClose(){
    var modal = document.getElementById('lightboxImg_myModal');
    modal.style.display = "none";
    $('body').css({'overflow':'auto'});
}
///////////////////////////////////

</script>
<script>
/*var preloader= document.getElementById('loading');
function myFunction(){
	preloader.style.display='none';
}*/
</script>
	<script>
        document.addEventListener('DOMContentLoaded', function () {
    
          var elems = document.querySelectorAll('.sidenav');
          var instances = M.Sidenav.init(elems);
        });
      </script>
	<script>
 function followUnfollow(id){
    $.ajax({
        type:'POST',
        url:"<?php echo $checkDir; ?>../includes/f_action.php",
        data:{'id':id},
        beforeSend:function(){
             $('#followUnfollow_'+id).html("<button class=\"unfollow_btn\"><span class=\"fa fa-check\"></span> Following</button>");
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