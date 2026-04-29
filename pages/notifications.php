<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch accepted requests created by user
$query = "SELECT r.*, u.name AS accepter_name 
          FROM requests r
          LEFT JOIN users u ON r.accepted_by = u.id
          WHERE r.user_id='$user_id' 
          AND r.status='accepted'
          ORDER BY r.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>

    <style>
        body {
            font-family: 'Segoe UI';
            background: #f1f5f9;
        }

        .container {
            width: 500px;
            margin: 50px auto;
        }

        .card {
            background: #d1fae5;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            border-left: 5px solid green;
        }
    </style>
</head>

<body>

<div class="container">

<h2>Notifications</h2>

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>

<div class="card">
    <strong><?php echo $row['title']; ?></strong><br>

    <?php if($row['type'] == 'Ride'){ ?>
        Your ride was booked by <b><?php echo $row['accepter_name']; ?></b>
    <?php } else { ?>
        Your request was accepted by <b><?php echo $row['accepter_name']; ?></b>
    <?php } ?>
</div>

<?php
    }
} else {
    echo "No notifications";
}
?>

</div>

</body>
</html>