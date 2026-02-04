<?php
include "../security.php";
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){
    header("Location: ../index.php");
    exit;
}
include "../db.php";

// Fetch data for widgets
$total_rooms = $conn->query("SELECT COUNT(*) as total FROM rooms")->fetch_assoc()['total'];
$total_bookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$pending_reviews = $conn->query("SELECT COUNT(*) as total FROM reviews WHERE status='pending'")->fetch_assoc()['total'];
$recent_bookings = $conn->query("SELECT b.*, r.name as room_name, u.name as client_name FROM bookings b JOIN rooms r ON b.room_id=r.id JOIN users u ON b.user_id=u.id ORDER BY b.id DESC LIMIT 5");
?>
<?php
session_start(); // Session suru garnu

// Admin permission check
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    // Admin login nagareko bhaye login page ma redirect garnu
    header("Location: ../login.php");
    exit;
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow h-screen p-5">
        <h2 class="text-2xl font-bold mb-5">Admin Panel</h2>
        <ul>
            <li class="mb-2"><a href="dashboard.php" class="hover:text-blue-500 font-bold">Dashboard</a></li>
            <li class="mb-2"><a href="add_room.php" class="hover:text-blue-500">Add Room</a></li>
            <li class="mb-2"><a href="rooms.php" class="hover:text-blue-500">Manage Rooms</a></li>
            <li class="mb-2"><a href="bookings.php" class="hover:text-blue-500">Bookings</a></li>
            <li class="mb-2"><a href="reviews.php" class="hover:text-blue-500">Reviews</a></li>
            <li class="mb-2"><a href="logout.php" class="hover:text-red-500">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-5">Dashboard</h1>

        <!-- Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <div class="flex items-center">
                    <span data-feather="home" class="w-8 h-8 mr-3 text-blue-500"></span>
                    <div>
                        <p class="text-gray-500">Total Rooms</p>
                        <p class="text-2xl font-bold"><?php echo $total_rooms; ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <div class="flex items-center">
                    <span data-feather="users" class="w-8 h-8 mr-3 text-green-500"></span>
                    <div>
                        <p class="text-gray-500">Total Bookings</p>
                        <p class="text-2xl font-bold"><?php echo $total_bookings; ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <div class="flex items-center">
                    <span data-feather="star" class="w-8 h-8 mr-3 text-yellow-500"></span>
                    <div>
                        <p class="text-gray-500">Pending Reviews</p>
                        <p class="text-2xl font-bold"><?php echo $pending_reviews; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <h2 class="text-2xl font-bold mb-5">Recent Bookings</h2>
        <table class="min-w-full bg-white shadow rounded mb-10">
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
            <?php while($b = $recent_bookings->fetch_assoc()): ?>
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
</div>

<script>
    feather.replace()
</script>
</body>
</html>
