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
?>
<html>
<head>
    <title>Home | This webapp</title>
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
	<!--	<div style="margin:0px auto; max-width:600px;">
	<ul>
	<div class="homeLinks" style="text-align:left;" id="postchange">
    <li id="myBtn"><a href="#!"><p class="homelinksP_borderL postIcon" id="homelinksP_borderL"> <?php echo _SETTING; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a></li>
	
    <li id="postBtn"><a href="#!"><p class="homelinksP_borderL postIcon"><?php echo _LANGUAGE; ?><i class="madium material-icons" style="float:right;">chevron_right</i></p></a></li>
	
	<li><a href="#!"><p class="homelinksP_borderL postIcon">Groups <i class="madium material-icons" style="float:right;">chevron_right</i></p></a></li>
	
	<li><a href="#!"><p class="homelinksP_borderL postIcon"><?php echo _SAVE_POSTS; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a></li>
	
	<li><a href="#!"><p class="homelinksP_borderL postIcon"><?php echo _SUPPORT_BOX; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a></li>
	
	<li><a href="#!"><p class="homelinksP_borderL postIcon"><?php echo _REPORT_A_PROBLEM; ?> <i class="madium material-icons" style="float:right;">chevron_right</i></p></a></li>
	</div>
 </ul>	
		</div>-->
		<ul class="collapsible popout">
    <li class="active">
      <div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
      <div class="collapsible-body">
	    <div class="switch">
	<span style=" color: rgba(0, 0, 0, 0.7);">Set default  background color:</span>
    <label style="float:right;">
	<input type="checkbox" chacked onchange="defaultbg()">
      <span class="lever"></span> 
    </label>
  </div>
  <hr>
	  <p for="postcolor"  style=" color: rgba(0, 0, 0, 0.7);">Select custom background color:</p>
   <input type="color" id="backgroundcolor" name="postcolor"  onchange="myFunction()"></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">place</i>Second</div>
      <div class="collapsible-body"><p for="textcolor">Select custom background color:</p>
   <input type="color" id="textcolor" name="textcolor"  onchange="myTextColor()"></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
      <div class="collapsible-body"> <p for="postcolor">Select custom background color:</p>
   <input type="color" id="postcolor" name="postcolor"  onchange="myPostColor()"></div>
    </li>
  </ul>
	<!--	<div id="myModal" class="custom_display">
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
</div> -->
 <script>
$(document).ready(function(){
	$('.collapsible').collapsible();
            $(".homelinksP_borderL").css("color", "red");
});
 function myFunction(){
	var x =      document.getElementById("backgroundcolor").value;  
	document.body.style.background = x; 
	 localStorage.setItem('homebackground', x);
 }
 function myTextColor(){   
    var textC= $("#textcolor").val(); 
	$(".homelinksP_borderL").css("color", textC);
	 localStorage.setItem('textbg', textC);
 }
 function myPostColor(){   
    var postC= $("#postcolor").val(); 
	$(".homelinksP_borderL").css("color", postC);
	 localStorage.setItem('postbackground', postC);
 }
 function defaultbg(){
	localStorage.removeItem("homebackground");
 }
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
document.getElementById("postBtn").onclick = function() {
  document.getElementById("myPost").style.display = "block";
};
var span = document.getElementsByClassName("closePost")[0]; 
span.onclick = function() {
 document.getElementById("myPost").style.display = "none";
}

</script> 
</body>
</html>
