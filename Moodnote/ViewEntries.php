<?php
//continue the session assuming one was started at login
session_start();

if($conn->connect_error)
    {
         die("Connection failed:" .$conn->connect_error);
    }



$servername="localhost";
$username="root";
$password="";
$dbname="moodnote_database";

$conn=new mysqli($servername,$username,$password,$dbname);

//get the account id of the logged-in user
$accountID=$_SESSION['acc_id'];

//query to extract data from the 2nd table
$sql="SELECT post_data,post_emotion,post_id,post_title FROM posts WHERE acc_id=$acc_id";
$result=$conn->query($sql);

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your all entries</title>

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
        <h2 style="text-align: left;font-size: 25px;">Choose an entry you want to view</h2>
        <br>
        <div class="icon-container">
            <?php
            if($result=num_rows>0)
            {
                while($row=$result->fetch_assoc())
                {
                    $entryid=$row['post_id'];
                    $entryhead= htmlspecialchars($row['entryhead']);
                    echo" 
                    <form action='viewmodifyentry.php' method='get'>
                    <button class='iconbtn' type='submit'>
                    <img src='img/Noteicons.jpg' alt='$entryhead'>
                    <span>$entryhead</span>
                    </button>
                    </form>";
                }
              
            }
            else
            {
                echo"<p>no entries found<p>";
            }
            ?>
      
    </div>
</body>
</html>

<?php
$conn->close();
?>