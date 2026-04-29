<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch users who accepted your requests
$query = "
SELECT DISTINCT u.* 
FROM requests r
JOIN users u ON r.accepted_by = u.id
WHERE r.user_id = '$user_id' 
AND r.status = 'accepted'
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>People Who Helped Me</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f1f5f9;
    margin: 0;
}

.container {
    width: 800px;
    margin: 40px auto;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.card {
    display: flex;
    align-items: center;
    background: white;
    padding: 15px;
    margin-bottom: 12px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.profile-img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
}

.details {
    flex: 1;
}

.details h3 {
    margin: 0;
}

.details p {
    margin: 4px 0;
    color: #555;
}

.badge {
    background: #22c55e;
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
}

.no-data {
    text-align: center;
    color: #777;
}
</style>

</head>

<body>

<div class="container">

<h2>🤝 People Who Helped Me</h2>

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="card">

    <!-- Profile Image -->
    <?php if(!empty($row['profile_pic'])){ ?>
        <img src="/aidify1/uploads/<?php echo $row['profile_pic']; ?>" class="profile-img">
    <?php } else { ?>
        <img src="https://img.icons8.com/ios-filled/100/000000/user.png" class="profile-img">
    <?php } ?>

    <!-- Details -->
    <div class="details">
        <h3><?php echo $row['name']; ?></h3>
        <p>📧 <?php echo $row['email']; ?></p>
        <p>📞 <?php echo $row['phone']; ?></p>
    </div>

    <!-- Tag -->
    <div class="badge">Accepted Your Request</div>

</div>

<?php } ?>

<?php } else { ?>

<p class="no-data">No one has accepted your requests yet</p>

<?php } ?>

</div>

</body>
</html>