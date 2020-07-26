<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("../config/connect.php");
include("../includes/fetch_users_info.php");
include ("../includes/time_function.php");
include ("../includes/num_k_m_count.php");
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
<html dir="ltr">
<head>
  <title>Saved posts | Socilsite</title>
  <meta charset="UTF-8">
    <meta name="description" content="Socilsite is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,Socilsite,meet,free platform">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../includes/head_imports_main.php";?>
  <style>
  *{margin:0px;padding:0px;}
.red_flat_btn{
    background: #f75151;
    padding: 10px 20px;
    border-radius: 3px;
    color: #fff;
    text-decoration: none;
    border: none;
    margin: auto;
}
.red_flat_btn:hover , .red_flat_btn:focus{
    background: #ce3d3d;
    text-decoration: none;
    color: #fff;
}
.silver_flat_btn{
    background: rgb(233, 235, 238);
    padding: 10px;
    border-radius: 3px;
    color: gray;
    text-decoration: none;
    border: none;
    margin: auto;
}
.silver_flat_btn:hover, .silver_flat_btn:focus{
    background: rgb(216, 219, 224);
    color: gray;
    text-decoration: none;
}
.galleryItem img {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.galleryItem{
    color: #797478;
    font: 10px/1.5 Verdana, Helvetica, sans-serif;
    float: left;    
    width:50%;
	height:200px;	
}
@media only screen and (max-width : 720px),
only screen and (max-device-width : 720px){
    .galleryItem {height:150px;}
}
  </style>
</head>
<body>
<div style="margin:0px auto; max-width:480px;">
 <table class="postSavedTable" style=" width:100%; max-width:560px;">
            <tr style="font-weight: bold; text-transform: uppercase; color: rgba(0, 0, 0, 0.59); font-size: 13px; background: rgb(241, 241, 241); border-bottom: 2px solid #46a0ec;">
                <td><?php echo _ALL_POST_SAVED ; ?></td>
                <td align="center"><span class="fa fa-cog"></span></td>
            </tr>
            <?php include "../includes/fetch_posts_saved.php"; ?>
        </table>
		 <?php
        if ($countSaved < 1) {
        ?>
        <div class="saved_nothingToShow">
            <p>
            <span class="fa fa-newspaper-o" style="font-size: 62px;"></span><br>
            <?php echo _NOTHING_SAVED_YET ; ?>.</p>
        </div>
        <?php
        }
        ?>
  </div>
  <?php include "../includes/endJScodes.php"; ?>
</body>
</html>
