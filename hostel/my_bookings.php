<?php
session_start();
include "db.php";
include "security.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$user_name = htmlspecialchars($_SESSION['user']['name']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<div class="bg-white shadow mb-6">
    <div class="container mx-auto flex justify-between items-center p-5">
        <h1 class="text-2xl font-bold">My Bookings</h1>
        <div>
            <span class="mr-4 font-semibold"><?php echo $user_name; ?></span>
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Logout</a>
        </div>
    </div>
</div>

<div class="container mx-auto p-5">
    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border">Booking ID</th>
                <th class="py-2 px-4 border">Room</th>
                <th class="py-2 px-4 border">Phone</th>
                <th class="py-2 px-4 border">Message</th>
                <th class="py-2 px-4 border">Status</th>
                <th class="py-2 px-4 border">Booking Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $bookings = $conn->query("SELECT b.*, r.name as rname FROM bookings b JOIN rooms r ON b.room_id=r.id WHERE b.user_id=$user_id ORDER BY b.id DESC");
        while($b = $bookings->fetch_assoc()):
        ?>
            <tr class="text-center border-b hover:bg-gray-100 transition">
                <td class="py-2 px-4"><?php echo $b['id']; ?></td>
                <td class="py-2 px-4 font-semibold"><?php echo htmlspecialchars($b['rname']); ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($b['phone']); ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($b['message']); ?></td>
                <td class="py-2 px-4"><?php echo ucfirst($b['status']); ?></td>
                <td class="py-2 px-4"><?php echo $b['booking_date']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    feather.replace()
</script>
</body>
</html>
