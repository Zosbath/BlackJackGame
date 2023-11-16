<?php
	include_once("configure.php");
	if(isset($_SESSION['userEmail']) && $_SESSION['userEmail'] != "")
	{
		header("Location: dashboard.php");
	}
	if(isset($_REQUEST['registerBtn']))
	{
		$firstName = $_POST['firstname'];
		$lastName = $_POST['lastname'];
		$phoneNumber = $_POST['phonenumber'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$cpassword = $_POST['cpassword'];
		$users = mysqli_query($con,"SELECT * from users WHERE email = '".$email."'");
		$usersRow = mysqli_num_rows($users);
		if($usersRow > 0)
		{
			$_SESSION['error'] = "Email Address already registered.<br/>Please try with another Email Address.";
		}
		else
		{
			if($cpassword != $password)
			{
				$_SESSION['error'] = "Password and Confirm Password should be match.";
			}
			else
			{
				$_SESSION['error'] = "";
				mysqli_query($con,"INSERT into users SET firstname = '".$firstName."', lastname = '".$lastName."', phonenumber = '".$phoneNumber."', email = '".$email."', password = '".$password."'");
				header("Location: index.php");
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Register | Blackjack</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="login_form">
				<h1>REGISTER</h1>
				<form name="loginForm" id="loginForm" method="post">
					<input type="text" name="firstname" id="firstname" class="inputValues" placeholder="First Name" required>
					<input type="text" name="lastname" id="lastname" class="inputValues" placeholder="Last Name" required>
					<input type="text" name="phonenumber" id="phonenumber" class="inputValues" placeholder="Phone Number" required>
					<input type="email" name="email" id="email" class="inputValues" placeholder="Email Address" required>
					<input type="password" name="password" id="password" class="inputValues" placeholder="Password" required>
					<input type="password" name="cpassword" id="cpassword" class="inputValues" placeholder="Confirm Password" required>
					<div class="textCenter">
						<input type="submit" name="registerBtn" id="registerBtn" value="REGISTER" class="registerBtn"><br/>
						<a href="index.php" class="loginHere">Already User? Login Here</a>
						<?php if(isset($_SESSION['error']) && $_SESSION['error'] != "") { ?>
						<div class="error"><?=$_SESSION['error']; unset($_SESSION['error']); ?></div>
						<?php } ?>
					</div>
				</form>
			</div>
			<p class="textCenter textWhite">Made by Zeteny Osbath</p>
		</div>
	</div>
</body>
</html>