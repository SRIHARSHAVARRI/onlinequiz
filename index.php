<!DOCTYPE html>
<html>
	<head>
		<title>SRIHARSHA.VARRI</title>
		<link rel="stylesheet" type="text/css" href="style.css"></link>
	</head>

	<body style="background-image:url('https://media.giphy.com/media/xT9IgN8YKRhByRBzMI/giphy.gif')">
	<center><h2 style="color:#fff;font-size:50px;">WELCOME TO COMPUTERQUIZ</h2></center>
		<div class="container">
			<img src="men.png" />
			<form method="post" >
				<div class="font-input">
					<input type="text" name="username" placeholder="Enter Name">
				</div>
				<div class="font-input">
					<input type="password" name="password" placeholder="Enter Password">
				</div>
				<input type="submit" name="submit" value="Login" class="btn-login"><br></br><br></br>
				
				<a style="text-decoration:none" href="registration.php" class="btn-login">NEW USER REGISTER HERE</a>
			</form>
		</div>
	</body>
</html>


<?php
session_start();
$con = mysqli_connect("localhost","root","","register");

if(isset($_POST['submit'])){
	$user = $_POST['username'];
	$psd = $_POST['password'];
	$_SESSION['var']=$user;
	$_SESSION['userid']=id;
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$result="SELECT id FROM registerpage WHERE user_name = '$user' and paswd = '$psd'";
	$dummy = mysqli_query($con,$result);
	if(mysqli_num_rows($dummy) > 0)
	{
					header("Location:questions.php");
	}
	else
	{
		echo "details do not match!!!!";

	}
	
	//if(mysqli_query($query)){
	
	//}
	mysqli_close($con);
}
?>