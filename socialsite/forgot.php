<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if(isset($_SESSION['Username'])){
    header("location: home");
	$username=$_SESSION['Username'];
	echo $username;
}
include("config/connect.php");
?>
<html>
<head>
	<title>Real Estate property searching site in patna</title>
	<meta charset="UTF-8">
	<meta name="description" content="Search any types of Real Esate property single room,Double room,flat,apartment,plot,commercial,for Buy ,Sale,Rent in patna and Add any types of property absolutly free.">
	<meta name="keywords" content="Property in patna,room for rent in patna,property site,properties,flat for rent">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body style="background-color:#B4CDF1;">
<div class="container" style="margin-top:100px;">

    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="account-box" style="border: 3px solid #f1f1f1; padding:15px; background-color:white;">
             <center>   <h4 class="mb-3">

                  Forgot

                </h4></center>
                <form  action="#" method="post">
             <label for="email"><b>Enter Email</b></label>
                <div class="form-group">

                    <input type="text" class="form-control" id="email" placeholder="Email"   name="email" required/>

                </div>
					<button class="btn btn-primary btn-block purple-bg" type="submit" name="submit">

                    Forgot</button>


                </form>
            </div>

        </div>

    </div>

</div>

</body>

</html>
<?php
if(isset($_POST['submit'])){
$signup_email = filter_var(htmlentities($_POST['email']),FILTER_SANITIZE_STRING);
echo $signup_email;	
$sql = "SELECT * FROM signup WHERE email=:signup_email";
$query = $conn->prepare($sql);
$query->bindParam(':email', $signup_email, PDO::PARAM_STR);
$query->execute($query);
$row_count = $query->rowCount();
    if($row_count < 0){
        echo "email wrong";
    }
else{
 header('location:setpassword.php');
    }       
	
}
?>