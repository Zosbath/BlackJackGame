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
<title>Blackjack</title>
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
						<a href="dashboard.php" class="dashboardBtn">DASHBOARD</a>
						<a href="leaderboard.php" class="leaderboardBtn">LEADERBOARD</a>
						<a href="logout.php" class="logoutBtn">LOGOUT</a>
						<?php } ?>
					</div>
				</div>
				<div class="gamecards">
					<div class="rowCards">
						<h1>DEALER</h1>
						<div class="dealerCards" id="dealerCards"></div>
						<h3 class="scorecard" id="dealerS">Dealer's Score - <span id="dealerScore"></span></h3>
					</div>
					<hr/>
					<div class="rowCards">
						<h1>PLAYER</h1>
						<div class="playerCards" id="playerCards"></div>
						<h3 class="scorecard" id="playerS">Player's Score - <span id="playerScore"></span></h3>
					</div>
					<hr/>
					<div class="allBtns">
						<button class="hitMeBtn" id="hitMeBtn">HIT</button>
						<button class="standBtn" id="standBtn">STAND</button>
						<button class="dealBtn" id="dealBtn">DEAL</button>
					</div>
					<div class="result" id="result"></div>
				</div>
			</div>
			<p class="textCenter textWhite">Made by Zeteny Osbath</p>
		</div>
	</div>
	<script src="jquery.min.js"></script>
	<script>
	let dealerScore = 0, playerScore = 0, playerCard, dealerCard, cardIndex;
	document.getElementById("dealerScore").innerHTML = dealerScore;
	document.getElementById("playerScore").innerHTML = playerScore;
	let hitMeBtn = document.getElementById("hitMeBtn");
	let standBtn = document.getElementById("standBtn");
	
	hitMeBtn.disabled = true;
	standBtn.disabled = true;
	hitMeBtn.style.opacity = "0.6";
	standBtn.style.opacity = "0.6";
	let cardNames = ['A-C','2-C','3-C','4-C','5-C','6-C','7-C','8-C','9-C','10-C','J-C','Q-C','K-C','A-D','2-D','3-D','4-D','5-D','6-D','7-D','8-D','9-D','10-D','J-D','Q-D','K-D','A-H','2-H','3-H','4-H','5-H','6-H','7-H','8-H','9-H','10-H','J-H','Q-H','K-H','A-S','2-S','3-S','4-S','5-S','6-S','7-S','8-S','9-S','10-S','J-S','Q-S','K-S'];
	let cardPoints = ['11','2','3','4','5','6','7','8','9','10','10','10','10','11','2','3','4','5','6','7','8','9','10','10','10','10','11','2','3','4','5','6','7','8','9','10','10','10','10','11','2','3','4','5','6','7','8','9','10','10','10','10'];
	let dealBtn = document.getElementById("dealBtn");
	dealBtn.addEventListener("click",function(){
		newDeal();
	});
	function newDeal()
	{
		document.getElementById('dealerCards').innerHTML = "";
		document.getElementById('playerCards').innerHTML = "";
		document.getElementById('result').innerHTML = "";
		document.getElementById('result').style.display = "none";
		dealerScore = 0, playerScore = 0;
		cardNames = ['A-C','2-C','3-C','4-C','5-C','6-C','7-C','8-C','9-C','10-C','J-C','Q-C','K-C','A-D','2-D','3-D','4-D','5-D','6-D','7-D','8-D','9-D','10-D','J-D','Q-D','K-D','A-H','2-H','3-H','4-H','5-H','6-H','7-H','8-H','9-H','10-H','J-H','Q-H','K-H','A-S','2-S','3-S','4-S','5-S','6-S','7-S','8-S','9-S','10-S','J-S','Q-S','K-S'];
		cardPoints = ['11','2','3','4','5','6','7','8','9','10','10','10','10','11','2','3','4','5','6','7','8','9','10','10','10','10','11','2','3','4','5','6','7','8','9','10','10','10','10','11','2','3','4','5','6','7','8','9','10','10','10','10'];
		hitMeBtn.style.opacity = "1";
		standBtn.style.opacity = "1";
		hitMeBtn.addEventListener("click",function(){
			hitMe();
		});
		standBtn.addEventListener("click",function(){
			hitDealer();
		});
		dealerCard = cardNames[Math.floor(Math.random() * cardNames.length)];
		cardIndex = cardNames.indexOf(dealerCard);
		document.getElementById('dealerCards').innerHTML = "<img src='cards/"+dealerCard+".png' />";
		cardNames.splice(cardIndex,1);
		dealerScore = cardPoints[cardIndex];
		document.getElementById('dealerScore').innerHTML = dealerScore;
		cardPoints.splice(cardIndex,1);
		for(let i = 0; i < 2; i++)
		{
			playerCard = cardNames[Math.floor(Math.random() * cardNames.length)];
			cardIndex = cardNames.indexOf(playerCard);
			document.getElementById('playerCards').innerHTML += "<img src='cards/"+playerCard+".png' />";
			playerScore = playerScore + parseInt(cardPoints[cardIndex]);
			cardNames.splice(cardIndex,1);
			cardPoints.splice(cardIndex,1);
		}
		document.getElementById('playerScore').innerHTML = playerScore;
		if(playerScore == 21)
		{
			document.getElementById('result').style.display = "inline-block";
			document.getElementById('result').innerHTML = "You Win. You have blackjack!";
			document.getElementById('result').style.backgroundColor = "darkgreen";
			resetButtons();
			winner = "player";
			addToLeaderboard();
		}
		else
		{
			hitMeBtn.disabled = false;
			standBtn.disabled = false;
			dealBtn.disabled = true;
			dealBtn.style.opacity = "0.6";
		}
	}
	function hitMe()
	{
		playerScore = document.getElementById('playerScore').innerHTML;
		if(playerScore < 21)
		{
			playerCard = cardNames[Math.floor(Math.random() * cardNames.length)];
			cardIndex = cardNames.indexOf(playerCard);
			document.getElementById('playerCards').innerHTML += "<img src='cards/"+playerCard+".png' />";
			playerScore = parseInt(playerScore) + parseInt(cardPoints[cardIndex]);
			document.getElementById('playerScore').innerHTML = playerScore;
			cardNames.splice(cardIndex,1);
			cardPoints.splice(cardIndex,1);
			if(playerScore > 21)
			{
				document.getElementById('result').style.display = "inline-block";
				document.getElementById('result').innerHTML = "You Lost. Your score is "+playerScore;
				document.getElementById('result').style.backgroundColor = "red";
				resetButtons();
				dealerScore = document.getElementById('dealerScore').innerHTML;
				dealerCard = cardNames[Math.floor(Math.random() * cardNames.length)];
				cardIndex = cardNames.indexOf(dealerCard);
				document.getElementById('dealerCards').innerHTML += "<img src='cards/"+dealerCard+".png' />";
				dealerScore = parseInt(dealerScore) + parseInt(cardPoints[cardIndex]);
				document.getElementById('dealerScore').innerHTML = dealerScore;
				winner = "dealer";
				addToLeaderboard();
			}
		}
	}
	function hitDealer()
	{
		hitMeBtn.disabled = true;
		dealerScore = document.getElementById('dealerScore').innerHTML;
		playerScore = document.getElementById('playerScore').innerHTML;		
		if(dealerScore <= 16)
		{
			dealerCard = cardNames[Math.floor(Math.random() * cardNames.length)];
			cardIndex = cardNames.indexOf(dealerCard);
			document.getElementById('dealerCards').innerHTML += "<img src='cards/"+dealerCard+".png' />";
			dealerScore = parseInt(dealerScore) + parseInt(cardPoints[cardIndex]);
			document.getElementById('dealerScore').innerHTML = dealerScore;
			hitMe();
		}
		else if(dealerScore > 16 && dealerScore <= 21)
		{
			if(dealerScore > playerScore)
			{
				document.getElementById('result').style.display = "inline-block";
				document.getElementById('result').innerHTML = "You Lost. Dealer score is "+dealerScore;
				document.getElementById('result').style.backgroundColor = "red";
				resetButtons();
				winner = "dealer";
				addToLeaderboard();
			}
			else if(dealerScore == playerScore)
			{
				document.getElementById('result').style.display = "inline-block";
				document.getElementById('result').innerHTML = "Game Tie. Both scores are "+dealerScore;
				document.getElementById('result').style.backgroundColor = "darkblue";
				resetButtons();
				winner = "tie";
				addToLeaderboard();
			}
			else
			{
				document.getElementById('result').style.display = "inline-block";
				document.getElementById('result').innerHTML = "You Win. Your score is "+playerScore;
				document.getElementById('result').style.backgroundColor = "darkgreen";
				resetButtons();
				winner = "player";
				addToLeaderboard();
			}
		}
		else
		{
			document.getElementById('result').style.display = "inline-block";
			document.getElementById('result').innerHTML = "You Win. Dealer score is "+dealerScore;
			document.getElementById('result').style.backgroundColor = "darkgreen";
			resetButtons();
			winner = "player";
			addToLeaderboard();
		}
	}
	function addToLeaderboard()
	{
		$.ajax({
			type: 'POST',
			url: 'leaderboard_manage.php',
			dataType: 'json',
			data: {
				pscore: playerScore,
				dscore: dealerScore,
				winner1: winner
			},
			success: function (data) { }
		});
	}
	function resetButtons()
	{
		hitMeBtn.disabled = true;
		standBtn.disabled = true;
		dealBtn.disabled = false;
		hitMeBtn.style.opacity = "0.6";
		standBtn.style.opacity = "0.6";
		dealBtn.style.opacity = "1";
	}
	</script>
</body>
</html>