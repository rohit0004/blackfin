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
$un = filter_var(htmlspecialchars($_GET['u']),FILTER_SANITIZE_STRING);
$uisql = "SELECT * FROM groups WHERE g_name=:un";
$que = $conn->prepare($uisql);
$que->bindParam(':un', $un, PDO::PARAM_STR);
$que->execute();
while($row = $que->fetch(PDO::FETCH_ASSOC)){
	$row_g_id = $row['id'];
    $row_id = $row['admin_id'];
    $row_g_name = $row['g_name'];
    $row_g_discription = $row['g_discription'];
	$row_g_privacy=$row['g_privacy'];
    $row_g_image = $row['g_image'];
}
$adminsql = "SELECT * FROM signup WHERE id=:row_id";
$que = $conn->prepare($adminsql);
$que->bindParam(':row_id', $row_id, PDO::PARAM_INT);
$que->execute();
while($row = $que->fetch(PDO::FETCH_ASSOC)){
    $row_admin_fullname = $row['Fullname'];
    $row_admin_name = $row['Username'];
}
$membersql="SELECT * FROM gmember WHERE um_two=:row_g_id";
$member=$conn->prepare($membersql);
$member->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
$member->execute();
while($row = $member->fetch(PDO::FETCH_ASSOC)){
	$row_member=$row['um_one'];
}
/////////////////
    $checkview_sql = "SELECT * FROM gviews WHERE viewer=:myId AND group_id=:row_g_id";
    $checkview = $conn->prepare($checkview_sql);
    $checkview->bindParam(':myId',$myId,PDO::PARAM_INT);
    $checkview->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
    $checkview->execute();
    $checknum = $checkview->rowCount();
    if ($checknum > 0) {
		
    }
	else{
    $view_sql = "INSERT INTO gviews (viewer,group_id) VALUES (:myId, :row_g_id)";
    $view = $conn->prepare($view_sql);
    $view->bindParam(':myId',$myId,PDO::PARAM_INT);
    $view->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT); 
    $view->execute();
        // update likes number
        $makeChangeSql = "UPDATE groups SET views=:views_num WHERE id=:row_g_id";
        $makeChange = $conn->prepare($makeChangeSql);
        $makeChange->bindParam(':views_num',$views_num,PDO::PARAM_INT);
        $makeChange->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
        $makeChange->execute();
        }
		//////////////////
?>
<html>
<head>
    <title> |  webapp</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="social network,social media,This webapp,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
    <link rel='stylesheet' href='../addTabs.css' />
	<script src='../AddTabs.js'></script>
	<link rel='stylesheet' href='../css/style.css'/>
	<script src='../jquery.maxlength.js'></script>	
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
.modal.bottom-sheet{
	max-height:60%;
	background:white;
	border-top-left-radius: 20px; 
    border-top-right-radius: 20px;
	padding-top:10px;
	overflow: auto;
}
.container .galleryItem img {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.container.galleryItem{
    color: #797478;
    font: 10px/1.5 Verdana, Helvetica, sans-serif;
    float: left;    
    width:50%;
	height:200px;	
}
@media only screen and (max-width : 720px),
only screen and (max-device-width : 720px){
    .container.galleryItem {height:150px;}
}
	</style>
	<script>
	function joinAndmembers(id){
	var requ = "profileMember";	
	$.ajax({
        type:'POST',
        url:"<?php echo $checkDir; ?>../includes/g_member.php",
        data:{req:'requ','id':id},
        beforeSend:function(){
             $('#followUnfollow_'+id).html("<button class=\"unfollow_btn\"><span class=\"fa fa-check\"></span>	Member</button>");
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
</head>
<body style="background:white;">
<div></div>
<?php
if (filter_var(htmlspecialchars($_GET['u']),FILTER_SANITIZE_STRING) == $row_g_name) {
?>
<!---->

  <!---->
<div class="container-fluid">
 <!-- <span style="font-size:30px;cursor:pointer; background:white;position:fixed;width:100%;margin-top:0px; padding:10px;box-shadow: 0px 0px 18px rgba(63, 81, 181, 0.16);" onclick="openNav()">&#9776; SocialSite</span>-->
 <div style="margin:0px auto; max-width:600px; ">
			<div class="profile-sidebar">
			
				<div  class="pic" style="text-align:center;">
				<div class="profile-userpic profile_ppicture" style="text-align:center;">
         <img class=" img-fluid z-depth-1 " alt="100x100" src="<?php echo '../imgs/user_imgs/'.$row_g_image; ?>"
          style="display:block; margin: auto auto;width:100%;height:200px;">
		  
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
					<h6 style="margin-top:10px; margin-bottom:5px;"><?php echo $row_g_name;?></h6>
					<p style="margin-top:20px; margin-bottom:5px;"> Create :<?php echo "<a href=\"".$check_path."u/$row_admin_name\">$row_admin_fullname</a> ";?> </p>
					</div>
				<?php 
				if($row_g_privacy == 0){
					echo "This is a public group.";
			
				}
				else{
					echo "This is a private group.";
				}
					?>
				</div>
				<?php
               if($row_id == $_SESSION['id']){
                    echo "<span style='cursor:pointer;width:100%;display:inline-flex; margin-top:10px;'><a href='../settings?tc=edit_profile' class=\"silver_flat_btn\" style='width:100%;'><span class=\"fa fa-cog\"></span> "._EDIT_PROFILE."</a></span>";
                }
                ?>
				 <?php
               if($row_id != $_SESSION['id']){
                $msql = "SELECT id FROM gmember WHERE um_one=:myId AND um_two=:row_g_id";
                $m = $conn->prepare($msql);
                $m->bindParam(':myId',$myId,PDO::PARAM_INT);
                $m->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
                $m->execute();
                $m_num = $m->rowCount();
                if ($m_num > 0){
                    echo "<span id='followUnfollow_$row_g_id' style='cursor:pointer;display:inline-flex; width:30%; margin-top:5px;'><button class=\"unfollow_btn\" onclick=\"joinAndmembers('$row_g_id')\"><span class=\"fa fa-check\"></span>.Member.</button></span>";
                }else{
                    echo "<span id='followUnfollow_$row_g_id' style='cursor:pointer;width:30%;display:inline-flex; margin-top:5px;'><button class=\"follow_btn\" onclick=\"joinAndmembers('$row_g_id')\"><span class=\"fa fa-plus-circle\"></span>.Addmember.</button></span>";
                }
			   }
                ?>
				</div>	
							 <div class="profile_menu1">
			<?php
                $posts_num_sql = "SELECT post_id FROM wgpost WHERE group_id=:row_g_id";
                $posts_num = $conn->prepare($posts_num_sql);
                $posts_num->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
                $posts_num->execute();
                $posts_num_int = $posts_num->rowCount();
                //=====================================================================
                $stars_num_sql = "SELECT id FROM likes WHERE liker=:row_id ";
                $stars_num = $conn->prepare($stars_num_sql);
                $stars_num->bindParam(':row_id',$row_id,PDO::PARAM_INT);
                $stars_num->execute();
                $stars_num_int = $stars_num->rowCount();
                //=====================================================================
                $followers_sql = "SELECT id FROM gmember WHERE um_two=:row_g_id";
                $followers = $conn->prepare($followers_sql);
                $followers->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
                $followers->execute();
                $followers_num = $followers->rowCount();
				 //=====================================================================
				$views_sql = "SELECT id FROM gviews WHERE group_id=:row_g_id";
				$views = $conn->prepare($views_sql);
				$views->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
				$views->execute();
				$views_num = $views->rowCount();
                ?>
             <div class="container center" style="max-width: 480px; padding-top:10px;" >
			  <div class="row">
				<div class="col-4">
				<center><?php echo thousandsCurrencyFormat($posts_num_int); ?></center> 
			  <center> <p style="text-size:100px;">posts</p></center> 
				</div>
				<div class="col-4">
			   <center><a  class="modal-trigger" href="javascript:void(0)"  id='followers_btn'><?php echo thousandsCurrencyFormat($followers_num); ?></center>
			   <center>Members</center></a>
				</div>
				<div class="col-4">
			   <center><a  href="javascript:void(0)" ><?php echo thousandsCurrencyFormat($views_num); ?></center>
			   <center>Views</center></a>
				</div>
				
			  </div>
			</div>
			
        </div>
		
			<div style="padding-bottom:20px;">
			<?php
			echo "<div class=\"text-align:center;\">
			$row_g_discription;
			</div>
			"
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
<?php if($row_g_privacy == 0 && $_SESSION['id'] == $row_member ){
					include("../includes/group_post_form.php");
				}
				else{
					if($_SESSION['id'] == $row_id){
					include("../includes/group_post_form.php");
					
					}
				}
				?>
<!--========================================================================-->
             
				 <div id="FetchingPostsDiv">
	 <?php	  include("../includes/fetch_group_post.php"); ?>
	 
                </div>
        </div>
	  </div>
     <div>
			
             <?php
            $emptyImg = '';  
            $getphotos_sql = "SELECT * FROM wgpimge WHERE group_id=:row_g_id ORDER BY post_time DESC";
            $getphotos = $conn->prepare($getphotos_sql);
            $getphotos->bindParam(':row_g_id',$row_g_id,PDO::PARAM_INT);
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
            $u_id = $row_g_id;
            $emptyVid = '';
            $getphotos_sql = "SELECT * FROM wgpvideo WHERE group_id=:u_id AND post_vid != :emptyVid ORDER BY post_time DESC";
            $getphotos = $conn->prepare($getphotos_sql);
            $getphotos->bindParam(':u_id',$u_id,PDO::PARAM_INT);
            $getphotos->bindParam(':emptyVid',$emptyVid,PDO::PARAM_STR);
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
				<p style='color: gray;text-align: center;padding: 10px;margin: 0px;'>Admin "._HAS_NOT_POSTED_ANYTHING_VIDEO.".</p>
				</div>
				";
				 } 
            }
            while ($fetchMyPhotos = $getphotos->fetch(PDO::FETCH_ASSOC)) {
                $fetch_post_id = $fetchMyPhotos['post_id'];
                $fetch_author_id = $fetchMyPhotos['author_id'];
                $fetch_post_vid = $fetchMyPhotos['post_vid'];
                $fetch_post_time = $fetchMyPhotos['post_time'];
                $fetch_post_content = $fetchMyPhotos['post_content'];
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
            <div class="userVideosProfile">
                <video  src="../imgs/<?php echo $fetch_post_vid; ?>" controls/>
            </div>
			<?php
            }   
            ?>
       </div>
	   <div>
	    <?php
            $u_id = $row_id;
            $emptyVid = '';
            $getaudios_sql = "SELECT * FROM wgpost WHERE group_id=:u_id AND post_audio != :emptyVid ORDER BY post_time DESC";
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
                $fetch_post_audio = $fetchMyAudios['post_audio'];
                $fetch_post_time = $fetchMyAudios['post_time'];
                $fetch_post_content = $fetchMyAudios['post_content'];
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
<h1 style="font-weight: bold;"><img src="../imgs/main_icons/1f915.png" style="width: 80px;height: 80px;" /> <?php echo _SORRY_THIS_PAGE_NOT_AVAILABLE; ?></h1>
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
   var modal = document.getElementById('lightboxImg_myModal');
    var modalImg = document.getElementById("lightboxImg_photo");
    var img = document.getElementById('lightboxImg_'+pid);
    modal.style.display = "block";
    modalImg.src = img.src;
    $('body').css({'overflow':'hidden'});
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
</body>
</html>