<?php
session_start();
include "db.php";
include "csrf.php";    // <-- यो थप्ने
verify_csrf();         // <-- यो थप्ने


if($user_role == "admin") {
    $_SESSION['user'] = [
        'id' => $user_id,
        'name' => $user_name,
        'role' => "admin"
    ];
    header("Location: admin/dashboard.php");
    exit;
}



?>