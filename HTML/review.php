<?php
include_once("../Database/database.php");

session_start();

$role = $_SESSION["loggedInUser"]["role"];

$disableBuyOption  = strcmp($role, "BUYER") == 0 ? false : true;
$disableSellOption = !$disableBuyOption;

$getProductByRating = "SELECT p.name, p.photo_path, p.product_description, p.rating  from product p order by p.rating DESC";

$retrievedProducts = $connection->query($getProductByRating);

$result = "";

if($retrievedProducts->num_rows > 0) {
  while($row=$retrievedProducts->fetch_assoc()) {
    $name        = $row["name"];
    $photo_path  = $row["photo_path"];
    $description = $row["product_description"];
    $rating      = $row["rating"];
    $result     .= "<div class=\"col-md-2\">
                              <img src=$photo_path class=\"img-responsive\">
                              <b><p>$name</p></b>
                              <p>Rating $rating/5.0</p>
                              <hr>
                  </div>";
    
  }
}
else {
  echo $connection->error;
}

?>

<!DOCTYPE html>
<html lang="en">
  
<head>
  <title>Marijuafinder</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap link-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <!-- CSS file-->
  <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
  
  <!-- Navigation bar section -->
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <img src="/images/marijuafinder.png" alt="" width="100px">
      </a>
    </div>
    
      <?php
      $welcomeMessage = "";
      if(!$_SESSION["loggedInUser"]) {
      ?>
      
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li class="disabled"><a href="buy.php">Buy</a></li>
      <li class="disabled"><a href="cookingtip.php">Tips for cooking</a></li>
      <li class="disabled"><a href="discussion.php">Discussion</a></li>
      <li class="active"><a href="review.php">Review</a></li>
      <li><a href="about.php">About us</a></li>
    </ul>
    
    <ul class="nav navbar-nav navbar-right" style="color:white;">
    <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
    
    <?php
      }
      else{
        $welcomeMessage = "Welcome ".$_SESSION["loggedInUser"]["username"];
    ?>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      
      <?php 
        if($disableBuyOption) {
          echo '<li class="disabled"><a>Buy</a></li>';
        }
        else {
          echo '<li><a href="buy.php">Buy</a></li>';
        }
      ?>
      
      <li><a href="cookingtip.php">Tips for cooking</a></li>
      <li><a href="discussion.php">Discussion</a></li>
      <li class="active"><a href="review.php">Review</a></li>
      <li><a href="about.php">About us</a></li>
    </ul>
    
    
    <ul class="nav navbar-nav navbar-right" style="color:white;">
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" class="caret"></span><?php echo $welcomeMessage ?></a>
          <ul class="dropdown-menu">
            <?php 
            if(!$disableSellOption) {
                echo '<li><a href="addProduct.php">Sell product</a></li>';
            }
            ?>
          </ul>
      </li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" style="margin-left:30px;"></span> Logout</a></li>
    </ul>
    
    <?php
      }
    ?>
   
  </div>
  </nav>
  
  <h1 style="padding:50px; background-color:white;">Product Review</h1>
  
  <div class="container">
    <div class="row" style="padding:30px;">
      <?php echo $result ?>
    </div>
  </div>
  
    <!--Footer section-->
  <div class="container" style="background-color:#232323;">
    <div class="row" style="padding-top:20px;">
      <div class="col-sm-4" style="text-align:left; padding-left:20px;">
        <img src="/images/marijuafinder.png" style="text-align:left;"></img>
        <p style="color:white; text-align:left; width:210px;">way to get your product! You just need to sign in, select a store nearby and buy your preferable product!</p>
        <a href="url" style="color:white;">Terms and conditions apply</a>
      </div>
      <div class="col-sm-4">
        <p style="font-size:20px;">Contact</p>
        <a href="contactform.php" style="color:white;">Contact us</a></br>
        <a href="feedbackform.php" style="color:white;">Send us your feedback</a>
      </div>
      <div class="col-md-4">
        <p style="font-size:20px;">Community</p>
        <a href="https://www.facebook.com/" style="color:white;">Facebook</a></br>
        <a href="https://www.twitter.com/" style="color:white;">Twitter</a></br>
        <a href="https://www.instagram.com/" style="color:white;">Instagram</a>
        
        <div class="row" style="padding-top:30px;">
            <a href="https://www.facebook.com/"><img src="/images/socialMediaIconFacebook.png" width="30px"></img></a>
            <a href="https://www.twitter.com/" style="margin-left:10px;"><img src="/images/socialMediaIconTwitter.png" width="30px"></img></a>
            <a href="https://www.instagram.com/" style="margin-left:10px;"><img src="/images/socialMediaIconInstagram.png" width="30px"></img></a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>