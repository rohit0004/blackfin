<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("../config/connect.php");
include("../includes/fetch_users_info.php");
include ("../includes/time_function.php");
if(!isset($_SESSION['Username'])){
    header("location: ../index");
}
if (is_dir("imgs/")) {
        $check_path = "";
    }elseif (is_dir("../imgs/")) {
        $check_path = "../";
    }elseif (is_dir("../../imgs/")) {
        $check_path = "../../";
    }
$myid = $_SESSION['id'];	
$gid = filter_var(htmlspecialchars($_GET['g']),FILTER_SANITIZE_STRING);	
?>
<html>
<head>
    <title><?= _MESSAGES; ?> | Socilsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="Socilsite is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="Notifications,social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
	<style>
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
label,input{
    display: inline-block;
    vertical-align: middle;
}
.back{
	display:none;
}
.header{width:100%;padding:10px 0; background:#f9f9f9;box-shadow:0 0 10px 2px rgba(0,0,0,0.1);background:red;padding-bottom:13px;}
.header img {width:20px;position:absolute;top:10px; cursor:pointer;}
.header p{color:#007aff;text-align:center;}
	</style>
</head>
<body>
<!--<div class="header">
  <img src="imag/image2.jpg" class="menu-icon">
  <p>MEET APP </p>
</div>-->
<div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
	 
	  <img src="../icon/back.png" style="width:30px;height:30px; float:left;margin-left:10px; margin-top:16px;" class="back">
	  <p style="margin-left:10px;">New Group</p>
      </div>
    </nav>
  </div>
  <div style="margin:0px auto; max-width:600px;">
   <div class="container-fluid">
<div class="group">
    	<!--	<input type="text" class="m_contacts_search" id="mU_search" name="mU_search" placeholder="" />
			</br>
			</br>
			</br>-->
           <div id="m_contacts" class="scrollbar" style="position:absolute;top: 0; right: 0; left: 0; bottom: 0; margin-top: 20px; overflow: auto;">
            
                <p class="m_contacts_title">Add Member</p>
                <div id="group_add_friends">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
    		</div>
<div id="m_contacts_search" class="scrollbar" style="position:absolute;display: none; top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;"></div>
</div> 
</div> 
</div> 
<?php
	/*$groupAddMember_sql = "SELECT * FROM chat_g_member WHERE group_id=:gid";
	$exist_member = $conn->prepare($groupAddMember_sql);
	$exist_member->bindParam(':gid', $gid, PDO::PARAM_STR);
	$exist_member->execute();
	$num_un_ex = $exist_member->rowCount();
	
	   /* echo $num_un_ex;
	    $getMember_sql = "SELECT uf_two FROM follow WHERE uf_one=766903157894782 AND uf_two != 841513156478802";
		$get_member = $conn->prepare($getMember_sql);
		$get_member->execute();
		$num_get_member = $get_member->rowCount();
		if($num_get_member > 0){
		while ($getaddMember = $get_member->fetch(PDO::FETCH_ASSOC)) {
			$addgroupMember = $getaddMember['uf_two'];
			//echo $addgroupMember."gollow</br>";}
		}
		}
		else{
			echo "not record";
		}*/
	
	/*while ($addMember = $exist_member->fetch(PDO::FETCH_ASSOC)) {
		
		$visiblemember[] = filter_var(htmlspecialchars($addMember['g_member']),FILTER_SANITIZE_STRING);
	}
	if(!empty(array_filter($visiblemember))){
	foreach($visiblemember as $add){
		if($add==$myid){			
		}
		else{
		$getMember_sql = "SELECT uf_two FROM follow WHERE uf_one=:myid AND uf_two != :add";
		$get_member = $conn->prepare($getMember_sql);
		$get_member->bindParam(':myid', $myid, PDO::PARAM_INT);
		$get_member->bindParam(':add', $add, PDO::PARAM_INT);
		$get_member->execute();
		$num_get_member = $get_member->rowCount();
		}
	}
	echo $num_get_member."</br>";
	while ($getaddMember = $get_member->fetch(PDO::FETCH_ASSOC)) {
			//$addgroupMember = $getaddMember['uf_two'];
			echo $getaddMember['uf_two'];
		}
}
	else{
		print_r($visiblemember);
	}
		
		/*if($num_get_member > 0){
		while ($getaddMember = $get_member->fetch(PDO::FETCH_ASSOC)) {
			$addgroupMember = $getaddMember['uf_two'];
			echo $addGroupMember;
		}
		}
		else{
			
		}*/
		
 /* if(!empty($_POST['addNewMember'])) {
$newMember = filter_var(($_POST['addNewMember']),FILTER_SANITIZE_STRING);  
foreach($_POST['addNewMember'] as $add){
      $newMember_sql = "INSERT INTO chat_g_member 
   (g_member, group_id) VALUES (:add, :gid)";
   
    $newAddMember = $conn->prepare($newMember_sql);
	$newAddMember->bindParam(':add',$add,PDO::PARAM_INT);
	$newAddMember->bindParam(':gid',$gid,PDO::PARAM_INT);
	$newAddMember->execute();
	header("Location:  message"); 

    }
  }*/
?>
<script>
$(document).ready(function() {
	addMember();
})
function addMember(){
var group_id="<?php echo $gid ?>";	
var requ = "addMember";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_group_request.php",
    data:{'group_id':group_id,'req':requ,'path':path},
    success:function(data){	
     if (data == '') {
		alert(data);
        $('#group_add_friends').html("<p style='margin: 0px 8px; text-align: center; color: grey; background: rgba(0, 0, 0, 0.03); padding: 8px 0px; border-radius: 3px;'><?= _NOTHINGSHOW ; ?></p>");
     }
	 else{
		 alert(data);
     $('#group_add_friends').html(data);
     }
    }
});
}
</script>
</body>
</html>