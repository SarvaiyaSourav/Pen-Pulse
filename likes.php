<?php
include 'db.php';

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $userIp = $_SERVER['REMOTE_ADDR'];


    $checkQuery = "SELECT * FROM likes WHERE post_id = $postId AND user_ip = '$userIp'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        
        $likeQuery = "INSERT INTO likes (post_id, user_ip) VALUES ($postId, '$userIp')";
        if ($conn->query($likeQuery) === TRUE) {
            echo "Post liked successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "You have already liked this post.";
    }
}

$conn->close();
header("Location: index.php");
exit;
?>
