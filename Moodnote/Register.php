<?php
include ("db/config.php"); // Database connection file
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username already exists
    $stCheck = $conn->prepare("SELECT username FROM account WHERE username = ?");
    $stCheck->bind_param("s", $email); // s means String
    $stCheck->execute();
    $stCheck->store_result();

    if ($stCheck->num_rows > 0) { // If theres more than one of the same username, don't register.
        $message = "An account already uses this username. Please try again.";
        echo "<script type='text/javascript'>alert('$message');</script>"; // Give Alert
        header("Refresh:0"); // Refresh page.
    } else {
        // Prepare and bind values to insert account
        $stInsert = $conn->prepare("INSERT INTO account (username, password, email) VALUES (?, ?, ?)");
        $stInsert->bind_param("sss", $username, $password, $email);

        if ($stInsert->execute()) {
            $message = "Account created successfully";
            echo "<script type='text/javascript'>
                alert('$message');
                window.location.href='Login.php';
            </script>";
        } else {
            $message = "Error: " . $stInsert->error;
            echo "<script type='text/javascript'>alert('$message');</script>";
            header("Refresh:0"); // Refresh page.
        }

        $stInsert->close();
    }

    $stCheck->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register to Moodnote</title>

    <link rel="stylesheet" href="Style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


    <!--Bootstrap man-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <center><h1>Sign Up</h1></center>
        <form id="register-form" action="" method="post">
            <div class="input-box">
                    <i class='bx bx-user'></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
            <div class="input-box">
                <i class='bx bx-envelope'></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                    <i class='bx bx-lock'></i>
                    <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>

            <br></br>
            <p>Already have an account?<br>
                <button type="button" class="btn btn-link" onclick="location.href='Login.php'">Login</button>
            </p>
        </form>
    </div>

</body>