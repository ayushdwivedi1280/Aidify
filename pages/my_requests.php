<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// filter category
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

if($category == 'ride'){
    $query = "SELECT * FROM requests WHERE user_id='$user_id' AND type='Ride' ORDER BY created_at DESC";
}
elseif($category == 'help'){
    $query = "SELECT * FROM requests WHERE user_id='$user_id' AND type='Help' ORDER BY created_at DESC";
}
elseif($category == 'task'){
    $query = "SELECT * FROM requests WHERE user_id='$user_id' AND type='Task' ORDER BY created_at DESC";
}
else{
    $query = "SELECT * FROM requests WHERE user_id='$user_id' ORDER BY created_at DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Requests</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f1f5f9;
    margin: 0;
}

.container {
    width: 750px;
    margin: 40px auto;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* FILTER BUTTONS */
.filters {
    text-align: center;
    margin-bottom: 20px;
}

.filters a {
    text-decoration: none;
    margin: 5px;
    padding: 8px 14px;
    background: #3b82f6;
    color: white;
    border-radius: 6px;
    font-size: 14px;
}

.filters a:hover {
    background: #2563eb;
}

/* CARD */
.card {
    background: white;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.card h3 {
    margin-top: 0;
}

.card p {
    margin: 6px 0;
    color: #555;
}

/* STATUS COLORS */
.status {
    font-weight: bold;
}

.status.open { color: orange; }
.status.accepted { color: green; }
.status.cancelled { color: red; }
.status.expired { color: gray; }

/* ICON STYLE */
.icon {
    margin-right: 5px;
}

/* EMPTY */
.no-data {
    text-align: center;
    color: #777;
}
</style>

</head>

<body>

<div class="container">

<h2>📋 My Requests</h2>

<div class="filters">
    <a href="my_requests.php">All</a>
    <a href="my_requests.php?category=ride">🚗 Ride</a>
    <a href="my_requests.php?category=help">🤝 Help</a>
    <a href="my_requests.php?category=task">📌 Task</a>
</div>

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="card">

    <h3><?php echo $row['title']; ?></h3>

    <p><span class="icon">📂</span><b>Type:</b> <?php echo $row['type']; ?></p>
    <p><span class="icon">📝</span><?php echo $row['description']; ?></p>
    <p><span class="icon">📍</span><?php echo $row['location']; ?></p>

    <p>
        <span class="icon">📊</span>
        <b>Status:</b> 
        <span class="status <?php echo $row['status']; ?>">
            <?php echo ucfirst($row['status']); ?>
        </span>
    </p>

    <?php
    if($row['status'] == 'accepted'){

        $acc_id = $row['accepted_by'];
        $acc_q = mysqli_query($conn, "SELECT name FROM users WHERE id='$acc_id'");
        $acc_user = mysqli_fetch_assoc($acc_q);

        if($row['type'] == 'Ride'){
            echo "<p style='color:green;'>🚗 Ride Booked By: <b>".$acc_user['name']."</b></p>";
        } else {
            echo "<p style='color:green;'>✔ Handled By: <b>".$acc_user['name']."</b></p>";
        }
    }
    ?>

</div>

<?php } ?>

<?php } else { ?>

<p class="no-data">No requests found</p>

<?php } ?>

</div>

</body>
</html>