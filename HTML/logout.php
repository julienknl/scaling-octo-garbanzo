<?PHP

session_start();
unset($_SESSION["loggedInUser"]); 
header("Location: index.php");

?>