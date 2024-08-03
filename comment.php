<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $author = $conn->real_escape_string($_POST['author']);
    $content = $conn->real_escape_string($_POST['content']);

    $query = "INSERT INTO comments (post_id, author, content) VALUES ('$postId', '$author', '$content')";
    if ($conn->query($query) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
