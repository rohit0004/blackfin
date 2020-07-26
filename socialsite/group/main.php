<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();

include("../config/connect.php");
include("..//includes/fetch_users_info.php");
include("../includes/time_function.php");
include("../includes/country_name_function.php");
include("../includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: ../index");
}
?>

<html dir="ltr">
<head>
    <title><?php echo _MYNOTEPAD ;?> | Socilsite</title>
    <meta charset="UTF-8">
    <meta name="description" content="Socilsite is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
	<style>
.dropdown_div_accordion {
    background-color: #ffffff;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
}
.dropdown_div_accordion i{
    float: right;
}
.dropdown_div_accordion.active, .dropdown_div_accordion:hover {
    background-color: rgba(74, 112, 142, 0.08);
}

.dropdown_div_panel {
    padding: 0 18px;
    background-color: rgba(74, 112, 142, 0.04);
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    margin-bottom: 1px;
    box-shadow: inset 0px 0px 20px 10px #e5ebef;
}

.dropdown_div_panel.show {
    opacity: 1;
    max-height: 500px;
    padding: 15px;
}
	</style>
</head>
    <body onload="hide_notify()">
<!--=============================[ NavBar ]========================================-->
<!--=============================[ Container ]=====================================-->
       <div style="margin:0px auto; max-width:560px;">
            <div class="white_div" style="text-align: left;">
                <p><span class="fa fa-lock"></span> <?php echo _MYNOTEPAD ;?><a href="new" class="green_flat_btn" style="float:right;"><?php echo _NEW_NOTE;?></a>
                </p>
<b> You Create </b>				
        <?php
$s_id = $_SESSION['id'];
$groups_sql = "SELECT * FROM groups WHERE admin_id= :s_id ORDER BY g_time DESC";
$v_groups = $conn->prepare($groups_sql);
$v_groups->bindParam(':s_id', $s_id, PDO::PARAM_INT);
$v_groups->execute();

if ($v_groups->rowCount() == 0) {
echo "<p align='center'>"._NOTPAD_MAIN_TITLE.".</p>";
}else{
while ($v_groups_row = $v_groups->fetch(PDO::FETCH_ASSOC)) {
    $g_name = $v_groups_row['g_name'];
    $g_image = $v_groups_row['g_image'];
	$g_privacy=$v_groups_row['g_privacy'];
	
echo	"<table style=\"width:100%; padding-top:0px;\">
<tbody><tr>
<td style=\"width:50px;\">
<div class=\"username_OF_postImg\"><img src=\"".$check_path."imgs/user_imgs/$g_image\"></div>
</td>
<td style=\"margin-left:0px;\">
<a href=\"$g_name\" class=\"username_OF_postLink\">$g_name</a><br>";
if($g_privacy == 0){
 echo "<a href=\"$g_name\" class=\"username_OF_postTime\">public</a><br>";	
}
else{
 echo "<a href=\"$g_name\" class=\"username_OF_postTime\">private</a><br>";	
}
echo "
</td>
</tr>
</tbody></table>"; 
	
}
}
        ?>
            </div>
        </div>
<!--=============================[ Footer ]========================================-->
    </body>
</html>