<?php
session_start();
include "../config/db.php";

if(isset($_GET['id'])){
    $ride_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Update ride status
    $query = "UPDATE requests 
              SET status='accepted', accepted_by='$user_id'
              WHERE id='$ride_id' AND user_id != '$user_id' AND status='open'";

    mysqli_query($conn, $query);

    header("Location: all_rides.php");
}
?>