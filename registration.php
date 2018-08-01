<!DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="style.css"></link>
	</head>
	<script>
	//function for matching of entered password.
	var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = '#00cc00';
    document.getElementById('message').innerHTML = 'MATCHED';
  } else {
    document.getElementById('message').style.color = '#ff0000';
    document.getElementById('message').innerHTML = 'NOT MATCHED';
  }
}


	</script>
	
	
	<body style="background-image:url('white.png')">
	<div class="container">
		<img src="men.png" />
			<form method="post"  >
				<div class="font-input">
					<input type="text" name="username" placeholder="Enter UserName">
				</div>
				<div class="font-input">
					<input type="number_format" name="roll" placeholder="Enter Rollnumber">
				</div>
				<div class="font-input">
					<input type="number_format" name="phone" placeholder="Enter Phonenumber">
				</div>
				<div class="font-input">
				
				<input name="password" id="password" type="password" placeholder="Enter password" />
				</div>
				<div class="font-input">
				
				<input type="password" name="confirm_password" id="confirm_password" placeholder="Re-Enter password" onkeyup='check();' /> <br>
				<span id='message'></span>
				
				</div>
				
				<input type="submit" name="submit" value="Register" class="btn-login" /><br><br>
				<!--<a style="text-decoration:none" id="submit" href="USE.php" class="btn-login">Register</a>
-->
				
			
			</form>
		</div>
	</body>
</html>


<?php

$con = mysqli_connect("localhost","root","","register");
if(isset($_POST['submit'])){
	$user = $_POST['username'];
	$rol = $_POST['roll'];
	$phn = $_POST['phone'];
	$pasd = $_POST['password'];
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_query($con,"insert into registerpage (user_name,roll_no,phone_no,paswd) values ('$user','$rol','$phn','$pasd')") ;
	header("Location:USE.php");
	//if(mysqli_query($query)){
	
	//}
	mysqli_close($con);
}
?>