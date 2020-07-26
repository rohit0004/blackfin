<?php
if(isset($_POST['submit_image']))
{
for($i=0;$i<count($_FILES["images"]["name"]);$i++)
{
 $uploadfile=$_FILES["images"]["tmp_name"][$i];
 $folder="upload/";
 move_uploaded_file($_FILES["images"]["tmp_name"][$i], "$folder".$_FILES["images"]["name"][$i]);
}
exit();
}
?>