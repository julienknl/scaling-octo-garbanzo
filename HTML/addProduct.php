<?php
  include_once("requiredlogin.php");
  include_once("../Database/database.php");
  $categoriesQuery = "select * from prod_category";
  $statesQuery     = "select * from state";
  
  
  $categories = $connection->query($categoriesQuery);
  $categoryOptions = "";
  if($categories->num_rows > 0) {
    while($row = $categories->fetch_assoc()) {
      $categoryOptions .= '<option value =' . $row["cod"] . ">" . $row["category_name"] . "</option>"; 
    }
  }
  
  $states = $connection->query($statesQuery);
  $stateOptions = "";
  if($states->num_rows > 0) {
    while($row = $states->fetch_assoc()) {
      $stateOptions .=  '<option value =' . $row["id_state"] . ">" . $row["state_name"] . "</option>";
    }
  } 
  
  if(isset($_POST['addProduct'])) {
    $product_name        = $_POST['productName'];
    $product_description = $_POST['productDescription'];
    $product_price       = floatval($_POST['productPrice']);
    $selected_category   = $_POST['categoryDropdown'];
    $selected_state      = $_POST['stateDropdown'];
    $seller_id           = $_SESSION["loggedInUser"]["uid"];
    
    $insertProductQuery  = "INSERT INTO product(name, product_description, category, product_price, state, seller)
                           VALUES ('$product_name', '$product_description', '$selected_category', {$product_price}, '$selected_state', '$seller_id')";
     
    if($connection->query($insertProductQuery)) {
      echo "success";
    }
    
    else {
      echo "failure";
    }
    
  }
  
  
  //---------handle image upload for profile picture
  //set directory where image will be stored
  $item_image_dir = "additem";
  if($_FILES["profile_image_upload"]["name"]){
    $imageerrors = array();
    //get the name of the file
    $file = $_FILES["profile_image_upload"]["name"];
    //get name only without extension
    $filename = pathinfo($file,PATHINFO_FILENAME);
    //get the file extension
    $filextension = pathinfo($file,PATHINFO_EXTENSION);
    //check the file extension, only allow png,jpg,jpeg and gif
    if(strtolower($filextension)!="png"
    && strtolower($filextension)!="jpg"
    && strtolower($filextension)!="jpeg"
    && strtolower($filextension)!="png")
    {
      $errors["image_type"] = "only jpg,jpeg,png or gif allowed";
    }
    //create a unique name for the image and append the extension
    $newfilename = strtolower($filename).uniqid().".".$filextension;
    //rename the file
    $_FILES["profile_image_upload"]["name"] = $newfilename;
    //check file size against limit of 1MB
    if($_FILES["profile_image_upload"]["size"]>10240000){
      $errors["image_size"] = "1MB limit exceeded";
    }
    //check if file is an image
    if(!getimagesize($_FILES["profile_image_upload"]["tmp_name"])){
      $errors["image_file"] = "file is not an image"; 
    }
    //check if there are no errors
    if(!count($errors)>0){
      //move image to profile dir
      move_uploaded_file($_FILES["profile_image_upload"]["tmp_name"], $profile_image_dir."/".$newfilename);
      //add imagename to update query
      $updatequery = $updatequery.",profile_image='$newfilename'";
    }
    else{
      print_r($errors);
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

<body style="background-color:white;">
<div class="container" style="background-color:white;">

		<h2>Add your product</h2>

<form method="post" action ="addProduct.php" class="form-horizontal">
      
<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Product name</label>  
  <div class="col-md-4">
  <input id="textinput" name="productName" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Description</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="textarea" name="productDescription"></textarea>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Price</label>  
  <div class="col-md-4">
  <input id="textinput" name="productPrice" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">Upload image</label>
  <div class="col-md-4">
    <input id="filebutton" name="filebutton" class="input-file" type="file">
  </div>
</div>

    <!-- Select place container -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="categoryDropdown">State</label> 
      <div class="col-md-4">
        <select class="form-control" id ="categoryDropdown" name ="categoryDropdown" style="margin-bottom:20px;">
          <?php echo $categoryOptions ?>
        </select>
      </div>
  </div>

    <!-- Select place container -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="stateDropdown">State</label> 
      <div class="col-md-4">
        <select class="form-control" id ="stateDropdown" name ="stateDropdown" style="margin-bottom:20px;">
          <?php echo $stateOptions ?>
        </select>
      </div>
  </div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="addProduct" class="btn btn-success">add</button>
  </div>
</div>

</fieldset>
</form>

    
</div>
</body>
</html>