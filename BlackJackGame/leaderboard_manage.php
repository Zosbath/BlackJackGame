<?php
include_once("configure.php");
if(!isset($_SESSION['userEmail']) && $_SESSION['userEmail'] == "")
{
	header("Location: index.php");
}
else
{
	$pscore = $_POST['pscore'];
	$dscore = $_POST['dscore'];
	$winner = $_POST['winner1'];
	mysqli_query($con,"INSERT into leaderboard SET playerscore = '".$pscore."', dealerscore = '".$dscore."', winner = '".$winner."', dateandtime = '".date("Y-m-d h:i:s")."'");
}
?>