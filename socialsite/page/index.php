<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$myId = $_SESSION['id'];
$myPhoto = $_SESSION['Userphoto'];
include("../config/connect.php");
include("../includes/fetch_users_info.php");
include("../includes/time_function.php");
include("../includes/country_name_function.php");
include("../includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: ../index");
}
// ============[ This 'page' file is for other website pages as you can see in 'switch' ]==============
$page = filter_var(htmlspecialchars(htmlentities($_GET['p'])) , FILTER_SANITIZE_STRING); 
switch ($page) {
case 'supportbox':
$pagename = "Support box";
break;
case 'report':
$pagename = "Report a problem";
break;
default:
$pagename = "404 Not found!";
break;
}
?>
<html dir="ltr">
<head>
    <title><?php echo $pagename; ?> | Socilsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="Socilsite is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
    </script>
	<style>
	.contentBox{
    background: white;
    max-width: 800px;
    width: auto;
    margin: auto;
    border-radius: 2px;
    border: 1px solid #e0e0e0;
	
}
.reportAP_box{
    width: 100%;
	margin-bottom:20px;
}
.reportAP_box div{
    background: white;
    border-radius: 2px;
}
.btn_blue{
    background: #3da5ff;
    padding: 8px 20px;
    margin: 5px 0px;
    border-radius: 3px;
    color: #fff;
    text-decoration: none;
    border: none;
}
.btn_blue:hover , .btn_blue:focus{
    background: #3594e6;
    text-decoration: none;
    color: #fff;
}
.flat_solid_textfield{
    padding: 6px 10px;
    width: 100%;
    margin: 5px 0px;
    outline: none;
    border: 1px solid #ececec;
    border-radius: 2px;
    transition: border-bottom 0.3s, box-shadow 0.3s;
}
.flat_solid_textfield:focus{
    border-bottom: 1px solid #2196F3;
}
.sb_caseOpen{
    background: #2196f3;
    color: #fff;
    padding: 2px 9px;
    border-radius: 20px;
}
.sb_caseClosed{
    background: #e9ebee;
    color: #777;
    padding: 2px 9px;
    border-radius: 20px;
}
#viewreport{
    display: flex;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
}
#viewreport:hover,#viewreport:focus{
    background: #f6f7f9;
} 
	</style>
</head>
<body onload="fetchPosts_DB('user')">
<?php
switch ($page) {
case 'supportbox':
?>
<!--=============================[ support box ]========================================-->
<div align="center" style="margin:0px auto; max-width:560px;">
<div class="reportAP_box">
			<div>
			<button style="width: 100%;" name="reportbtn" id="reportbtn" class="btn_blue"><?php echo _REPORT_A_PROBLEM; ?></button>
			<p style="text-align:center;margin: 0;color: #999; font-size: 12px; font-weight: bold;"><?php echo _HELP_US_TO_MAKE_OUR_COMMUNITY; ?></p> 
			</div>
		</div>
	<div align="left">
	
	<div class="contentBox" style="margin-bottom: 15px;"><p style="text-align:left;margin: 0px;padding: 10px 15px;"><span style="padding: 10px 15px;border-bottom: 3px solid #2196f3;"><?php echo _SUPPORT_BOX; ?></span></p></div>
		<div style="display: flex; max-width: 830px; margin: auto;text-align:left;">
		<div style="width: 100%; margin: 0px 15px;">
		<?php
		$getReports = $conn->prepare("SELECT * FROM supportbox WHERE from_id =:myId ORDER BY r_time DESC");
		$getReports->bindParam(':myId',$myId,PDO::PARAM_INT);
		$getReports->execute();
		$countReports = $getReports->rowCount();
		if($countReports < 1){echo "<div style='width: 100%;margin-bottom: 15px;padding:3px;color:#999;' class='contentBox'>"._NOTHINGSHOW."</div>";}
		while ($r_row = $getReports->fetch(PDO::FETCH_ASSOC)) {
			$r_id = $r_row['r_id'];
			$from_id = $r_row['from_id'];
			$for_id = $r_row['for_id'];
			$r_type = $r_row['r_type'];
			$subject = $r_row['subject'];
			$report = $r_row['report'];
			$r_time = $r_row['r_time'];
			$r_time = time_ago($r_time);
			$r_replay = $r_row['r_replay'];
			$r_replay_time = $r_row['r_replay_time'];
			$r_replay_time = time_ago($r_replay_time);
			$status = $r_row['status'];
			if ($status == "0") {
				$r_status = "<span class='sb_caseOpen'>"._OPEN."</span>";
			}elseif ($status == "1") {
				$r_status = "<span class='sb_caseClosed'>"._CLOSED."</span>";
			}
			switch ($r_type) {
				case 'post':
					$subject = _YOU_ANONYMOUSLY_REPORTED." <a href='../posts/post?pid=$for_id'>"._POST."</a>.";
					$report = _YOU_ANONYMOUSLY_REPORTED." <a href='../posts/post?pid=$for_id'>"._POST."</a>.";
				break;
				case 'problem':
					$subject = $subject;
					$report = $report;
				break;
			}
		?>
		<!--===============[ Report ]===============-->
		<div class="contentBox" id="report_<?php echo $r_id; ?>" style="width: 500px;margin-bottom: 15px;">
			<div id="viewreport" onclick="viewreport('<?php echo $r_id; ?>')">
				<div style="padding: 5px;"><img src="../imgs/main_icons/1f4e8.png" style="width: 40px;height:40px;" /></div>
				<div style="padding: 5px;"><p style="margin:0px;word-break: break-word;"><?php echo $subject." ".$r_status; ?><br/>
				<span style="color: #999;font-size: 11px;"><?php echo _CLICK_TO_VIEW_YOUR_REPORT ; ?></span></p></div>
			</div>
			<div id="myReport_<?php echo $r_id; ?>" style="display: none; background: #f6f7f9; border-bottom: 1px solid #ddd;">
				<div style="display: flex;">
				<div style="padding: 5px;"><div style="width: 40px;height: 40px;overflow: hidden;background: white;border-radius: 100px;"><img src="../imgs/user_imgs/<?php echo $myPhoto ?>"  style="width: auto;height: 100%;" /></div></div>
				<div style="padding: 5px;">
					<p><b><?php echo _YOUR_REPORT ; ?></b><br/><span style="color: #999;font-size: 11px;"><?php echo $r_time; ?></span></p>
					<p style="font-size: 13px;word-break: break-word;">
					<?php echo nl2br($report); ?>
					</p>
					<p id="delR_<?php echo $r_id; ?>"><a href="javascript:void(0);" onclick="deleteReport('<?php echo $r_id; ?>')"><?php echo _DELET ; ?></a></p>
				</div>
				</div>
			</div> 
			<?php if(!empty($r_replay)){ ?>
			<div id="reportReplay" style="display: flex; background: #f6f7f9; border-bottom: 1px solid #ddd;">
				<div style="padding: 5px;"><img src="../imgs/main_icons/1f5e8.png"  style="width: 40px;height:40px;" /></div>
				<div style="padding: 5px;">
					<p><b><?php echo _REPLAY; ?></b><br/><span style="color: #999;font-size: 11px;"><?php echo $r_replay_time; ?></span></p>
					<p style="font-size: 13px;word-break: break-word;">
					<?php echo nl2br($r_replay); ?>
					</p>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		</div>
		<!--================[ end ]=================-->
		
		</div>
	</div>
</div>
<?php
break;
case 'report':
?>
<!--=============================[ report a problem ]========================================-->
<div align="center" style="margin:0px auto; max-width:560px;">
<div class="reportAP_box">
			<div>
				<button style="width: 100%;" name="reportbtn" id="sboxbtn" class="btn_blue"><?php echo _SUPPORT_BOX ; ?></button>
			<p style="text-align:center;margin: 0;color: #999; font-size: 12px; font-weight: bold;"><?php echo _HELP_US_TO_MAKE_OUR_COMMUNITY ; ?></p> 
			</div>
		</div>
	<div align="left">
	<div class="contentBox" style="margin-bottom: 15px;"><p style="text-align:left;margin: 0px;padding: 10px 15px;"><span style="padding: 10px 15px;border-bottom: 3px solid #2196f3;"><?php echo _REPORT_A_PROBLEM; ?></span></p></div>
		<div style="text-align:left;display: flex; max-width: 830px; margin: auto;">
		<div style="width: 100%; margin: 0px 15px;">
		<div class="contentBox" style="padding: 15px;">
		<p><?php echo _YOUR_FEEDBACK_HELPS_US_IMPROVE_OUR_COMMUNITY ; ?>.</p>
		<p style="margin: 0;color: #999; font-size: 12px; font-weight: bold;"><?php echo _SUBJECT; ?> :</p>
			<input id="report_sub" type="text" class="flat_solid_textfield" name="report_sub" dir="auto" maxlength="300" />
		<p style="margin: 0;color: #999; font-size: 12px; font-weight: bold;"><?php echo _YOUR_REPORT; ?> :</p>
			<textarea id="report_txt" style="resize: none;height: auto;min-height: 200px;" name="report_txt" dir="auto" maxlength="1000" class="flat_solid_textfield"></textarea>
			<button class="btn_blue" id="report_submit" name="report_submit" onclick="submitreport()"><?php echo _SUBMIT ; ?></button>
			<div id="SubLog"></div>
		</div>
		</div>
		
		</div>
	</div>
</div>
<?php
break;
default:
?>
<!--=============================[ 404 page Not found! ]========================================-->
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
<h1 style="font-weight: bold;"><img src="../imgs/main_icons/1f915.png" style="width: 80px;height: 80px;" /> <?php echo _THIS_PAGE_NOT_AVAILABLE; ?></h1>
<h3><?php echo _THIS_PAGE_NOT_AVAILABLE2; ?></h3><br>
<a href="javascript:history.back()" class="error_page_btn"><?php echo _THIS_PAGE_NOT_AVAILABLE3; ?></a>
</div></div>
<?php
break;
}
?>
<!--=============================[ endJScodes ]========================================-->
<?php include "../includes/endJScodes.php"; ?>
<script type="text/javascript">
function viewreport(r_id){
$("#myReport_"+r_id).toggle();
}
$("#reportbtn").click(function(){
    window.location.href = "../page/report";
});
$("#sboxbtn").click(function(){
    window.location.href = "../page/supportbox";
});
</script>
</body>
</html>
