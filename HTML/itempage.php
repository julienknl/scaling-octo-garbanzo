<?php
include_once "requiredlogin.php";
include_once "../Database/database.php";

$role = $_SESSION["loggedInUser"]["role"];

$disableBuyOption  = strcmp($role, "BUYER") == 0 ? false : true;
$disableSellOption = !$disableBuyOption;

$product_id = $_GET["product"];
$getProductQuery = "Select p.product_description, p.photo_path, p.number_of_reviewers, p.rating  from product p where cod = '$product_id'";

$product = $connection->query($getProductQuery);

$product_description = "";
$product_image       = "";
$product_reviewers   = 0;
$product_rating      = 0;

if($product->num_rows > 0) {
  $row = $product->fetch_assoc();
  $product_description = $row["product_description"];
  $product_image       = $row["photo_path"];
  $product_reviewers   = $row["number_of_reviewers"];
  $product_rating      = $row["rating"];
}

  /*
  * Get the new rating and the stored rating.
  * Add 1 to the number of reviewers then get the average rating for the product and saves the result
  */
if(isset($_POST['rate'])) {
  $submitted_rating = $_POST['rating'];
  $product_reviewers++;
  $rating = bcdiv(($product_rating + $submitted_rating), $product_reviewers, 2);

  $updateQuery = "UPDATE product
                  SET number_of_reviewers =  '$product_reviewers',
                  rating = '$rating'
                  WHERE cod = '$product_id'";
                  
  if($connection->query($updateQuery)) {
    echo "success";
  }
  
  else {
    echo $connection->error;
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
  
  <!-- CSS file-->
  <link rel="stylesheet" href="../CSS/style.css">
  <link rel="stylesheet" href ="../CSS/rating-style.css">
  
  <!-- Jrate -->
  <script src="../bower_components/jRate/src/jRate.js"></script>
  
  <script type="text/javascript" >
    $(document).ready(function() {
      $("#jRate").jRate({
        precision: 0.5,   
        startColor: "yellow",
        endColor: "yellow",
        onChange: function(rating) {
          $("#given_rating").val(rating);
			    $('#current_rating').text("Your Rating: "+rating);
		    }
      });
      
      
    });
  </script>
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
          <form method="post" style="text-align:right; padding:20px;">
             <div id="jRate"></div>
          <span id="current_rating"></span>
          <input type="hidden" id="given_rating" name="rating"/>
            <input type="submit" name="rate" value="Rate"/>
          </form>
         
          <button type="button" class="btn btn-default btn pull-right">Buy</button>
      </div>
      
  </div>
</body>
</html>