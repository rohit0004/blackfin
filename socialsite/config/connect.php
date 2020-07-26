<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "socialsite";

try 
    {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

// ========================= config the languages ================================
if(isset($_GET['lang']) && !empty($_GET['lang'])){
 $_SESSION['lang'] = $_GET['lang'];

 if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
  echo "<script type='text/javascript'> location.reload(); </script>";
 }
}

// Include Language file
error_reporting(E_NOTICE ^ E_ALL);
if (is_file('home.php')){
    $path = "";
}elseif (is_file('../home.php')){
    $path =  "../";
}elseif (is_file('../../home.php')){
    $path =  "../../";
}
if(isset($_SESSION['lang'])){
 include_once  $path."langu/lang_".$_SESSION['lang'].".php";
}else{
 include_once  $path."langu/lang_english.php";
}

// ================================ user verified badge style 
$verifyUser = "<span style='color: #03A9F4;' data-toggle='tooltip' data-placement='top' title=Verified page class='fa fa-check-circle verifyUser'></span>";
// ================================ check user if exist or not (for removed account).
/*$usrSessID = $_SESSION['id'];
$usrRemovedAcc = $conn->prepare("SELECT id FROM signup WHERE id=:usrSessID");
$usrRemovedAcc->bindParam(':usrSessID',$usrSessID,PDO::PARAM_INT);
$usrRemovedAcc->execute();
$$usrRemovedAccCount = $usrRemovedAcc->rowCount();
if (isset($usrSessID)) {
	if($$usrRemovedAccCount < 1){
		session_destroy();
	}
}*/
?>