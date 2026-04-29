<?php
session_start();
include "../config/db.php";

$user_id = $_SESSION['user_id'];

// Total requests created by user
$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM requests WHERE user_id='$user_id'");
$total = mysqli_fetch_assoc($total_query)['total'];

// Pending (open)
$pending_query = mysqli_query($conn, "SELECT COUNT(*) as pending FROM requests WHERE user_id='$user_id' AND status='open'");
$pending = mysqli_fetch_assoc($pending_query)['pending'];

// Accepted
$accepted_query = mysqli_query($conn, "SELECT COUNT(*) as accepted FROM requests WHERE user_id='$user_id' AND status='accepted'");
$accepted = mysqli_fetch_assoc($accepted_query)['accepted'];

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Aidify Dashboard</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #eb5707;
}

/* Navbar */
.navbar {
    background: #0f172a;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
}

.navbar a {
    color: #38bdf8;
    text-decoration: none;
}

/* Sidebar */
.sidebar {
    width: 230px;
    height: 100vh;
    background: #020a17;
    position: fixed;
    padding-top: 20px;
}

.sidebar a {
    display: block;
    color: #cbd5f5;
    padding: 12px 20px;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #334155;
    color: white;
}

/* Main */
.main {
    margin-left: 230px;
    padding: 20px;
}

/* Cards */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.card {
    background: pink;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(227, 240, 34, 0.91);
}

.card h3 {
    margin: 0;
}

/* Gradient box */
.welcome {
    background: linear-gradient(to right, #3b82f6, #06b6d4);
    color: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

/* Button */
.btn {
    display: inline-block;
    padding: 10px 15px;
    background: #3b82f6;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    margin-top: 10px;
}
</style>

</head>
 
<body>

<!-- Navbar -->
<div class="navbar">
    <div><b>Aidify</b></div>
    <div>
        👤 <?php echo $_SESSION['user_name']; ?> |
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <a href="#">🏠 Dashboard</a>
    <a href="requests.php">📢 Requests</a>
    <a href="#">🚗 Ride Sharing</a>
    <a href="helper.php">📍 Helpers</a>
    <a href="notifications.php">🔔 Notifications</a>
    <a href="profile.php">👤 Profile</a>
</div>

<!-- Main -->
<div class="main">

    <!-- Welcome -->
    <div class="welcome">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h2>
        <p>Manage your activities in one place</p>
    </div>

    <!-- Grid Sections -->
    <div class="grid">

        <!-- Requests -->
        <div class="card">
            <h3>📢 Requests</h3>
            <p>Total Requests: <?php echo $total; ?></p>
            <p>Pending: <?php echo $pending;?></p>
            <p>Accepted: <?php echo $accepted;?></p>
            <a href="create_request.php" class="btn">Create Request</a><br><br>
            <a href="requests.php" class="btn">View Requests</a><br><br>
            <a href="my_requests.php" class="btn">My Requests</a>
        </div>

        <!-- Ride -->
        <div class="card">
            <h3>🚗 Ride Sharing</h3>
            <p>Available Rides:</p>
            <a href="request_ride.php" class="btn">Request Ride</a><br>
            <a href="offer_ride.php" class="btn">Offer Ride</a><hr><br>
            <a href="all_rides.php" class="btn">View All Rides</a><br>
            <a href="close_rides.php" class="btn">Close Rides</a>
        </div>

        <!-- Helpers -->
        <div class="card">
            <h3>📍 Helpers</h3>
            <p>Available Helpers: </p>
            <a href="helper.php" class="btn">View Helpers</a>
        </div>

        <!-- Notifications -->
        <div class="card">
            <h3>🔔 Notifications</h3>
            <p>New Alerts:</p>
            <p>Someone nearby needs help</p>
            <a href="notification_card.php" class="btn">View All</a>
        </div>

        <!-- Quick Actions -->
        <!-- <div class="card">
            <h3>⚡ Quick Actions</h3>
            <a href="create_request.php" class="btn">Create Request</a><br>
            <a href="#" class="btn">Offer Ride</a><br>
            <a href="#" class="btn">View Notifications</a>
        </div> -->

    </div>

</div>

</body>
</html>
