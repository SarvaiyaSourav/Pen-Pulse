<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog Post</title>
    
    <style>
body {
    font-family: 'Times New Roman', Times, serif;
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
        font-family: "Times New Roman", Times, serif;
        font-size: 40px;
        margin: 0;
      }

      nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        font-family: "Times New Roman", Times, serif;
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


.create-post {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
}

.create-post h2 {
    margin-top: 0;
}

.create-post label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

.create-post input[type="text"],
.create-post textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.create-post textarea {
    resize: vertical;
}

.create-post button {
    font-family: 'Times New Roman', Times, serif;
    background-color: black;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
}

.create-post button:hover {
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
      <h1>Pen Pulse</h1>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="create.php">Create Post</a></li>
      </ul>
    </nav>

    <main>
        <section class="create-post">
            <h2>Create New Post</h2>
            <form action="create.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="1" cols="50" required></textarea>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>

                <input type="hidden" name="createdat" value="<?php echo date('Y-m-d H:i:s'); ?>">

                <button type="submit" name="createpost">Create Post</button>
            </form>
        </section>

        <section class="blog-posts">
            <?php
            include("db.php");

            if (isset($_POST['createpost'])) {
                $title = $_POST["title"];
                $content = $_POST["content"];
                $author = $_POST["author"];
                $createdat = $_POST["createdat"];

                $query = "INSERT INTO posts (title, content, author, createdat) VALUES ('$title', '$content', '$author', '$createdat')";
                $createpost = mysqli_query($conn, $query);

                if ($createpost) {
                    echo "Post inserted successfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 My Blog Platform. All rights reserved.</p>
    </footer>
</body>
</html>
