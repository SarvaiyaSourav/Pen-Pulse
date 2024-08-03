<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Blog Platform</title>
    <link rel="stylesheet" href="styles.css" />
    <style>

      body {
        line-height: 1.6;
        margin: 0;
        padding: 0;
        font-family: "Times New Roman", Times, serif;
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

      main {
        max-width: 800px;
        background: #fff;
      }

      .blog-posts {

      }

      article{
          padding: 20px;
      }

      article h2{
        font-size: 60px;
        margin: 0;
      }

      article p{
        font-size: 18px;
        text-align: justify;
        margin-right: 10%;
      }

      article blockquote{
        font-size:20px;
        font-style: italic;
      }

      article hr{
        width: 95%;
        margin-right: 10%;
      }

      .post {
        margin-bottom: 2rem;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
      }

      .post h2 {
        font-size: 40px;
      }

      .post .meta {
        font-size: 40px;
        color: #777;
      }

      .edit,
      .delete {
        display: inline-block;
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        color: white;
        background: #333;
        text-decoration: none;
        border-radius: 5px;
        font-family: "Times New Roman", Times, serif;
      }

      .edit {
        background: black;
      }

      .delete {
        background: black;
      }

      .edit:hover,
      .delete:hover {
        background: white;
        border: 1px solid black;
        color: black;
      }

      .like {
        background: black;
        color: white;
        padding: 12px;
        border-radius: 5px;
        text-decoration: none;
      }

      .edit:hover,
      .delete:hover,
      .like:hover {
        background: white;
        border: 1px solid black;
        color: black;
      }

      .liked {
        color: red;
        font-weight: bold;
      }

      .actions {
        margin-top: 1rem;
      }

      form {
        margin-top: 1rem;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
      }

      form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
      }

      form input[type="text"],
      form textarea {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
      }

      form button {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        background: #333;
        color: white;
        font-family: "Times New Roman", Times, serif;
        font-size: 16px;
      }

      form button:hover {
        background: white;
        color: black;
        border: 1px solid black;
      }

      footer {
        text-align: center;
        padding: 1rem 0;
        background: black;
        color: white;
      }
    </style>
  </head>
  <body>
    <nav>
      <h1>PenPulse</h1>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="create.php">Create Post</a></li>
      </ul>
    </nav>

    <main>
      <section class="blog-posts">
        <?php
            include("db.php");

            $query = "SELECT * FROM posts ORDER BY createdat DESC";
            $result = $conn->query($query);

            if (!$result) {
                die("Query failed: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<article>";
                    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                    echo "<hr>";
                    echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
                    echo "<blockquote>-" . htmlspecialchars($row['author']) . "</blockquote>";
                    echo "<small>Posted on: " . htmlspecialchars($row['createdat']) . "</small>";
                    echo "<hr>";

                    $postId = $row['id'];
                    $commentsQuery = "SELECT * FROM comments WHERE post_id = $postId ORDER BY createdat DESC";
                    $commentsResult = $conn->query($commentsQuery);
                    if ($commentsResult === false) {
                        die("Error executing query: " . $conn->error);
                    }
                    
                    if ($commentsResult->num_rows > 0) {
                        while ($comment = $commentsResult->fetch_assoc()) {
                            echo "<p><strong>" . htmlspecialchars($comment['author']) . ":</strong> " . nl2br(htmlspecialchars($comment['content'])) . "</p>";
                        }
                    } else {
                        echo "<p>No comments yet.</p>";
                    }

                    
                    echo "<form action='comment.php' method='post'>";
                    echo "<input type='hidden' name='post_id' value='$postId'>";
                    echo "<label for='comment_author'>Your Name:</label>";
                    echo "<input type='text' id='comment_author' name='author' required>";
                    echo "<label for='comment_content'>Comment:</label>";
                    echo "<textarea id='comment_content' name='content' rows='3' required></textarea>";
                    echo "<button type='submit'>Add Comment</button>";
                    echo "</form>";

                    
                    $userIp = $_SERVER['REMOTE_ADDR'];
                    $likeQuery = "SELECT * FROM likes WHERE post_id = $postId AND user_ip = '$userIp'";
                    $likeResult = $conn->query($likeQuery);
                    $liked = $likeResult->num_rows > 0;

                    echo "<div class='actions'>";
                    echo "<a class='edit' href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
                    echo "<a class='delete' href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this post?');\">Delete</a>";

                    if ($liked) {
                        echo " | <span class='liked'>Liked</span>";
                    } else {
                        echo " | <a class='like' href='likes.php?id=" . $row['id'] . "'>Like</a>";
                    }

                    echo "</div>";
                    echo "</article>";
                }
            } else {
                echo "<p>No posts available.</p>";
            }

            $result->free();
            $conn->close();
            ?> 
      </section>
    </main>

    <footer>
      <p>&copy; 2024 My Blog Platform. All rights reserved.</p>
    </footer>
  </body>
</html>
