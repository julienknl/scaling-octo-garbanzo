<?php
include_once "requiredlogin.php";
include_once "../Database/database.php";

$role = $_SESSION["loggedInUser"]["role"];

$disableBuyOption  = strcmp($role, "BUYER") == 0 ? false : true;
$disableSellOption = !$disableBuyOption;

$product_id = $_GET["product"];
$getProductQuery = "Select p.product_description, p.photo_path  from product p where cod = '$product_id'";

$product = $connection->query($getProductQuery);

$product_description = "";
$product_image       = "";

if($product->num_rows > 0) {
  $row = $product->fetch_assoc();
  $product_description = $row["product_description"];
  $product_image       = $row["photo_path"];
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
  <div class="container" style="background-color:white; padding-top:50px;">
      <div class="col-md-3">
          <img src=<?php echo $product_image ?>></img>
      </div>
      <div class="col-md-8" style="background-color:#E0EDC8; padding-bottom:20px;">
          <h1 style="text-align:left;">Description</h1>
          <p style="text-align:left;"><?php echo $product_description ?></p>
          <button type="button" class="btn btn-default btn pull-right">Buy</button>
      </div>
  </div>
</body>
</html>