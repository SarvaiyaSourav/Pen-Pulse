<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT * FROM posts WHERE id = $id");
    $post = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $author = $conn->real_escape_string($_POST['author']);

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Post updated successfully";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="styles.css">

    <style>
body {
    font-family: "Times New Roman", Times, serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center; 
    background-color: black; 
    padding: 20px 20px; 
}


nav h1 {
    color: #fff; 
    font-family: 'Times New Roman', Times, serif;
    font-size: 40px;
    margin: 0; 
}


nav ul {
    list-style-type: none; 
    margin: 0;
    padding: 0; 
    display: flex;
    font-family: 'Times New Roman', Times, serif;
    
}


nav ul li {
    margin-left: 20px; 
    padding-bottom: 5px;
    
}


nav ul li a {
    color: #fff; 
    text-decoration: none; 
    font-size: 20px; 
}


nav ul li a:hover {
    color: yellow;
}

main {
    padding: 20px;
}

form {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
}

form label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

form input[type="text"],
form textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

form textarea {
    resize: vertical;
}

form button {
    background-color: black;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
    font-family: "Times New Roman", Times, serif;
}

form button:hover {
    background-color: white;
    color: black;
    border: 1px solid black;
}

footer {
    background-color: black;
    color: white;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
}

    </style>
</head>
<body>
<nav>
      <h1>My Blog</h1>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="create.php">Create Post</a></li>
      </ul>
    </nav>

    <main>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="10" required><?php echo $post['content']; ?></textarea>

            <label for="author">Title:</label>
            <input type="text" id="author" name="author" value="<?php echo $post['author']; ?>" required>

            <button type="submit" name="submit">Update Post</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Pen Pulse. All rights reserved.</p>
    </footer>
</body>
</html>
