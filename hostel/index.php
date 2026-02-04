<?php
session_start();
include "db.php";
$user_name = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['name']) : 'Guest';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hostel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<div class="bg-white shadow mb-6">
    <div class="container mx-auto flex justify-between items-center p-5">
        <h1 class="text-2xl font-bold">Hostel Booking</h1>
        <div>
            <?php if(isset($_SESSION['user'])): ?>
                <span class="mr-4 font-semibold"><?php echo $user_name; ?></span>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Logout</a>
            <?php else: ?>
                <a href="login.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Login</a>
                <a href="register.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded ml-2">Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container mx-auto p-5">
    <h2 class="text-2xl font-bold mb-6">Available Rooms</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $rooms = $conn->query("SELECT * FROM rooms ORDER BY id DESC");
        while($r = $rooms->fetch_assoc()):
        ?>
        <div class="bg-white rounded shadow hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            <img src="uploads/<?php echo $r['image']; ?>" class="w-full h-48 object-cover rounded-t">
            <div class="p-4">
                <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($r['name']); ?></h3>
                <p class="text-gray-700 mb-1">Price: Rs <?php echo $r['price']; ?></p>
                <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($r['description']); ?></p>
                <div class="flex items-center mb-3">
                    <?php
                    $rating = isset($r['rating']) ? intval($r['rating']) : 0;
                    for($i=1;$i<=5;$i++){
                        if($i <= $rating){
                            echo '<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.2 12.18 0 7.91l6.061-.545L10 2l3.939 5.365L20 7.91l-5.2 4.27 1.078 5.91z"/></svg>';
                        }else{
                            echo '<svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.2 12.18 0 7.91l6.061-.545L10 2l3.939 5.365L20 7.91l-5.2 4.27 1.078 5.91z"/></svg>';
                        }
                    }
                    ?>
                </div>
                <a href="room.php?id=<?php echo $r['id']; ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-block">View & Book</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
    feather.replace()
</script>
</body>
</html>
