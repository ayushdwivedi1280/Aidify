<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM requests 
          WHERE type='Ride' 
          AND ride_mode='request'
          AND user_id != '$user_id'
          AND status='open'
          ORDER BY request_datetime ASC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ride Requests</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            margin: 0;
        }

        .container {
            width: 700px;
            margin: 40px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-top: 0;
            color: #333;
        }

        .card p {
            margin: 5px 0;
            color: #555;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn:hover {
            background: #2563eb;
        }

        .no-data {
            text-align: center;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="container">

<h2>🚗 Ride Requests (Accept Rides)</h2>

<?php if(mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

        <div class="card">
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            <p><b>Location:</b> <?php echo $row['location']; ?></p>
            <p><b>Date:</b> <?php echo date("d M Y, h:i A", strtotime($row['request_datetime'])); ?></p>

            <a href="accept_ride.php?id=<?php echo $row['id']; ?>" class="btn">
                Accept Ride
            </a>
        </div>

    <?php } ?>

<?php } else { ?>

    <p class="no-data">No ride requests available</p>

<?php } ?>

</div>

</body>
</html>