<?php
	include_once("configure.php");
	if(!isset($_SESSION['userEmail']) && $_SESSION['userEmail'] == "")
	{		
		header("Location: index.php");
	}
	else
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
<title>Leaderboard | Blackjack</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="blackjack">
				<div class="textCenter">
					<div class="header">
						<h1>Leaderboard</h1>
						<h2>Welcome, <span id="playerName"><?=$playerName;?></span></h2>
						<?php if(isset($_SESSION['userEmail']) && $_SESSION['userEmail'] != "") { ?>
						<a href="dashboard.php" class="dashboardBtn">DASHBOARD</a>
						<a href="leaderboard.php" class="leaderboardBtn">LEADERBOARD</a>
						<a href="logout.php" class="logoutBtn">LOGOUT</a>
						<?php } ?>
					</div>
				</div>
				<div class="leaderboard textCenter">
					<table id="leaderboard" cellpadding="5" cellspacing="5">
						<tr>
							<th>Player Score</th>
							<th>Dealer Score</th>
							<th>Winner</th>
							<th>Date and Time</th>
						</tr>
						<?php
						$results = mysqli_query($con,"SELECT * from leaderboard order by id DESC");
						while($rows = mysqli_fetch_array($results))
						{
						?>
						<tr>
							<td><?=$rows['playerscore'];?></td>
							<td><?=$rows['dealerscore'];?></td>
							<td><?=$rows['winner'];?></td>
							<td><?=$rows['dateandtime'];?></td>
						</tr>
						<?php
						}
						?>
					</table>
				</div>
			</div>
			<p class="textCenter textWhite">Made by Zeteny Osbath</p>
		</div>
	</div>
</body>
</html>