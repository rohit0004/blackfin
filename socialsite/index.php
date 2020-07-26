<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if(isset($_SESSION['Username'])){
    header("location: home");
}
// ========================= config the languages ================================
// Set Language variable
if(isset($_GET['lang']) && !empty($_GET['lang'])){
 $_SESSION['lang'] = $_GET['lang'];

 if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
  echo "<script type='text/javascript'> location.reload(); </script>";
 }
}
// Include Language file
error_reporting(E_NOTICE ^ E_ALL);
if (is_file('home.php')){
    $path = "";
}elseif (is_file('../home.php')){
    $path =  "../";
}elseif (is_file('../../home.php')){
    $path =  "../../";
}
if(isset($_SESSION['lang'])){
 include_once $path."langu/lang_".$_SESSION['lang'].".php";
}else{
 include_once $path."langu/lang_english.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?= _WELCOME ?> | Socialsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="Wallstant is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="homepage,main,login,social network,social media,Wallstant,meet,free platform">
    <meta name="author" content="Munaf Aqeel Mahdi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "includes/head_imports_main.php";?>
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
<script>
 function changeLang(){
  document.getElementById('form_lang').submit();
 } 
 </script>
<div class="container">
<div class="login_signup_navbar">
                <a href="index" class="login_signup_navbarLinks">Socialsite</a>
             <!-- <a href="#" class="login_signup_navbarLinks">Help</a>
                <a href="#" class="login_signup_navbarLinks">Terms</a>
                <a href="#" class="login_signup_navbarLinks">Privacy policy</a>-->
                <div style="float: right;">
			
                  <!--  <a href="login" class="login_signup_btn1">Login</a>-->
                    <a href="signup.php" class="login_signup_btn2"><?= _SIGNUP ?></a>
                </div>
        </div>
		<div style="margin-top:40px; margin-left:20px;">
		<form method='get' action='' id='form_lang' >
   <?= _SELECT_LANGUAGE; ?> : <select name='lang' onchange='changeLang();' >
   <option value='english' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'english'){ echo "selected"; } ?> >English</option>
   <option value='hindi' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'hindi'){ echo "selected"; } ?> >Hindi</option>
  </select>
 </form>
	</div>
    <div class="card card-login mx-auto text-center">
        <div>
            <span> <h3>Welcome to Users</h3> </span>
			<p>Meet new friends and stay connected with your family and with who you are interested anytime anywhere.</p>
			<br/>
              <span class="logo_title mt-5"> <b><?= _LOGIN_NOW?></b> </span>
        </div>
        <div class="card-body">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="email"  id="un" class=" form-control login_signup_textfield" class=""  placeholder="<?= _USERNAME ?> ">
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" id="pd" class="form-control login_signup_textfield" placeholder="<?= _PASSWORD ?> ">
                </div>
				<div  style="color: #a2a2a2; font-size:11px; float:right; margin-top:0px;">
       <a href="forgot.php"> <?= _FORGOT_A_PASSWORD ?></a>
	   </div>
                <div class="form-group">
                    <input type="submit" name="btn" value="<?= _LOGIN ?>" class="btn btn-outline-danger float-left login_btn login_signup_btn1" class="" id="loginFunCode">
                </div>
			
        </div>
		<p id="login_wait" style="margin: 0px;"></p>
    </div>
	
	 <div style="background: #fff; max-width: 500px; padding: 15px; margin:auto;margin-top: 10px;color: #7b7b7b; border-radius: 1.1rem;" align="center">
            <?= _DONT_HAVE_A_ACCOUNT ?> <a href="signup.php"> <?= _SIGNUP ?></a> 
              
        </div>
</div>
<script type="text/javascript">
function loginUser(){
var username = $('#un').val();
		var password=$('#pd').val();
$.ajax({
type:'POST',
url:'includes/login_signup_codes.php',
data:{'req':'login_code','un':username,'pd':password},
beforeSend:function(){
$('.login_signup_btn1').hide();
$('#login_wait').html("<?= _LOADING ?>...");
},
success:function(data){
$('#login_wait').html(data);
if (data == "Welcome...") {
    $('#login_wait').html("<p class='alertGreen'><?= _WELCOME ?>..</p>");
    setTimeout(' window.location.href = "home"; ',2000);
}else{
    $('.login_signup_btn1').show();
}
},
error:function(err){
alert(err);
}
});
}
$('#loginFunCode').click(function(){
loginUser();
});
$(".login_signup_textfield").keypress( function (e) {
    if (e.keyCode == 13) {
        loginUser();
    }
});
</script>
</body>
</html>
