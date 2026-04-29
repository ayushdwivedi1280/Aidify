
<!DOCTYPE html>
<html>
<head>
<title>Create Request</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #f1f5f9;
}

.container {
    width: 400px;
    margin: 50px auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 12px;
    background: #3b82f6;
    color: white;
    border: none;
    margin-top: 15px;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #2563eb;
}
</style>

</head>

<body>

<div class="container">

<h2>Create Request</h2>

<form method="POST">

<label>Request Type</label>
<select name="type" required>
    <option value="Help">Help</option>
    <option value="Ride">Ride</option>
    <option value="Task">Task</option>
</select>

<label>Title</label>
<input type="text" name="title" placeholder="Enter title" required>

<label>Description</label>
<textarea name="description" placeholder="Describe your request" required></textarea>

<label>Location</label>
<input type="text" name="location" placeholder="Enter location" required>

<label>Urgency</label>
<select name="urgency">
    <option value="Low">Low</option>
    <option value="Medium">Medium</option>
    <option value="High">High</option>
</select>


<label>Request Timing</label>
<select name="timing" id="timing" onchange="toggleDate()" required>
    <option value="Immediate">Immediate</option>
    <option value="Schedule">Schedule</option>
</select>

<div id="dateField" style="display:none;">
    <label>Date & Time</label>
    <input type="datetime-local" name="datetime">
</div>

<button type="submit" name="submit">Create Request</button>

</form>

</div>

<script>
function toggleDate() {
    var timing = document.getElementById("timing").value;
    var dateField = document.getElementById("dateField");

    if (timing === "Schedule") {
        dateField.style.display = "block";
    } else {
        dateField.style.display = "none";
    }
}
</script>

</body>
</html>



<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){

$user_id = $_SESSION['user_id'];
$type = $_POST['type'];
$title = $_POST['title'];
$description = $_POST['description'];
$location = $_POST['location'];
$urgency = $_POST['urgency'];
$timing = $_POST['timing'];

if($timing == "Immediate"){
    // ✅ make request valid for 1 day
    $datetime = date("Y-m-d H:i:s", strtotime("+1 day"));
} else {
    $datetime = $_POST['datetime'];
}

$query = "INSERT INTO requests 
(user_id, type, title, description, location, urgency, request_datetime)
VALUES 
('$user_id','$type','$title','$description','$location','$urgency','$datetime')";

$result = mysqli_query($conn,$query);

if($result){
    echo "<script>alert('Request Created Successfully'); window.location='dashboard.php';</script>";
}else{
    echo "Error";
}

}
?>

