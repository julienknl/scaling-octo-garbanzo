  <?php
      $welcomeMessage = "";
      if(!$_SESSION["loggedInUser"]) {
  ?>
    <ul class="nav navbar-nav">
      <li class ="active"> ><a href="index.php">Home</a></li>
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
      <li class="active"><a href="index.php">Home</a></li>
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