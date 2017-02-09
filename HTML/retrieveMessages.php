<?php 
include_once("../Database/database.php");

$discussion_id = $_GET['discussion'];
$retrieveMessages = "SELECT m.content, u.username from message m JOIN users u ON m.sender = u.id 
                     where discussion_id=" . $discussion_id ." ORDER BY m.id DESC LIMIT 1";

$messages = $connection->query($retrieveMessages);

if($messages->num_rows > 0) {
    $result = "";
    while($row = $messages->fetch_assoc()) {
        $message = $row['content'];
        $sender = $row['username'];
        $result .= "<div class=\"col-md-12\" style=\"background-color:#E0EDC8; margin-top:10px; padding:20px; text-align:left;\">
                              <b><p>$sender</p></b>
                              <p>$message</p>
                    </div>";
    }
    
    echo $result;
}

?>