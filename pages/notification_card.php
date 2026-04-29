<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    return; // stop execution if not logged in
}

$user_id = $_SESSION['user_id'];
?>

<?php
// Fetch latest 3 notifications
$notif_query = mysqli_query($conn, "
SELECT r.*, u.name AS accepter_name 
FROM requests r
LEFT JOIN users u ON r.accepted_by = u.id
WHERE r.user_id='$user_id' 
AND r.status='accepted'
ORDER BY r.created_at DESC 
LIMIT 3
");

// Count total notifications
$count_query = mysqli_query($conn, "
SELECT COUNT(*) as total 
FROM requests 
WHERE user_id='$user_id' AND status='accepted'
");

$notif_count = mysqli_fetch_assoc($count_query)['total'];
?>

<style>
.notification-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 12px rgba(0,0,0,0.1);
}

.notification-card h3 {
    margin-bottom: 10px;
}

.notification-count {
    font-weight: bold;
    color: #ef4444;
    margin-bottom: 10px;
}

.notification-item {
    background: #f1f5f9;
    padding: 8px;
    border-radius: 6px;
    margin-bottom: 6px;
    font-size: 14px;
}

.notification-item b {
    color: #2563eb;
}

.view-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    background: #3b82f6;
    color: white;
    border-radius: 6px;
    text-decoration: none;
}

.view-btn:hover {
    background: #2563eb;
}
</style>

<div class="notification-card">

    <h3>🔔 Notifications</h3>

    <div class="notification-count">
        New Alerts: <?php echo $notif_count; ?>
    </div>

    <?php if(mysqli_num_rows($notif_query) > 0){ ?>

        <?php while($row = mysqli_fetch_assoc($notif_query)){ ?>
            
            <div class="notification-item">
                
                <?php if($row['type'] == 'Ride'){ ?>
                    🚗 Ride booked by <b><?php echo $row['accepter_name']; ?></b>
                <?php } else { ?>
                    📌 Request accepted by <b><?php echo $row['accepter_name']; ?></b>
                <?php } ?>

            </div>

        <?php } ?>

    <?php } else { ?>
        <div class="notification-item">No new notifications</div>
    <?php } ?>

    <a href="notifications.php" class="view-btn">View All</a>

</div>