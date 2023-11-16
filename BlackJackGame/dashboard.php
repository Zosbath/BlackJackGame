<?php
	include_once("configure.php");
	if(!isset($_SESSION['userEmail']) && $_SESSION['userEmail'] == "")
	{		
		header("Location: index.php");
	}
	if(isset($_SESSION['userEmail']) && $_SESSION['userEmail'] != "")
	{
		$users = mysqli_query($con,"SELECT * from users WHERE email = '".$_SESSION['userEmail']."'");
		$row = mysqli_fetch_array($users);
		$playerName = $row['firstname']." ".$row['lastname'];
	}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Dashboard | Blackjack</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="blackjack">
				<div class="textCenter">
					<div class="header">
						<h1>Blackjack</h1>
						<h2>Welcome, <span id="playerName"><?=$playerName;?></span></h2>
						<?php if(isset($_SESSION['userEmail']) && $_SESSION['userEmail'] != "") { ?>
						<a href="leaderboard.php" class="leaderboardBtn">LEADERBOARD</a>
						<a href="logout.php" class="logoutBtn">LOGOUT</a>
						<?php } ?>
					</div>					
					<div class="cards textCenter">
						<img class="cardsImg" src="cards/2-D.png" />
						<img class="cardsImg" src="cards/3-H.png" />
						<img class="cardsImg" src="cards/4-S.png" />
						<img class="cardsImg" src="cards/5-C.png" />
						<img class="cardsImg" src="cards/6-D.png" />
						<img class="cardsImg" src="cards/7-H.png" />
						<img class="cardsImg" src="cards/8-S.png" />
						<img class="cardsImg" src="cards/9-C.png" /><b> - Face Value</b><br/>
						<img class="cardsImg" src="cards/10-D.png" />
						<img class="cardsImg" src="cards/J-H.png" />
						<img class="cardsImg" src="cards/Q-S.png" />
						<img class="cardsImg" src="cards/K-C.png" /><b> - 10</b><br/>
						<img class="cardsImg" src="cards/A-C.png" /><b> - 1 or 11</b><br/>
					</div>
					<a href="gameplay.php" class="playBtn">PLAY</a>
				</div>
			</div>
			<p class="textCenter textWhite">Made by Zeteny Osbath</p>
		</div>
	</div>
</body>
</html>