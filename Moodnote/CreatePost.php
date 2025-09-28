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
        $stInsert.close();
        $conn.close();
    }


?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moodnote - Create Post</title>

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
                <center><h1>Create an entry</h1></center><br>
                <div class="form-group">
                    <input type="text" name="postTitle" placeholder="Title of entry..." required><br><br>
                    <textarea class="form-control" name="postContent" placeholder="How are you feeling right now?" rows="3" required></textarea>
                </div> <br>
                <div class="form-group">
                    <label>What emotion suits this entry best?</label>

                    <select name="postEmotion" style="width: 40%;">
                        <option value="happy">Happy</option>
                        <option value="sad">Sad</option>
                        <option value="angry">Angry</option>
                        <option value="neutral">Neutral</option>
                    </select>

                </div>
                <br>
                <button type="submit" class="btn">Create Post</button>
            </form>
            <button id="back" class="btn" onclick="location.href='ViewEntries.php'">Go Back</button>
    </div>
</body>
</html>