<?php
include("db.php");
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $author = $conn->real_escape_string($_POST['author']);

    $query = "UPDATE posts SET title='$title', content='$content' ,author='$author' WHERE id=$id";
    $result = $conn->query($query);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        die("Update failed: " . $conn->error);
    }
}

$conn->close();
?>
