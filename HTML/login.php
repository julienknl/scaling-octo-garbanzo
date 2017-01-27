<!-- php login -->
<?php
session_start();
include_once "../Database/database.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $usernameError = "";
    $passwordError = "";
    
    $error = false;
    $databaseStatus = "";
    $message;
    
    
    if(empty($username)) {
        $error = true;
        $usernameError = "Please enter your username";
    }
    
    if(empty($password)) {
        $error = true;
        $passwordError = "Please enter your password";
    }
    
    if(!$error) {
        $login_query = "Select u.id, u.username, u.email, r.role from users u join role r on u.role = r.role_id
        where username = '$username' AND password = '$password'";
        
        $result = $connection->query($login_query);
        
        
        if($result->num_rows > 0 ) {
          $row                      = $result->fetch_assoc();
          $id                       = $row["id"];
          $email                    = $row["email"];
          $username                 = $row["username"];
          $role                     = $row["role"];
          $message                  = "success";
          $_SESSION['loggedInUser'] = array("username"=>$username, "email"=>$email, "role" =>$role, "uid" =>$id);
          
          header("Location: index.php");
        }
        else {
            $message =  "Something went wrong in the database";
        }
    }
    else {
        $message =  "error on fields";
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
</head>

<body style="background-color:#232323;">

<div class="container" style="background-color:#232323; text-align:center; padding-top:70px;">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form">
        <form  action="login.php"method="post" style="padding:10px;">
          <img src="/images/marijuafinder.png" style="align-item:center; padding:5px;">
          <input type="text" name="username" placeholder="Username" required class="form-control input-lg" style="margin-top:5px;">
          
          <input type="password" class="form-control input-lg" id="password" placeholder="Password" name="password" style="margin-top:5px;">
          
          
          <div class="pwstrength_viewport_progress"></div>
          
          
          <button type="submit" name="login" class="btn btn-lg btn-primary btn-block" style="background-color:#5A8E3E; border:0; margin-top:10px;">Sign in</button>
          <div>
            <a href="register.php" style="color:white;">Reset password</a>
          </div>
          
           <?php 
            if(isset($message)) {
            echo '<span>'.$message.'</span>';
              }
          ?>
        </form>
      </section>  
      </div>
  </div>
</div>

</body>
</html>