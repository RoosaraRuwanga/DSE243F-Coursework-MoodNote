<?php
include ("db/config.php"); // Database connection file
//continue the session assuming one was started at login
session_start();

//get the account of the logged-in user
$username=$_SESSION['username'];

//query to extract data from the 2nd table
$stPosts= $conn->prepare("SELECT post_content, post_emotion, post_id, post_title FROM posts WHERE username=?");
$stPosts->bind_param("s", $username);
$stPosts->execute();

function getPostInformation($postID) {
  echo $postID;
}

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your posts</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="Style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .iconbtn
        {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            border: none;
            background: transparent;
            flex-direction: column;
        }
        .iconbtn img
        {
        width:50px;
        height:50px;
        object-fit:contain;
        }
        .iconbtn:hover
        {
            transform:scale(0.95);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All entries</h1>
        <br>
        <button id="back" class="btn" onclick="location.href='CreatePost.php'">Create New Post</button>
        <button id="back" class="btn" onclick="location.href='Statistics.php'">View Statistics</button>
        <br>
        <br>
        <div class="icon-container">
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
      
    </div>

    <script type="text/javascript">
        function getPost(){
            var php = <?php getPostInformation('1')?>
        }
    </script>
</body>
</html>
