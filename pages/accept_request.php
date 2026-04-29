<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$request_id = $_GET['id'];

// 🔒 Check if request is still open
$check = mysqli_query($conn, 
    "SELECT * FROM requests WHERE id='$request_id' AND status='open'"
);

if(mysqli_num_rows($check) > 0){

    // ✅ Accept request
    mysqli_query($conn, 
        "UPDATE requests 
         SET status='accepted', accepted_by='$user_id' 
         WHERE id='$request_id'"
    );

    header("Location: requests.php");
} else {
    echo "❌ This request is already accepted!";
}
?>