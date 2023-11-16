<?php
	include_once("configure.php");
	if(isset($_SESSION['userEmail']) && $_SESSION['userEmail'] != "")
	{
		header("Location: dashboard.php");
	}
	if(isset($_REQUEST['loginBtn']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		$users = mysqli_query($con,"SELECT * from users WHERE email = '".$email."'");
		$usersRow = mysqli_num_rows($users);
		if($usersRow == 0)
		{
			$_SESSION['error'] = "Email Address does not exist.<br/>Please Register your account.";
		}
		else
		{
			$users = mysqli_query($con,"SELECT * from users WHERE email = '".$email."' and password = '".$password."'");
			$usersRow = mysqli_num_rows($users);
			if($usersRow == 0)
			{
				$_SESSION['error'] = "Password Incorrect.";
			}
			else
			{
				$row = mysqli_fetch_array($users);
				$_SESSION['userEmail'] = $row['email'];
				header("Location: dashboard.php");
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Login | Blackjack</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="login_form">
				<h1>LOGIN</h1>
				<form name="loginForm" id="loginForm" method="post">
					<input type="email" name="email" id="email" class="inputValues" placeholder="Email Address" required>
					<input type="password" name="password" id="password" class="inputValues" placeholder="Password" required>
					<div class="textCenter">
						<input type="submit" name="loginBtn" id="loginBtn" value="LOGIN" class="loginBtn"><br/>
						<a href="register.php" class="registerHere">New User? Sign Up Here</a>
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