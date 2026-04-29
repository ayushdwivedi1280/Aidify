<?php
session_start();
include "../config/db.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    mysqli_query($conn, "
    UPDATE requests 
    SET status='accepted', accepted_by='$user_id' 
    WHERE id='$id' AND user_id != '$user_id'
    ");

    header("Location: close_rides.php");
}
?>