<?php
include ("db/config.php"); // Database connection file
//continue the session assuming one was started at login
session_start();

//get the account of the logged-in user
$username=$_SESSION['username'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $postTitle = $_POST['postTitle'];
        $postContent = $_POST['postContent'];
        $postEmotion = $_POST['postEmotion'];

        $stInsert = $conn->prepare("INSERT INTO posts (username, post_title, post_content, post_emotion) VALUES (?, ?, ?, ?)");
        $stInsert->bind_param("ssss", $username, $postTitle, $postContent, $postEmotion);

        if ($stInsert->execute()) {
            $message = "Post created successfully";
            echo "<script type='text/javascript'>
                alert('$message');
                window.location.href='ViewEntries.php';
            </script>";
        }
        else {
            $message = "Error: " . $stInsert->error;
            echo "<script type='text/javascript'>alert('$message');</script>";
            header("Refresh:0"); // Refresh page.
        }
        $stInsert->close();
    }


?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moodnote - Delete Post</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="Style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Internal CSS-->
     <style>
        label{
            display:inline-block;
            width:400px;
            margin-right:2px;
            text-align:left;
            }
     </style>
</head>
<body>
    <div class="container">
         <div class="form-group">
            <form action="" method="post">
                <br>
                <center><h1>Do you wish to delete this post?</h1></center><br>
                <?php
                $result = $stPosts->get_result();
                if($result->num_rows > 0){
                    while ($row = mysqli_fetch_assoc($result))
                        {
                            $entryid=$row['post_id'];
                            $entryhead= htmlspecialchars($row['post_title']);
                            echo" 
                            <div class='container' style='background: linear-gradient( #ffe8e5ff, #ffe6e3ff);'>
                                <h3 name='postTitle'>".$row['post_title']."</h3>
                                <p name='postContent'>".$row['post_content']."</p>
                                <p name='postEmotion'>Emotion : ".$row['post_emotion']."</p>
                                <button style='background: linear-gradient(#ff2200ff, #700d00ff);' class='btn'>Delete Post</button>
                            </div>";
                        }
                    }
                    else
                        {
                            echo"<p>No entries found.<p>";
                        }
                    ?>
                <button type="submit" class="btn">Create Post</button>
            </form>
            <button id="back" class="btn" onclick="location.href='ViewEntries.php'">Go Back</button>
    </div>
</body>
</html>