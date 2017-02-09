<?php
session_start();

include_once "../Database/database.php";


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    
    $insertDiscussionQuery = "INSERT INTO discussion(title, description)
                              VALUES('$title', '$description')";
                              
                              
    if($connection->query($insertDiscussionQuery)) {
        header("Location: discussion.php");
    }
    else {
        echo $connection->error;
    }
    
}

?>

<!DOCTYPE html>
<html>
    <body>
        <form action="addDiscussion.php" method="post">
            <div class="form-group">
							<label for="title" class="cols-md-4 control-label">Title</label>
							<div class="cols-md-2">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="title" id="title"  placeholder="Title"/>
								</div>
							</div>

						<div class="form-group">
							<label for="description" class="cols-md-4 control-label">Description</label>
							<div class="cols-md-2">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<textarea name="description" class="form-control" id="description"></textarea>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-lg btn-block login-button" value ="createDiscussion">Create</button>
						</div>
        </form>
    </body>
</html>