<?php

session_start();

if(isset($_SESSION["loggedInUser"]) != "" ) {
	header("Location: index.php");
}

include_once "../Database/database.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name   			  = $_POST['name'];
	$email  			  = $_POST['email'];
	$username			  = $_POST['username'];
	$password			  = $_POST['password'];
	$confirmPassword      = $_POST['confirm'];
	$error				  = false;
	$errorType			  = "";
	$nameError			  = "";
	$emailError 		  = "";
	$passwordError  	  = "";
	$passwordConfirmError = "";
	$databaseStatus;
	
	if(empty($name)) {
		$nameError = "please enter your name";
		$error = true;
	}
	
	if(!empty($email)) {
		$query_email_check = "SELECT email FROM users WHERE email='$email'";
		 $result = $connection->query($query_email_check);
		 
		  if($result->num_rows>0){
    			//if there is a result in database
    			$error = true;
    			$emalError = "email address has already been used";
		 }
	}

	if(strlen($password) < 8) {
		$passwordError = "please enter a password which is at least 8 characters in length"; 
		$error = true;
	}
	
	if(strcmp($password, $confirmPassword) != 0) {
		$confirmPassword = "Passwords do not match, please try again";
		$error = true;
	}
	
	
	if(!$error) {
		//Buyer's role
		$defaultRole = 0;
		$register_query = "INSERT INTO users(name, username, password, email, role) VALUES ('$name', '$username', '$password', '$email', $defaultRole)";
		
		if($connection->query($register_query)) {
			$user_id = mysqli_insert_id($connection);
			$_SESSION['loggedInUser'] = array("username"=>$username,"email"=>$email, "role" => "BUYER", "uid" => $user_id);
			$errorType			     = "success";
			$databaseStatus = "Successfully registered";
			header("Location: index.php");
		}
		else {
			$errorType      = "danger";
			$databaseStatus = "Please try again later";
		}
	}
	else {
			$errorType      = "danger";
			$databaseStatus = "Somethign went wrong";
			
	}
	
	
	
	
	
}
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">

		<!-- Website CSS style -->
		<link rel="stylesheet" href="../CSS/style.css">

		<!-- Website Font style -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

		<title>Register</title>
	</head>
	<body style="background-color:#232323;">
		<div class="container" style="background-color:#232323; padding-top:20px;">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<img src="/images/marijuafinder.png"></img>
	               		<hr />
	               	</div>
	            </div> 
				<div class="main-login main-center">
					<form class="form-horizontal" action="register.php" method="post" >
						<?php
						  if(isset($databaseStatus)) {	
						?>
						 <div class="form-group">
             <div class="alert alert-<?php echo ($errorType=="success") ? "success" : $errTyp; ?>">
    			<span class="glyphicon glyphicon-info-sign"></span> <?php echo $databaseStatus; ?>
                </div>
             </div>
						
						<?php
						  }
						?>
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
									<span class="text-danger"><?php echo $nameError; ?></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
									<span class="text-danger"><?php echo $emailError; ?></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username"/>
									<span class="text-danger"><?php echo $usernameError; ?></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
									<span class="text-danger"><?php echo $passwordError; ?></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
									<span class="text-danger"><?php echo $passwordConfirmError; ?></span>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-lg btn-block login-button" value ="register">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	</body>
</html>