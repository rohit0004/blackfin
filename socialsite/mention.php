<?php
include("config/connect.php");
$mSearch = filter_var(htmlentities($_POST['mSearch']),FILTER_SANITIZE_STRING);
 $query = "
 SELECT id,online,Fullname,Userphoto,Username,verify FROM signup WHERE  (Fullname LIKE ? OR Username LIKE ?)
 ";

 $statement = $conn->prepare($query);
 $params = array("$mSearch%","$mSearch%");
 $statement->execute($params);
 while ($uSearch_row = $statement->fetch(PDO::FETCH_ASSOC)) {
$search_uid=$uSearch_row['id'];
// if user online make online circle green, If not make it silver or gray
if ($uSearch_row['online'] == "1") {
	$m_userActive = "#4CAF50";
}else{
	$m_userActive = "#ccc";
}
// if user verified echo verify badge , If not do nothing
if ($uSearch_row['verify'] == "1"){
    $verifypage_var = $verifyUser;
}else{
    $verifypage_var = "";
}
// send result
echo "
<table class=\"m_contacts_table\"  title='@".$uSearch_row['Username']."'>
	<tr class=\"mC_userLink\" data-muid=\"".$uSearch_row['id']."\">
		<td style=\"width: 44px;position: relative;\">
			<div class=\"m_contacts_user\">
				<div class=\"m_userActive\" style=\"background:".$m_userActive.";right:8px;\"></div>
				<img src=\"".$path."imgs/user_imgs/".$uSearch_row['Userphoto']."\">
			</div>
		</td>
		<td>
			<p>".$uSearch_row['Fullname']."$verifypage_var<span id=\"msgsCount\" style=\"float:right\"></span><br><span style=\"font-size: 12px;color: #d2d2d2;\">@".$uSearch_row['Username']."</span></p>
		</td>
	</tr>
</table>
";
}
/*echo "<script>
$(\".m_contacts_table\").on(\"click\",function()
{
var username=$(this).attr('title');
var E=\"<a class='red' contenteditable='false' href='#' >\"+username+\"</a>\";
alert(E);
$(\"#lang_rtl_ltr\").append(\"Some appended text.\");
$(\"#display\").hide();
$(\"#msgbox\").hide();
});
</script>";
/* while($row=mysql_fetch_array($sql_res))
{
$fname=$row['fname'];
$lname=$row['lname'];
$img=$row['img'];
$country=$row['country'];
?>
<div class="display_box" >
<img src="user_img/<?php echo $img; ?>" class="image" />
<a href="#" class='addname' title='<?php echo $fname; ?>&nbsp;<?php echo $lname; ?>'>
<?php echo $fname; ?>&nbsp;<?php echo $lname; ?> </a>
</div>
<?php
}
}
?>*/
?>