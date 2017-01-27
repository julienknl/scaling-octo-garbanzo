<?php
session_start();
$welcomeMessage = "";
if(!$_SESSION["loggedInUser"]) {
	header("Location: login.php");
}
else {
  $welcomeMessage = "Welcome ".$_SESSION["loggedInUser"]["username"];
}
?>
