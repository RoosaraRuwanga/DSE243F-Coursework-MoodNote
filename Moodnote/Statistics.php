<?php
  include ("db/config.php"); // Database connection file
  //continue the session assuming one was started at login
  session_start();

  //get the account of the logged-in user
  $username=$_SESSION['username'];

  //query to extract data from the 2nd table
  $stPosts= $conn->prepare("SELECT post_emotion, post_id FROM posts WHERE username=?");
  $stPosts->bind_param("s", $username);
  $stPosts->execute();
  $result = $stPosts->get_result();

  $noHappy = 0;
  $noAngry = 0;
  $noSad = 0;
  $noNeutral = 0;

  // Get the total count of emotions from all posts
  // too bad the graph/progress bar has to get cut though for the sake of time
  if ($result->num_rows > 0){
    while ($row = mysqli_fetch_assoc($result)){
      $emotion = $row['post_emotion'];
      
      if($emotion === "happy"){
        ++$noHappy;
      }
      else if($emotion === "angry"){
        ++$noAngry;
      }
      else if($emotion === "sad"){
        ++$noSad;
      }
      else if($emotion === "neutral"){
        ++$noNeutral;
      }

  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodnote - Statistics</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="Style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Internal CSS-->
     <style>
    .stats-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 16px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: linear-gradient(#fff, #fff1db);
      border-radius: 10px;
      padding: 18px;
      box-shadow: 0px 4px 15px rgba(0,0,0,0.15);
      text-align: center;
    }

    .stat-card .emoji {
      font-size: 28px;
      display: block;
      margin-bottom: 8px;
    }

    .stat-chart {
        width: 90%;
        max-width: 700px;
        margin: 0 auto 40px auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-chart canvas {
        width: 100% !important;
        height: 400px !important;
    }
     </style>

</head>
<script src="https://unpkg.com/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    const moodData = {
        labels: ['Happy', 'Sad', 'Angry', 'Neutral'],
        datasets: [{
            label: 'Number of Posts',
            data: [20, 5, 3, 7],
            backgroundColor: [
                '#FFD700', // Happy - Yellow
                '#1E90FF', // Sad - Blue
                '#FF4500', // Angry - Red
                '#32CD32'  // Neutral - Green
            ],
            borderRadius: 8
        }]
    };

    const config = {
        type: 'bar',
        data: moodData,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Mood Statistics',
                    font: { size: 18 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    };

    // Render chart
    new Chart(document.getElementById('moodChart'), config);
</script>
<body>
    <div class="container">
        <center><h1>Statistics</h1></center>
        <div class="stats-cards">
      <div class="stat-card" style="background: linear-gradient( #12a56dff, #00ff62ff);">
        <span class="emoji">😀</span>
        <h2 id="statHappy">20</h2>
        <p>Happy</p>
      </div>

      <div class="stat-card" style="background: linear-gradient( #796fffff, #b2e7ffff);">
        <span class="emoji">😢</span>
        <h2 id="statSad">5</h2>
        <p>Sad</p>
      </div>
      
      <div class="stat-card" style="background: linear-gradient( #a51212ff, #ff6161ff);">
        <span class="emoji">😠</span>
        <h2 id="statAngry">3</h2>
        <p>Angry</p>
      </div>

      <div class="stat-card" style="background: linear-gradient( #ffd7b7ff, #d8ffe7ff);">
        <span class="emoji">😐</span>
        <h2 id="statNeutral">7</h2>
        <p>Neutral</p>
      </div>
        </div>
      <button id="back" class="btn" onclick="location.href='ViewEntries.php'">Go Back</button>

      
      <script type="text/javascript">
        // Get all of the stats
        document.getElementById("statHappy").innerHTML = getStat(0);
        document.getElementById("statSad").innerHTML = getStat(1);
        document.getElementById("statAngry").innerHTML = getStat(2);
        document.getElementById("statNeutral").innerHTML = getStat(3);
        
        function getStat(num){
          if(num == 0){stat = <?php echo $noHappy?>;}
          if(num == 1){stat = <?php echo $noSad?>;}
          if(num == 2){stat = <?php echo $noAngry?>;}
          if(num == 3){stat = <?php echo $noNeutral?>;}

          return stat;
        }
    </script>
</body>
</html>