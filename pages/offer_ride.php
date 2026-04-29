<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $datetime = $_POST['datetime'];

    $query = "INSERT INTO requests 
    (user_id, type, ride_mode, title, description, location, urgency, request_datetime)
    VALUES 
    ('$user_id','Ride','offer','$title','$description','$location','Medium','$datetime')";

    mysqli_query($conn,$query);

    echo "<script>alert('Ride Offered Successfully'); window.location='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Offer Ride</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            margin: 0;
        }

        .container {
            width: 400px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        textarea {
            resize: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3b82f6;
            color: white;
            border: none;
            margin-top: 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #2563eb;
        }
    </style>
</head>

<body>

<div class="container">

<h2>Offer Ride</h2>

<form method="POST">

<input type="text" name="title" placeholder="Ride Title" required>

<textarea name="description" placeholder="Ride details" required></textarea>

<input type="text" name="location" placeholder="Location" required>

<input type="datetime-local" name="datetime" required>

<button name="submit">Offer Ride</button>

</form>

</div>

</body>
</html>