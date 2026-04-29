 <?php

mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect("localhost" , "root" , "" ,"aidify1")
or die("Error: Can't connect to database " . mysqli_connect_errno() . ' - ' . mysqli_connect_error());

?>  



<!-- $host = "localhost";
$user = "root";
$password = "";
$database = "aidify_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} -->





