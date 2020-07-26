<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$myId = $_SESSION['id'];
include("config/connect.php");
include ("includes/time_function.php");
include ("includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: index");
}
$uisql = "SELECT * FROM signup WHERE id=:myId";
$que = $conn->prepare($uisql);
$que->bindParam(':myId', $myId, PDO::PARAM_STR);
$que->execute();
while($row = $que->fetch(PDO::FETCH_ASSOC)){
    $row_id = $row['id'];
    $row_fullname = $row['Fullname'];
    $row_username = $row['Username'];
    $row_email = $row['Email'];
    $row_password = $row['Password'];
    $row_user_photo = $row['Userphoto'];
    $row_user_cover_photo = $row['user_cover_photo'];
    $row_school = $row['school'];
    $row_work = $row['work'];
    $row_work0 = $row['work0'];
    $row_country = $row['country'];
    $row_birthday = $row['birthday'];
    $row_verify = $row['verify'];
    $row_website = $row['website'];
    $row_bio = $row['bio'];
    $row_admin = $row['admin'];
    $row_gender = $row['gender'];
    $row_profile_pic_border = $row['profile_pic_border'];
    $row_language = $row['language'];
    $row_online = $row['online'];
}
?>
<html>
<head>
    <title>Home | Wallstant</title>
    <meta charset="UTF-8">
    <meta name="description" content="This webapp is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,Wallstant,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/head_imports_main.php";?>
	<style>
	html, body {
   max-width: 100%;
    overflow-x: hidden;
}
.custom_display {
  display: none; 
  position: fixed; 
  z-index: 1; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%;
  height: 100%; 
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}

/* Modal Content */
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
			
	</style>
</head>
<body>
       <nav>
            <div class="nav-wrapper">
              <a href="#!" class="brand-logo center">Logo</a>
            </div> 
		</nav> 
	<div style="margin:0px auto; max-width:600px;">
	<ul>
	<div class="homeLinks" style="text-align:left;" id="postchange">
    <li id="myBtn"><a href="#!"><p class="homelinksP_borderL postIcon" id="homelinksP_borderL">Full name <lable style="float:right;"><?php echo $row_fullname ?></lable></p></a></li>
    <li id="postBtn"><a href="#!"><p class="homelinksP_borderL postIcon" id="username">Username<lable style="float:right;"><?php echo $row_username ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Email Address<lable style="float:right;"><?php echo $row_email ?></lable></p></a></li>	
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Birthday <lable style="float:right;"><?php echo $row_birthday ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Education <lable style="float:right;"><?php echo $row_school ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Bio <lable style="float:right;"><?php echo $row_bio ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Website <lable style="float:right;"><?php echo $row_website ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Country<lable style="float:right;"><?php echo $row_country ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Work<lable style="float:right;"><?php echo $row_work0 ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon"> language<lable style="float:right;"><?php echo $row_language ?></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon">password <lable style="float:right;"></lable></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon"> privacy policy<i   style="float:right;"></i></p></a></li>
	<li><a href="#!"><p class="homelinksP_borderL postIcon"> term and condition<i style="float:right;"></i></p></a></li>
	</div>
 </ul>	
		</div>
<div   style="text-align:center;bottom:0; background:red;">Made with love in india</div>
<div id="usermodal"></div>
	<!--<div id="myModal" class="custom_display">
  <div class="modal-content">
    <span class="close">&times;</span>
	<div style="text-align:center;">
   <p for="postcolor">Select custom background color:</p>
   <input type="color" id="backgroundcolor" name="postcolor"  onchange="myFunction()">
   </div>
  </div>
</div> 
		<div id="myPost" class="custom_display">
  <div class="modal-content">
    <span class="closePost">&times;</span>
	<div style="text-align:center;">
   <p for="postcolor">Select custom background color:</p>
   <input type="color" id="postcolor" name="postcolor"  onchange="myPostColor()">
   </div>
  </div>
</div>-->
 <script>
// Get the modal
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0]; 
/*btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}*/
$("#username").on('click',function(){
	alert("hello");
	var requ = "username";
				$.ajax({
				type:'POST',
				url:"home_request.php",
				data:{'req':requ},
				error: function(data) {
				alert("There was an error. Try again please!");
				},
				success:function(data){
					alert(data);
					 document.getElementById("myModal").show();
					  $('#usermodal').html(data);
				}
					});
	})
</script> 
</body>
</html>
