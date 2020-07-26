<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/time_function.php");
include("includes/country_name_function.php");
if(!isset($_SESSION['Username'])){
    header("location: index.php");
}
$tc = filter_var(htmlentities($_GET['tc']),FILTER_SANITIZE_STRING);
// =============================[ prepare input variable's ]=================================
$session_un = $_SESSION['Username'];

$fullname_var = filter_var(htmlentities($_POST['edit_fullname']),FILTER_SANITIZE_STRING);
$username_var = filter_var(htmlentities($_POST['edit_username']),FILTER_SANITIZE_STRING);
$email_var = filter_var(htmlentities($_POST['edit_email']),FILTER_SANITIZE_STRING);
// =========================== password hashinng ==================================
$new_password_var_field = filter_var(htmlentities($_POST['new_pass']),FILTER_SANITIZE_STRING);
$options = array(
    'cost' => 12,
);
$new_password_var = password_hash($new_password_var_field, PASSWORD_BCRYPT, $options);
// ================================================================================
$rewrite_new_password_var = filter_var(htmlentities($_POST['rewrite_new_pass']),FILTER_SANITIZE_STRING);

// filter gender as prefered language
$gender_var = filter_var(htmlentities($_POST['gender']),FILTER_SANITIZE_STRING);
if ($gender_var == _MALE) {
   $gender_var = "Male";
}elseif ($gender_var == _FEMALE) {
    $gender_var = "Female";
}

$school_var = filter_var(htmlentities($_POST['edit_school']),FILTER_SANITIZE_STRING);
$work_var = filter_var(htmlentities($_POST['edit_work']),FILTER_SANITIZE_STRING);
$work0_var = filter_var(htmlentities($_POST['edit_work0']),FILTER_SANITIZE_STRING);
$country_var = filter_var(htmlentities($_POST['edit_country']),FILTER_SANITIZE_STRING);
$birthday_var = filter_var(htmlentities($_POST['bd_year']),FILTER_SANITIZE_NUMBER_INT)."/".filter_var(htmlentities($_POST['bd_month']),FILTER_SANITIZE_NUMBER_INT)."/".filter_var(htmlentities($_POST['bd_day']),FILTER_SANITIZE_NUMBER_INT);
$website_var = filter_var(htmlentities($_POST['edit_website']),FILTER_SANITIZE_STRING);
$bio_var = filter_var(htmlentities($_POST['edit_bio']),FILTER_SANITIZE_STRING);

$language_var = filter_var(htmlspecialchars($_POST['edit_language']),FILTER_SANITIZE_STRING);

$general_current_pass_var = filter_var(htmlentities($_POST['general_current_pass']),FILTER_SANITIZE_STRING);
$EditProfile_current_pass_var = filter_var(htmlentities($_POST['EditProfile_current_pass']),FILTER_SANITIZE_STRING);
$lang_current_pass_var = filter_var(htmlentities($_POST['lang_current_pass']),FILTER_SANITIZE_STRING);
$remeveA_current_pass_var = filter_var(htmlentities($_POST['removeA_current_pass']),FILTER_SANITIZE_STRING);

// =============================[ Save General settings ]=================================
if (isset($_POST['general_save_changes'])) {
if (!password_verify($general_current_pass_var,$_SESSION['Password'])) {
    $general_save_result = "<p class='alertRed'>"._CURRENT_PASSWORD_INCORRECT."</p>";
}else{
    if (empty($fullname_var) or empty($username_var) or empty($email_var)) {
        $general_save_result = "<p class='alertRed'>"._PLZ_FILL_REQURIED_FIELDS."</p>";
    } else {
         if (empty($new_password_var) AND empty($rewrite_new_password_var)) {
            $new_password_var = $_SESSION['Password'];
         }elseif ($new_password_var_field != $rewrite_new_password_var) {
            $general_save_result = "<p class='alertRed'>"._NEW_PASSWORD_NOT_MATCH."</p>";
            $stop = "1";
        }
        if(strpos($username_var, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $username_var) || !preg_match('/[A-Za-z0-9]+/', $username_var)) {
            $general_save_result =  "
            <ul class='alertRed' style='list-style:none;'>
                <li><b>"._ERROR_IN_USERNAME." :</b></li>
                <li><span class='fa fa-times'></span> "._SPECIAL_CHARACTERS_NOT_ALLOWD.".</li>
                <li><span class='fa fa-times'></span> "._USERNAME_SHOULD_IN_ENGLISH.".</li>
                <li><span class='fa fa-times'></span> "._ONLY_ALLOWED.".</li>
                <li><span class='fa fa-times'></span> "._NUMBER_LATTER_ALLOWED.".</li>
                <li><span class='fa fa-times'></span> "._WHITE_SPACE_NOT_ALLOWED.".</li>
            </ul>";
            $stop = "1";  
        }
        $unExist = $conn->prepare("SELECT Username FROM signup WHERE Username =:username_var");
        $unExist->bindParam(':username_var',$username_var,PDO::PARAM_STR);
        $unExist->execute();
        $unExistCount = $unExist->rowCount();
        if ($unExistCount > 0) {
           if ($username_var != $_SESSION['Username']) {
           $general_save_result = "<p class='alertRed'>"._USERNAME_EXIST."</p>";
           $stop = "1";
           }
        }
        $emExist = $conn->prepare("SELECT Email FROM signup WHERE Email =:email_var");
        $emExist->bindParam(':email_var',$email_var,PDO::PARAM_STR);
        $emExist->execute();
        $emExistCount = $emExist->rowCount();
        if ($emExistCount > 0) {
           if ($email_var != $_SESSION['Email']) {
           $general_save_result = "<p class='alertRed'>"._EMAIL_EXISTS."</p>";
           $stop = "1";
           }
        }
        if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
            $general_save_result = "<p class='alertRed'>"._INVALID_EMAIL."</p>";
            $stop = "1";
        }
         if ($stop != "1") {
         $update_info_sql = "UPDATE signup SET Fullname= :fullname_var,Username= :username_var,Email= :email_var,Password= :new_password_var,gender= :gender_var WHERE username= :session_un";
         $update_info = $conn->prepare($update_info_sql);
         $update_info->bindParam(':fullname_var',$fullname_var,PDO::PARAM_STR);
         $update_info->bindParam(':username_var',$username_var,PDO::PARAM_STR);
         $update_info->bindParam(':email_var',$email_var,PDO::PARAM_STR);
         $update_info->bindParam(':new_password_var',$new_password_var,PDO::PARAM_STR);
         $update_info->bindParam(':gender_var',$gender_var,PDO::PARAM_STR);
         $update_info->bindParam(':session_un',$session_un,PDO::PARAM_STR);
         $update_info->execute();
        if (isset($update_info)) {
            $_SESSION['Fullname'] = $fullname_var;
            $_SESSION['Username'] = $username_var;
            $_SESSION['Email'] = $email_var;
            $_SESSION['Password'] = $new_password_var;
            $_SESSION['gender'] = $gender_var;
            $general_save_result = "<p class='alertGreen'>"._CHANGE_PASSWORD_SAVE."</p>";
        } else {
            $general_save_result = "<p class='alertRed'>"._ERROR_SOMTHING_WORNG."</p>";
        }
        }
    }
}
}
// =============================[ Save Edit profile settings ]==============================
if (isset($_POST['EditProfile_save_changes'])) {
if (!password_verify($EditProfile_current_pass_var,$_SESSION['Password'])) {
    $EditProfile_save_result = "<p class='alertRed'>"._CURRENT_PASSWORD_INCORRECT."</p>";
}else{
    $update_info_sql = "UPDATE signup SET school= :school_var,work0= :work0_var,work= :work_var,country= :country_var,birthday= :birthday_var,website= :website_var,bio= :bio_var WHERE username= :session_un";
     $update_info = $conn->prepare($update_info_sql);
     $update_info->bindParam(':school_var',$school_var,PDO::PARAM_STR);
     $update_info->bindParam(':work0_var',$work0_var,PDO::PARAM_STR);
     $update_info->bindParam(':work_var',$work_var,PDO::PARAM_STR);
     $update_info->bindParam(':country_var',$country_var,PDO::PARAM_STR);
     $update_info->bindParam(':birthday_var',$birthday_var,PDO::PARAM_STR);
     $update_info->bindParam(':website_var',$website_var,PDO::PARAM_STR);
     $update_info->bindParam(':bio_var',$bio_var,PDO::PARAM_STR);
     $update_info->bindParam(':session_un',$session_un,PDO::PARAM_STR);
     $update_info->execute();
    if (isset($update_info)) {
        $_SESSION['school'] = $school_var;
        $_SESSION['work0'] = $work0_var;
        $_SESSION['work'] = $work_var;
        $_SESSION['country'] = $country_var;
        $_SESSION['birthday'] = $birthday_var;
        $_SESSION['website'] = $website_var;
        $_SESSION['bio'] = $bio_var;
        $EditProfile_save_result = "<p class='alertGreen'>"._CHANGE_PASSWORD_SAVE."</p>";
    } else {
        $EditProfile_save_result = "<p class='alertRed'>"._ERROR_SOMTHING_WORNG."</p>";
    }

}
}
// =============================[ Save Languages settings ]=================================
if (isset($_POST['lang_save_changes'])) {
if (!password_verify($lang_current_pass_var,$_SESSION['Password'])) {
    $lang_save_result = "<p class='alertRed'>"._CURRENT_PASSWORD_INCORRECT."</p>";
}else{
     $update_info_sql = "UPDATE signup SET language= :language_var WHERE username= :session_un";
     $update_info = $conn->prepare($update_info_sql);
     $update_info->bindParam(':language_var',$language_var,PDO::PARAM_STR);
     $update_info->bindParam(':session_un',$session_un,PDO::PARAM_STR);
     $update_info->execute();
    if (isset($update_info)) {
        $_SESSION['language'] = $language_var;
        $lang_save_result = "<p class='alertGreen'>"._CHANGE_PASSWORD_SAVE."</p>";
    } else {
        $lang_save_result = "<p class='alertRed'>"._ERROR_SOMTHING_WORNG."</p>";
    }
}
}
?>
<html>
<head>
    <title>Account settings | Wallstant</title>
    <meta charset="UTF-8">
    <meta name="description" content="Wallstant is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="settings,social network,social media,Wallstant,meet,free platform">
    <meta name="author" content="Munaf Aqeel Mahdi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?php include "includes/head_imports_main.php";?>
</head>
<body style="background:white;">
<!--=============================[ NavBar ]========================================-->

<!--=============================[ Div_Container ]========================================-->
 <div style="margin:0px auto; max-width:720px;">
<div class="container-fluid">

<div class="settings" style="text-align:center;">
<div class="scrollmenu">
<div class="tab" id="settings_ultab">
  <a href="?tc=general" id="a_general">
            <p class="tablinks <?php if($tc == 'general' or $tc == ''){echo 'tablinksActive';} ?>"> <span class="fa fa-cogs"></span><?php echo _GENERAL ?></p>
        </a>
   <a href="?tc=edit_profile" id="a_edit_profile">
            <p class="tablinks <?php if($tc == 'edit_profile'){echo 'tablinksActive';} ?>"><span class="fa fa-user-o"></span><?= _EDIT_PROFILE ?></p>
        </a>
  <a href="?tc=language" id="a_language">
            <p class="tablinks <?php if($tc == 'language'){echo 'tablinksActive';} ?> "><span class="fa fa-language"></span><?=  _LANGUAGE ?></p>
        </a>
</div>
</div>
<!--====================[ Edit profile section ]======================-->
<?php switch ($tc) { ?>
<?php case 'edit_profile': ?>
<div>
 <div id="Edit_profile"  style="height: auto;">
    <p  id="about_save_result"><?php echo $EditProfile_save_result; ?></p>
    <form action="" method="post">
    <p>
    <p class="settings_fieldTitle"><?= _EDUCATION ?></p>
    <input dir="auto" class="settings_textfield" type="text" name="edit_school" value="<?php echo $_SESSION['school']; ?>" /></p>
    <p>
    <p class="settings_fieldTitle"><?php echo _WORK ;?></p>
    <input dir="auto" class="settings_textfield settings_textfield1" type="text" name="edit_work0" placeholder=" <?php echo _WORK_TITLE ?> " value="<?php echo $_SESSION['work0']; ?>" /><span class="settings_tf_mergeSpan">at</span>
    <input dir="auto" class="settings_textfield settings_textfield1" type="text" name="edit_work" placeholder=" <?= _WORK_PLACE ?> " value="<?php echo $_SESSION['work']; ?>" /></p>
	<p>
    <p class="settings_fieldTitle"> <?= _CONTRY ?></p>
    <select  class="form-control settings_textfield" name="edit_country" style="width:100%;padding:4px;">
        <option selected disabled hidden><?php
        if (!empty($_SESSION['country'])) {echo $_SESSION['country'];}else{echo _SELECT_COUNTRY ;}?></option>
        <?php foreach($countries as $key => $value) { ?>
        <option <?php if($_SESSION['country'] == "$value"){ echo "selected";} ?> value="<?= htmlspecialchars($value) ?>" title="<?= $key ?>"><?= htmlspecialchars($value) ?></option>
        <?php } ?>
    </select>
	</p>
        <p>
        <p class="settings_fieldTitle"> <?= _BIRTHDAY ?></p>
		  <?php
        $exBthD = explode("/", $_SESSION['birthday']);
        echo '<select name="bd_year" class="form-control settings_textfield settings_textfield2" style="float:left;padding:4px;">';
            for($i = date('Y'); $i >= date('Y', strtotime('-100 years')); $i--){
              if ($exBthD[0] == $i) {
                 echo "<option selected='selected' value='$i'>$i</option>";
              }else{
                echo "<option value='$i'>$i</option>";
              }
            } 
        echo '</select> ';
        echo '<select name="bd_month" class="form-control settings_textfield settings_textfield2" style="float:left;padding:4px;" >';
            for($i = 1; $i <= 12; $i++){
              $i = str_pad($i, 2, 0, STR_PAD_LEFT);
              if ($exBthD[1] == $i) {
                 echo "<option selected='selected' value='$i'>$i</option>";
              }else{
                echo "<option value='$i'>$i</option>";
              }
            }
        echo '</select> ';
        echo '<select name="bd_day" class="form-control settings_textfield settings_textfield2" style="float:left;padding:4px;">';
            for($i = 1; $i <= 31; $i++){
              $i = str_pad($i, 2, 0, STR_PAD_LEFT);
              if ($exBthD[2] == $i) {
                 echo "<option selected='selected' value='$i'>$i</option>";
              }else{
                echo "<option value='$i'>$i</option>";
              }
            }
        echo '</select> ';
        ?>
		</p>
		</br>
		<p>
        <p class="settings_fieldTitle" ><?php echo _WEBSITE ?></p>
        <input dir="auto" class="settings_textfield" type="text" name="edit_website" value="<?php echo $_SESSION['website']; ?>" /></p>
        <p>
        <p class="settings_fieldTitle"> <?php echo _BIO ?></p>
        <textarea style="resize:none;height: 100px" dir="auto" class="settings_textfield" placeholder="150" maxlength="150" type="text" name="edit_bio"><?php echo $_SESSION['bio']; ?></textarea></p>
        <p>
     <div style="background: #e9ebee; border-radius: 3px; padding: 15px;">
         <p><input class="settings_textfield" type="password" name="EditProfile_current_pass" placeholder="<?php echo _CURRENT_PASSWORD; ?>" style="background: #fff;" /></p>
         <p style="margin: 0;"><input class="btn_blue" name="EditProfile_save_changes" type="submit" value="<?php echo _SAVE_CHANGE; ?>" /></p>
         </div>
    </form>
	</div>
</div>
<?php break; ?>
<!--====================[ Languages section ]======================-->
<?php case 'language': ?>
<div>
<div id="Language"  style="height: auto;">
         <p align="center" id="lang_save_result"></p>
    <form action="" method="post">
        <p>
        <select class="form-control settings_textfield" name="edit_language" style="width:100%;padding:3;">
            <option <?php if($_SESSION['language'] == "English"){ echo "selected";} ?> >English</option>
        <option <?php if($_SESSION['language'] == "العربية"){ echo "selected";} ?> >العربية</option>
        </select>
        </p>
        <div style="background: #e9ebee; border-radius: 3px; padding: 15px;">
         <p><input class="settings_textfield" type="password" name="lang_current_pass" placeholder="<?php echo _CURRENT_PASSWORD; ?>" style="background: #fff;" /></p>
         <p style="margin: 0;"><input class="btn_blue" name="lang_save_changes" type="submit" value="<?php echo _SAVE_CHANGE; ?>" /></p>
         </div>
    </form>
</div>
</div>
<?php break; ?>
<!--====================[ General section ]======================-->
<?php default: ?>
<div id="General"  style="height: auto;">
         <p align="center" id="general_save_result"><?php echo $general_save_result; ?></p>
        <form action="" method="post">
            <p>
            <p class="settings_fieldTitle"><?php  echo _FULL_NAME ?> <span><?php echo _REQURIED; ?></span></p>
            <input dir="auto" class="settings_textfield" type="text" name="edit_fullname" value="<?php echo $_SESSION['Fullname']; ?>" /></p>
            <p>
            <p class="settings_fieldTitle"><?php echo _USERNAME ?> <span><?php echo _REQURIED; ?></span></p>
            <input dir="auto" class="settings_textfield" type="text" name="edit_username" value="<?php echo $_SESSION['Username']; ?>" /></p>
            <p>
            <p class="settings_fieldTitle"><?php echo _EMAIL_ADDRESS ?> <span><?php echo _REQURIED; ?></span></p>
            <input dir="auto" class="settings_textfield" type="text" name="edit_email" value="<?php echo $_SESSION['Email']; ?>" /></p>
            <p>
            <p class="settings_fieldTitle"><?php echo _NEW_PASSWORD ?></p>
            <input class="settings_textfield" type="password" name="new_pass" /></p>
            <p>
            <p class="settings_fieldTitle"><?php  echo _CONFIRM_NEW_PASSWORD ?></p>
            <input class="settings_textfield" type="password" name="rewrite_new_pass" /></p>
             <p>
            <p class="settings_fieldTitle"> <?php echo  _GENDER ?> <span><?php echo _REQURIED; ?></span></p>
            <select class="settings_textfield" name="gender">
             <option <?php if($_SESSION['gender'] == "Male"){ echo "selected";} ?> ><?php echo _MALE; ?></option>
             <option <?php if($_SESSION['gender'] == "Female"){ echo "selected";} ?> ><?php echo _FEMALE ; ?></option>
             </select>
             </p>
             <div style="background: #e9ebee; border-radius: 3px; padding: 15px;">
                 <p><input class="settings_textfield" type="password" name="general_current_pass" placeholder="<?php echo _CURRENT_PASSWORD; ?>" style="background: #fff;" /></p>
                <p style="margin: 0;"><input class="btn_blue" name="general_save_changes" type="submit" value="<?php echo _SAVE_CHANGE; ?>" /></p>
             </div>
            </form>
    </div>
<?php /*//////////////////////////////////////////////////////*/ break; } ?>
</div>
   
    </div>
	</div>
    <!--===============================[ End ]==========================================-->

</body>
</html>