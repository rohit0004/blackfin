<?php
session_start();

// Set Language variable
if(isset($_GET['lang']) && !empty($_GET['lang'])){
 $_SESSION['lang'] = $_GET['lang'];

 if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
  echo "<script type='text/javascript'> location.reload(); </script>";
 }
}

// Include Language file
if(isset($_SESSION['lang'])){
 include "langu/lang_".$_SESSION['lang'].".php";
}else{
 include "langu/lang_english.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?= _CREATE_N_ACCOUNT ?>  | Socilsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="Socilsite is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="signup,social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/signup.css">
	 <?php include "includes/head_imports_main.php";?>
<body>
<script>
 function changeLang(){
  document.getElementById('form_lang').submit();
 }
 </script>
<div class="container">
<div class="login_signup_navbar">
                <a href="index" class="login_signup_navbarLinks">Socilsite</a>
                <div style="float: right;">
			
                   <a href="index.php" class="login_signup_btn1"><?= _LOGIN ?></a>
                   
                </div>
        </div>
		<div style="margin-top:40px; margin-left:20px;">
	<form method='get' action='' id='form_lang' >
  <?= _SELECT_LANGUAGE ?>: <select name='lang' onchange='changeLang();' >
   <option value='english' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'english'){ echo "selected"; } ?> >English</option>
   <option value='hindi' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'hindi'){ echo "selected"; } ?> >Hindi</option>
  </select>
 </form>
	</div>
    <div class="card card-login mx-auto text-center">
        <div style="color:#757575;font-weight: bold;margin: 0;margin-bottom: 0px;margin-bottom: 10px;font-size: 16px;">
             <h4 align="center"> <?= _CREATE_N_ACCOUNT ?></h4>
        </div>
        <div class="card-body">
           
                <div class="input-group form-group">
                    <input type="text" name="signup_fullname" class="login_signup_textfield"  class="form-control" id="fn" placeholder="<?= _FULLNAME ?>">
                </div>
                <div class="input-group form-group">
                    <input type="text" name="signup_username"  class="login_signup_textfield"  class="form-control" id="un" placeholder="<?= _USERNAME ?>">
                </div>
				<div class="input-group form-group">
                    <input type="email" name="signup_email" class="login_signup_textfield"  class="form-control" id="em" placeholder="<?=  _EMAIL ?>">
                </div>
                <div class="input-group form-group">
                    <input type="password" name="signup_password" class="login_signup_textfield" class="form-control" id="pd" placeholder="<?= _PASSWORD ?>">
                </div>
				 <div class="input-group form-group">
                    <input type="password" name="signup_cpassword" class="login_signup_textfield" class="form-control" id="cpd" placeholder="<?= _CPASSWORD ?>">
                </div>
				  <div class="input-group form-group">
			<select class="login_signup_textfield" name="gender" id="gr">
             <option selected ><?= _MALE ?></option>
              <option><?= _FEMALE ?></option>
            </select>
			</div>
                <p style="font-size: 11px;color: #5d5d5d;margin: 8px 0px; ">
              <?=  _BY_CLICKING_SIGNUP_STR ?> <a href="terms"><?= _TERM ?></a>, <a href="privacy"> <?= _PRIVACY ?></a> <?= _AND ?><a href="cookie"><?= _COOKIE ?></a>.</p>
            <button type="submit" class="login_signup_btn2" id="signupFunCode"> <?= _CREATE_ACCOUNT ?></button>
            <p id="login_wait" style="margin: 0px;"></p>
 
           
        </div>
    </div>
	 <div style="background: #fff; max-width: 500px; padding: 15px; margin:auto;margin-top: 10px;color: #7b7b7b; border-radius: 1.1rem;" align="center">
          <?=  _ALREADY_HAVE_AN_ACCOUNT ?><a href="index.php"> <?= _LOGIN_NOW ?></a> 
        </div>
</div>
<script type="text/javascript">
function signupUser(){
        var fullname = $('#fn').val();
		var username=$('#un').val();
		var emailAdd = $('#em').val();
		var password = $('#pd').val();
		var cpassword = $('#cpd').val();
		var gender=$('#gr').val();
$.ajax({
type:'POST',
url:'includes/login_signup_codes.php',
data:{'req':'signup_code','fn':fullname,'un':username,'em':emailAdd,'pd':password,'cpd':cpassword,'gr':gender},
beforeSend:function(){
$('.login_signup_btn2').hide();
$('#login_wait').html("<b>Create a account</b>");
},
success:function(data){
$('#login_wait').html(data);
if (data == "Done..") {
    $('#login_wait').html("<p class='alertGreen'><?= _DONE  ?>..</p>");
    setTimeout(' window.location.href = "home"; ',2000);
}else{
    $('.login_signup_btn2').show();
}
},
error:function(err){
alert(err);
}
});
}
$('#signupFunCode').click(function(){
signupUser();
});

$(".login_signup_textfield").keypress( function (e) {
    if (e.keyCode == 13) {
        signupUser();
    }
});
</script>
</body>
</html>
