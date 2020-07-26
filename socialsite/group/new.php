<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

include("../config/connect.php");
include("..//includes/fetch_users_info.php");
include("../includes/time_function.php");
include("../includes/country_name_function.php");
include("../includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: ../index");
}

if (isset($_POST['group_submit'])) {
    $g_name = htmlentities($_POST['g_name'], ENT_QUOTES);
    $note_content = htmlentities($_POST['note_content'], ENT_QUOTES);
	switch (filter_var(htmlspecialchars($_POST['w_privacy']),FILTER_SANITIZE_STRING)) {
	case _PUBLIC:
		$p_privacy = "0";
		break;
	case _ONLY_ME:
		$p_privacy = "1";
		break;
	}
    $g_time = time();
    $note_id = rand(0,9999999)+time();
	$g_image = "group.png";
    $author_id = $_SESSION['id'];

	 if (trim($g_name) == null) {
        $error_success_msg = "
<p id='error_msg' onclick='hideMsg()'>
Please write note title and try again.
</p>
";
    }
	elseif (trim($note_content) == null) {
				$error_success_msg = "
		<p id='error_msg' onclick='hideMsg()'>
		Please write note content and try again.
		</p>
		";
    }

	$groupsql = "SELECT * FROM groups WHERE g_name=:g_name";
	$exist_group = $conn->prepare($groupsql);
	$exist_group->bindParam(':g_name', $g_name, PDO::PARAM_STR);
	$exist_group->execute();
	$num_un_ex = $exist_group->rowCount();
	if(trim($g_name) == null || trim($note_content) == null){
      	  $error_success_msg = "
	<p id='error_msg' onclick='hideMsg()'>
	Please write note title and try again.
	</p>
	"; 
      }
	elseif($num_un_ex == 1){
		  $error_success_msg = "
	<p id='error_msg' onclick='hideMsg()'>
	Group name not exit;
	</p>
	"; 
	}
else{
    $newNote_sql = "INSERT INTO groups 
(id, admin_id , g_name , g_discription , g_privacy ,g_image,g_time)
VALUES
( :note_id, :author_id, :g_name, :note_content,:p_privacy,:g_image,:g_time)";
    $newNote = $conn->prepare($newNote_sql);
    $newNote->bindParam(':note_id',$note_id,PDO::PARAM_INT);
    $newNote->bindParam(':author_id',$author_id,PDO::PARAM_INT);
    $newNote->bindParam(':g_name',$g_name,PDO::PARAM_STR);
    $newNote->bindParam(':note_content',$note_content,PDO::PARAM_STR);
	$newNote->bindParam(':p_privacy',$p_privacy,PDO::PARAM_STR);
	$newNote->bindParam(':g_image',$g_image,PDO::PARAM_STR);
	$newNote->bindParam(':g_time',$g_time,PDO::PARAM_STR);
	
	$gmember_sql = "INSERT INTO gmember 
   (um_one, um_two) VALUES (:author_id, :note_id)";
    $newGroup = $conn->prepare($gmember_sql);
    $newGroup->bindParam(':author_id',$author_id,PDO::PARAM_INT);
	$newGroup->bindParam(':note_id',$note_id,PDO::PARAM_INT);
	
    if ($newNote->execute() AND $newGroup->execute()) {
        header("Location: main");
    }else{
        $error_success_msg = "
<p id='error_msg' onclick='hideMsg()'>
Error there was somthing wrong, Please try again.
</p>
";
        }
    }
}
?>

<html dir="ltr">
<head>
    <title>Create new note | Socilsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="Socilsite is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
    <style type="text/css">
        .noteContent{
            min-height: 196px;
            overflow-y: hidden;
            resize: none;
        }

    </style>
</head>
    <body onload="hide_notify()" style="background:white;">
<!--=============================[ Container ]=====================================-->
	  <nav>
				<div class="nav-wrapper">
				  <a href="#!" class="brand-logo center">Logo</a>
				</div>
			  </nav>   
      <div style="margin:0px auto; max-width:560px; margin-top:10px;">
        <div align="center">
            <div class="white_div" style="text-align:left;">
            <h3 style="margin-top: 0;margin-bottom: 0;"><?php echo _NEW_NOTE ; ?></h3>
             <p><?php echo _NEW_NOTE_P ; ?>.</p>
             <?php echo $error_success_msg; ?>
			 </div>
			  <div class="white_div" style="text-align:left; margin-top:10px;">
             <form action="" method="POST">
                     <input  maxlength="60" autocomplete="off" id="noteTitle" dir="auto" type="text" name="g_name" class="flat_solid_textfield" placeholder="<?php echo _NOTE_TITLE ; ?>" style="text-align:left;">
                     <textarea name="note_content" autocomplete="off" class="flat_solid_textfield noteContent" placeholder="<?php echo _NOTE_CONTENT ; ?>" style="resize: vertical;height:auto;min-height:100px;" 
                      dir="auto"></textarea>
					      </div>
						  <div class="white_div" style="text-align:left; margin-top:10px;">
					  <div class="form-group">
					  <label for="group">Privacy :</label>
					  <select id="p_privacy" name="w_privacy"  id="group" class="form-control">
						<option selected=""><?php echo _PUBLIC ?></option>
						<option>Private</option>
					</select>
					</div>
					<p>Public : Any member can post in this group;</p>
					<p>Private : Only an admin post in this group;</p>
					 </div>
						  <div class="white_div" style="text-align:left; margin-top:10px;margin-bottom:20px;">
                     <input type="submit" name="group_submit" class="green_flat_btn" value="<?php echo _CREATE ; ?>">
                     <a href="main" class="silver_flat_btn"><?php echo _CANCEL ; ?></a>
					 </div>
             </form>
       
        </div>
		</div>
<!--=============================[ Footer ]========================================-->
<script>
$('#noteTitle').maxlength();
    var acc = document.getElementsByClassName("dropdown_div_accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function(){
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
        }
    }
$('.noteContent').each(function () {
  this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;text-align:left;');
}).on('input', function () {
  this.style.height = 'auto';
  this.style.height = (this.scrollHeight) + 'px';
})
function hideMsg(){
    $('#error_msg').fadeOut('slow');
    $('#success_msg').fadeOut('slow');
}
</script>
    </body>
</html>