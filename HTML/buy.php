<?php

include_once("requiredlogin.php");
include_once("../Database/database.php");

//Browse the state
if(isset($_POST['state'])) {
 
  $selectedState = $_POST['stateDropdown'];
  $productBystateQuery  = "
  SELECT p.name as productName, p.photo_path, p.cod,  p.product_price, pc.category_name, s.state_name, u.name 
  FROM product p
  JOIN prod_category pc ON p.category = pc.cod
  JOIN state s ON p.state = s.id_state 
  JOIN users u ON p.seller = u.id 
  where s.state_name = '$selectedState'";
  
  $queryResult = $connection->query($productBystateQuery);
  
  if($queryResult->num_rows > 0) {
    $result = "";
    
     while($row=$queryResult->fetch_assoc()) {
      $path         =$row["photo_path"];
      $product_name = $row["productName"];
      $price        = $row["product_price"];
      $category     = $row["category_name"];
      $user_name    = $row["name"];
      $product_id   = $row["cod"];
      $result .= "<div class=\"col-md-3\">
                              <a href = \"itempage.php?product=$product_id \">
                              <img src=$path class=\"img-responsive\">
                              <b><p>$product_name ($category)</p></b>
                              <p>Price A$$price</p>
                              <p>$user_name</p>
                              </a>
                  </div>";
     }
  }
}

//Search for product
if(isset($_POST['search'])) {
  $selectedState = $_POST['stateField'];
  $searchText = $_POST['searchquery'];
  
  $specificProductQuery = "SELECT p.name as productName, p.photo_path, p.cod, p.product_price, pc.category_name, s.state_name, u.name
FROM product p
JOIN prod_category pc ON p.category = pc.cod
JOIN state s ON p.state = s.id_state 
JOIN users u ON p.seller = u.id 
where s.state_name = '$selectedState' and p.name like '%{$searchText}%'";

  $queryResult = $connection->query($specificProductQuery);
  
  if($queryResult->num_rows > 0) {
    $result = "";
    
     while($row=$queryResult->fetch_assoc()) {
      $path         = $row["photo_path"];
      $product_name = $row["productName"];
      $price        = $row["product_price"];
      $category     = $row["category_name"];
      $user_name    = $row["name"];
      $product_id   = $row["cod"];
      $result .= "<div class=\"col-md-3\">
                              <a href = \"itempage.php?product=$product_id \">
                              <img src=$path class=\"img-responsive\">
                              <b><p>$product_name ($category)</p></b>
                              <p>Price A$$price</p>
                              <p>$user_name</p>
                              </a>
                  </div>";
     }
  }
  
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
  <script type="text/javascript">
    $(document).ready(function() {
      $('#search').click(function(event) {
        $('#stateField').val($("#stateDropdown option:selected").text());
      });
    });
  </script>
  
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
          echo '<li class="active"><a href="buy.php">Buy</a></li>';
        }
      ?>
      
      <li><a href="cookingtip.php">Tips for cooking</a></li>
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
    
     <!-- Select place container -->
  <div class="col-md-4" style="background-color:#E0EDC8; padding-bottom:30px;">
    <h1 style="font-size:20px; color:#000000;">Find your item nearby</h1>
    <form action ="buy.php" method = "post">
    <select class="form-control" id ="stateDropdown" name ="stateDropdown" style="margin-bottom:20px;">
      <option value="New South Wales">New South Wales</option>
      <option value="Queensland">Queensland</option>
      <option value="South Australia">South Australia</option>
      <option value="Tasmania">Tasmania</option>
      <option value="Western Australia">Western Australia</option>
      <option value="Victoria">Victoria</option>
    </select>
    <button type="submit" name ="state" class="btn btn-default">Search</button>
    </form>
  </div>
  
  <!-- Search item and list item view -->
  <div class="col-md-7" style="background-color:#E0EDC8; margin-left:30px">
    <h1 style="font-size:20px; color:#000000; text-align:left; padding-left:10px;">Search for your item</h1>
    <div class="row">
      <form action ="buy.php" method ="post">
      <div class="input-group stylish-input-group" style="padding-left:20px; padding-right:20px;">
        <input type="text" class="form-control" name = "searchquery"  placeholder="Search" >
        <input type ="hidden" id="stateField" name ="stateField" >
          <span class="input-group-addon">
            <button type="submit" id="search" name ="search">
              <span class="glyphicon glyphicon-search"></span>
            </button>  
          </span>
      </div>
      </form>
      <div class="row">
      </div>
      
      <div class="row" style="margin-top:30px;">
        <div class="col-md-8 col-md-offset-2">
          <div class="row">
            <?php
            if(isset($result)) {
              echo $result;
            }
            ?>
            </div>
          </div>
      </div>
    </div>
  </div>
  </div>
</div>
  
  <!--Footer section-->
  <div class="container" style="background-color:#232323; margin:0;">
    <div class="row" style="padding-top:20px;">
      <div class="col-md-4" style="text-align:left; padding-left:20px;">
        <img src="/images/marijuafinder.png" style="text-align:left;"></img>
        <p style="color:white; text-align:left; width:210px;">way to get your product! You just need to sign in, select a store nearby and buy your preferable product!</p>
        <a href="url" style="color:white;">Terms and conditions apply</a>
      </div>
      <div class="col-md-4">
        <p style="font-size:20px; color:#5A8E3E">Contact</p>
        <a href="url" style="color:white;">Contact us</a></br>
        <a href="url" style="color:white;">Send us your feedback</a>
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