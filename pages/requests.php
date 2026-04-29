<?php
session_start();
include "../config/db.php";

// ✅ Timezone fix
date_default_timezone_set('Asia/Kolkata');

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 🔥 Auto expire requests
mysqli_query($conn, "
    UPDATE requests 
    SET status = 'expired'
    WHERE request_datetime < NOW() 
    AND status = 'open'
");

// Filter
$type = isset($_GET['type']) ? $_GET['type'] : 'current';

// Queries
if($type == 'all'){
    $query = "SELECT * FROM requests 
              WHERE user_id != '$user_id'
              AND status != 'open'
              ORDER BY created_at DESC";

} elseif($type == 'accepted'){
    $query = "SELECT * FROM requests 
              WHERE accepted_by = '$user_id'
              ORDER BY created_at DESC";

} elseif($type == 'my'){
    $query = "SELECT * FROM requests 
              WHERE user_id = '$user_id'
              ORDER BY created_at DESC";

} else {
    $query = "SELECT * FROM requests 
              WHERE user_id != '$user_id'
              AND status = 'open'
              AND request_datetime >= NOW()
              ORDER BY request_datetime ASC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Requests</title>

<style>
body {
    font-family: 'Segoe UI';
    background: #f1f5f9;
}

.container {
    margin-left: 240px;
    padding: 20px;
}

.btn {
    padding: 8px 15px;
    background: #3b82f6;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    margin-right: 10px;
}

.card {
    background: white;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px;
}

.badge {
    padding: 3px 8px;
    border-radius: 5px;
    color: white;
    font-size: 12px;
}

.immediate { background: red; }
.high { background: orange; }
.medium { background: blue; }
.low { background: green; }
</style>

</head>

<body>

<div class="container">

<h2>Requests</h2>

<div>
    <a href="requests.php?type=current" class="btn">Current</a>
    <a href="requests.php?type=all" class="btn">All</a>
    <a href="requests.php?type=accepted" class="btn <?php if($type=='accepted') echo 'active'; ?>">Accepted by Me</a>
    <a href="requests.php?type=my" class="btn <?php if($type=='my') echo 'active'; ?>">Requested by Me</a>
</div>

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){

        $urgency = strtolower($row['urgency']);
        $request_date = $row['request_datetime'];
?>

<div class="card">

<h3><?php echo $row['title']; ?></h3>

<p><b>Type:</b> <?php echo $row['type']; ?></p>
<p><b>Description:</b> <?php echo $row['description']; ?></p>
<p><b>Location:</b> <?php echo $row['location']; ?></p>

<p>
<b>Urgency:</b> 
<span class="badge <?php echo $urgency; ?>">
    <?php echo ucfirst($urgency); ?>
</span>
</p>

<!-- ✅ FINAL FIX: SHOW DATE ONLY IF NOT IMMEDIATE -->
<?php if($urgency == "immediate"){ ?>
    <p><b>Time:</b> Immediate</p>
<?php } else { ?>
    <p><b>Date:</b> <?php echo date("d M Y, h:i A", strtotime($request_date)); ?></p>
<?php } ?>

<p><b>Status:</b> <?php echo $row['status']; ?></p>

<?php
if($row['status'] == 'open'){

    if($type == 'my'){
        echo "<a href='cancel_request.php?id=".$row['id']."' class='btn' style='background:red;'>Cancel</a>";
    } else {
        echo "<a href='accept_request.php?id=".$row['id']."' class='btn'>Accept</a>";
    }

} elseif($row['status'] == 'accepted'){

    echo "<p style='color:green;'><b>Accepted</b></p>";

} elseif($row['status'] == 'cancelled'){

    echo "<p style='color:red;'><b>Cancelled</b></p>";

} else {

    echo "<p style='color:gray;'><b>Expired</b></p>";

}
?>

</div>

<?php
    }
} else {
    echo "No requests found";
}
?>

</div>

</body>
</html>