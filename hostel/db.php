<?php
$host = "localhost";
$user = "root";
$pass = "YourNewPassword";
$db = "hostel";

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Database Connection Failed");
}else{
    // echo "database connection sucessful";
}
?>
