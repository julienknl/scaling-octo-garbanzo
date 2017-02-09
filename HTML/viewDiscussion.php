<?php

session_start();

include_once("../Database/database.php");

$current_userid = $_SESSION["loggedInUser"]["uid"];

$discussion_id = $_GET['discussion'];

$getDiscussion = "SELECT d.title, d.description, m.content, u.username from discussion d LEFT JOIN message m ON d.id = m.discussion_id 
                  LEFT JOIN users u ON m.sender = u.id WHERE d.id = '$discussion_id'";
                  

$discussionContent = $connection->query($getDiscussion);

if($discussionContent->num_rows >  0) {
    
    $result = "";
    
    while($row=$discussionContent->fetch_assoc()) {
        $discussionTitle       = $row['title'];
        $discussionDescription = $row['description'];
        $message = $row['content'];
        $sender  = $row['username'];
        $result .= "<div class=\"col-md-12\" style=\"background-color:#E0EDC8; margin-top:10px; padding:20px; text-align:left;\">
                              <b><p>$sender</p></b>
                              <p>$message</p>
                    </div>";
    }
}
else {
    echo "failed to retrieve";
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    
    $insertQuery = "INSERT INTO message(content, discussion_id, sender) VALUES('$message', '$discussion_id', '$current_userid')";
    
     
   if($connection->query($insertQuery)) {
       header('Location: '  .$_SERVER['REQUEST_URI']);
   }
   
   else {
       echo $connection->error;
   }
}

?>


<!DOCTYPE html>
<html>
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap link-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
        <script type="text/javascript">
        function getUpdatedChat() {
            $.ajax({
                    url  : "retrieveMessages.php?discussion=" + $('#discussion').val(),
                    type : "get"
                }).done(function(data){
                    $('#resultSet').append(data);
                });
        }
        
        $(document).ready(function(){
            $('#form').submit(function(event) {
            event.preventDefault();
            var message = $('#message');
                $.ajax({
                    url  : window.location.href,
                    type : "post",
                    data : $('#form').serialize()
                }).done(function(data, status) {
                    getUpdatedChat();
                });
            });
        });
        </script>
    </head>
    <body>
        <div class="container">
        <div class = "row" style="background-color:#5A8E3E;">
            <div class="col-md-12" style="padding:20px;">
                <h1 style="color:white;">Discussion topic</h1>
                <p style="color:white; font-size:16px; font-style:bold;"><?php echo $discussionTitle; ?></p>
                <p style="color:white;"><?php echo $discussionDescription; ?></p>
            </div>
        </div>
        
        <div id="resultSet" class="row" >
            <?php
            echo $result; 
            ?>
        </div>
        <input type="hidden" id="discussion" name="discussion" value=<?php echo $discussion_id ?>>
        <div class="row">

            <form id="form" style="padding-top:20px;">
                <textarea class="form-control" rows="5" name="message" id="message" placeholder="Enter your message" ></textarea>
                <div style="text-align:right;">
                    <button class="btn btn-default" type = "submit" id="submit" style="text-align:right;">Send</button>
                </div>
            </form>
        </div>
        
        </div>
    </body>
</html>