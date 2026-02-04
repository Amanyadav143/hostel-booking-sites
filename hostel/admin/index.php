<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!='admin'){
    header("Location: ../login.php");
    exit();
}
?>
<h1>Admin Dashboard</h1>
<p>Welcome, <?php echo $_SESSION['user']['name']; ?></p>
<a href="../logout.php">Logout</a>
