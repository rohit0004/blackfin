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
.addNewMember{ vertical-align: middle;
  float: right;}
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
    	<!--	<input type="text" class="m_contacts_search" id="mU_search" name="mU_search" placeholder="" />-->
			</br>
			</br>
			</br>
           <div id="m_contacts" class="scrollbar" style="position:absolute;top: 0; right: 0; left: 0; bottom: 0; margin-top: 20px; overflow: auto;">
            
                <p class="m_contacts_title">Add Member</p>
                <div id="m_contacts_friends">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
    		</div>
<div id="m_contacts_search" class="scrollbar" style="position:absolute;display: none; top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;"></div>
</div> 
</div> 
</div> 
 <div style="margin:0px auto; max-width:600px;" id="participent">
  <?php echo $error_success_msg; ?>
 <div class="container-fluid">
 <input type="text" class="group_name" id="group_name" name="group_name" placeholder="Enter Group name" />
 <input type="text" class="group_dis" id="group_dis" name="group_dis" placeholder="Dscription.." />
 <span style="font-size:11px;">Enter a group name and optional group discription.</span>
 <?php
  if(!empty($_POST['groupMember'])) {
	$menber=$_POST['groupMember'];
  $totalParticipate=count($_POST['groupMember']);
  echo " <p style='margin-top:20px;'>Participants: ".$totalParticipate. "</p>";
  echo"<style>
  .group{display:none;}
  .back{display:block;}
  #participent{display:block;}
  </style>";
  }
  else{
	 echo"<style>
  .group{display:block;}
  #participent{display:none;}
  </style>"; 
  }
 ?>
 
<?php
    if(!empty($_POST['groupMember'])) {

        foreach($_POST['groupMember'] as $value){
				$query = "
		  SELECT id,online,Fullname,Userphoto,Username,verify FROM signup WHERE id='".$value."'
		  ";
		  $usersInfo = $conn->prepare($query);
		  $usersInfo->execute();
          while ($uRows = $usersInfo->fetch(PDO::FETCH_ASSOC)) {
$uid = $uRows['id'];
$lastMsg = "@".$uRows['Username'];
if ($uRows['verify'] == "1"){
    $verifypage_var = $verifyUser;
}else{
    $verifypage_var = "";
}
echo "
<table class=\"m_contacts_table\">
	<tr class=\"mC_userLink\" data-muid=\"".$uRows['id']."\">
		<td style=\"width: 44px;position: relative;\">
			<div class=\"m_contacts_user\">
				<div class=\"m_userActive\" style=\"background:".$m_userActive.";right:8px;\"></div>
				<img src=\"".$path."imgs/user_imgs/".$uRows['Userphoto']."\">
			</div>
		</td>
		<td>
			<p>".$uRows['Fullname']."$verifypage_var<span id=\"msgsCount\" style=\"float:right\">".$mCountUnseen."</span><br><span style=\"word-break: break-word;font-size: 12px;color: #d2d2d2;\">".$lastMsg."</span></p>
		</td>
	</tr>
</table>
";	
}
        }

    }
echo " <div class=\"fixed-action-btn\" id=\"creatGroup\">
  <a class=\"btn-floating btn-large red\">
    <i class=\"large material-icons\">check</i>
  </a>
</div>";
?>
</div>
</div>
<script>
$(document).ready(function() {
	mLoadUsers();
})
$('#mU_search').keyup(function(){
    mSearchUser();
});
$("#creatGroup" ).click(function() {
var groupName = $.trim($('#group_name').val());	
var groupDis = $.trim($('#group_dis').val());	
var member = <?php echo json_encode($menber); ?>;
var requ = "groupCreate";
var path = "<?php echo $check_path; ?>";
if(groupName == ''){
 M.toast({html: 'Please enter group name!', classes: 'rounded'})	
}
else{
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_group_request.php",
    data:{'groupName':groupName,'groupDis':groupDis,'member':member,'req':requ,'path':path},
    success:function(data){
     alert(data);
    header("Location:  messages"); 
    }
});
}
});
function mLoadUsers(){
var requ = "getUsers";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_group_request.php",
    data:{'req':requ,'path':path},
    success:function(data){
     if (data =='') {
        $('#m_contacts_friends').html("<p style='margin: 0px 8px; text-align: center; color: grey; background: rgba(0, 0, 0, 0.03); padding: 8px 0px; border-radius: 3px;'><?= _NOTHINGSHOW ; ?></p>");
     }else{
     $('#m_contacts_friends').html(data);
     }
    }
});
}
function mSearchUser(){
var requ = "searchUser";
var path = "<?php echo $check_path; ?>";
var mSearch = $.trim($('#mU_search').val());
if (mSearch != '') {
$('#m_contacts').hide();
$('#m_contacts_search').show();
$.ajax({
    type:'POST',
    url:"<?php echo $check_path; ?>includes/m_group_request.php",
    data:{'req':requ,'path':path,'mSearch':mSearch},
    beforeSend:function(){
        $('#m_contacts_search').html("<div style='text-align: center; padding: 15px;'><img src='"+path+"imgs/loading_video.gif'></div>");
    },
    success:function(data){
     $('#m_contacts_search').html(data);
    }
});
}else{
   mLoadUsers();
   $('#m_contacts').show();
   $('#m_contacts_search').hide();
}
}

</script>
</body>
</html>