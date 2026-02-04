<?php
include "../security.php";
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){
    header("Location: ../index.php");
    exit;
}
include "../db.php";
$bookings = $conn->query("SELECT b.*, r.name as room_name, u.name as client_name FROM bookings b JOIN rooms r ON b.room_id=r.id JOIN users u ON b.user_id=u.id ORDER BY b.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold mb-5">All Bookings</h1>
    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Client</th>
                <th class="py-2 px-4 border">Room</th>
                <th class="py-2 px-4 border">Phone</th>
                <th class="py-2 px-4 border">Status</th>
                <th class="py-2 px-4 border">Booking Date</th>
            </tr>
        </thead>
        <tbody>
        <?php while($b = $bookings->fetch_assoc()): ?>
            <tr class="text-center border-b hover:bg-gray-100 transition">
                <td class="py-2 px-4"><?php echo $b['id']; ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($b['client_name']); ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($b['room_name']); ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($b['phone']); ?></td>
                <td class="py-2 px-4"><?php echo ucfirst($b['status']); ?></td>
                <td class="py-2 px-4"><?php echo $b['booking_date']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
