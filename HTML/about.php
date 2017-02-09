<?php

session_start();

$role = $_SESSION["loggedInUser"]["role"];

$disableBuyOption  = strcmp($role, "BUYER") == 0 ? false : true;
$disableSellOption = !$disableBuyOption;

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

<body style="background-color:white;">
  
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
      <li><a href="review.php">Review</a></li>
      <li class ="active"><a href="about.php">About us</a></li>
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
      <li><a href="review.php">Review</a></li>
      <li class ="active"><a href="about.php">About us</a></li>
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
  
  <!-- About page image cover -->
  <div class="homePageImageCoverContainer">
      <img src="/images/aboutthemcover.png" class="img-fluid" width=100%>
  </div>
  
  <div class="container">
    <div class="col-md-11" style="text-align:left;">
      <h1 style="color:#5A8E3E; padding-top:20px; text-align:left;">Who we are?</h1>
      <p style="font-size:12pt; color:#000000">As NSW just legalized Marijuana/Weed, that is weed farming and selling, we decided to develop a website that will help customers (only the authorized customers by providing a proof) to find a nearby seller or any other region of their choice.</br>
        Marijuafinder focuses on reducing illegal selling of drugs by providing only verified/approved sellers. Usually, when Marijuana are sold illegally, it can be dangerous for the customers as the drug dealers tend to make fake Marijuana that can be fatal for the clients. So Marijuanafinder registered sellers will provide real and good quality of Marijuana.</br>
        Sometime it is quite hard to talk to other people about Marijuana, about the good or any advise of how using the drug. Marijuafinder will provide a discussion page where all the users will be free to communicate about any subject regarding Marijuana.</p>
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
      <div class="col-sm-4">
        <p style="font-size:20px;">Community</p>
        <a href="url" style="color:white;">Facebook</a></br>
        <a href="url" style="color:white;">Twitter</a></br>
        <a href="url" style="color:white;">Instagram</a>
        
        <div class="row" style="padding-top:30px;">
            <a href="url"><img src="/images/socialMediaIconFacebook.png" width="30px"></img></a>
            <a href="url" style="margin-left:10px;"><img src="/images/socialMediaIconTwitter.png" width="30px"></img></a>
            <a href="url" style="margin-left:10px;"><img src="/images/socialMediaIconInstagram.png" width="30px"></img></a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>