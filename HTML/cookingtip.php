<?php

include_once "requiredlogin.php";

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
      <li><a href="review.php">Review</a></li>
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
      
      <li class="active"><a href="cookingtip.php">Tips for cooking</a></li>
      <li><a href="discussion.php">Discussion</a></li>
      <li><a href="review.php">Review</a></li>
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
  
  <!-- Main container -->
  <div class="container" style="background-color:white; padding:30px;">
    
     <!-- Author description -->
  <div class="col-md-3" style="background-color:#E0EDC8; padding-bottom:30px; margin:20px;">
    <h1 style="font-size:20px; color:#000000;">Author</h1>
    <img src="/images/sellerOne.png" alt="">
    <h2 style="font-size:16px; font-style:bold; color:#000000;">About the author</h2>
    <p style="color:#000000;">This author, originated from the United States love to write good articles about Marijuana and it's usage. He likes particularly to visit places where Marijuana is legal and write stories about it. He is also an admin of our website.</p>
  </div>
  
  <!-- Blog post -->
    <div class="col-md-8" style="margin-left:30px">
      <div style="background-color:#E0EDC8; padding:30px; margin:20px;">
        <img src="/images/blogpictureone.png" alt="">
        <h2 style="font-size:16px; font-style:bold; color:#000000;">Making Cannaoil/Cannabutter</h2>
        <p style="color:#000000;">Edibles are a discreet and convenient way to consume cannabis, particularly for those who cannot tolerate smoke.</br>

            Made by infusing cannabis with food, many find that edibles offer a high that is more calm and relaxing than smoking pot. On the other hand, the effects of edibles can be hard to predict and tend to differ between individuals.</br>

            Before sinking your teeth into edibles, do yourself a favor and get to know the facts.</p>
      </div>
      
      <div style="background-color:#E0EDC8; padding:30px; margin:20px;">
        <img src="/images/blogpicturetwo.png" alt="">
        <h2 style="font-size:16px; font-style:bold; color:#000000;">Raw Chocolate Hemp Butter</h2>
        <p style="color:#000000;">This dish made with green hemp butter is stone ground and silky smooth. Chocolate hemp macaroons are chewy and chocolaty with a definite hemp flavor.</p>
        <p style="color:#000000; text-align:left;">3 tablespoons melted raw organic cacao butter</br>

            3 tablespoons coconut cream (thick stuff)</br>
            
            3 tablespoons hemp butter</br>
            
            3 tablespoons warm spring water</br>
            
            1 ½ cups shredded coconut</br>
            
            5 tablespoons raw organic cacao powder</br>
            
            3 tablespoons xylitol, powdered in a coffee grinder</br>
            
            7-8 drops vanilla stevia extract</br>
            
            2 pinches of sea salt</p>
      </div>
      
      <div style="background-color:#E0EDC8; padding:30px; margin:20px;">
        <img src="/images/blogpicturethree.png" alt="">
        <h2 style="font-size:16px; font-style:bold; color:#000000;">Gourmet Hash Oil Chocolate</h2>
        <p style="color:#000000;">Gourmet Hash Oil Chocolate is a basic but delicious chocolate recipe using hash oil to create your own marijuana edible candy bars, cookies and desserts. This is a rich, dark chocolate that stands up on the counter if using Cocao Butter and in the fridge if using coconut oil and pack a wallop if you use strong, activated hash oil.</p>
        <p style="color:#000000; text-align:left;">1 Cup (240 ml) Raw Organic Cacao Butter (Or Coconut oil)</br>
              1 Cup (240 ml) Raw Organic Cacao Powder</br>
              1/2 Cup (120 ml) Maple Syrup</br>
              1 tsp (5 ml) Vanilla Extract</br>
              1/4 Cup (60 ml) Chopped Nuts (Optional)</br>
              10 grams Hash Oil Concentrate *</br>
              pinch of sea salt</p>
      </div>
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