<?php
include "../security.php";
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){
    header("Location: ../index.php");
    exit;
}
include "../db.php";
$reviews = $conn->query("SELECT r.*, u.name as client_name, ro.name as room_name FROM reviews r JOIN users u ON r.user_id=u.id JOIN rooms ro ON r.room_id=ro.id ORDER BY r.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold mb-5">Manage Reviews</h1>
    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Client</th>
                <th class="py-2 px-4 border">Room</th>
                <th class="py-2 px-4 border">Rating</th>
                <th class="py-2 px-4 border">Message</th>
                <th class="py-2 px-4 border">Status</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($r = $reviews->fetch_assoc()): ?>
            <tr class="text-center border-b hover:bg-gray-100 transition">
                <td class="py-2 px-4"><?php echo $r['id']; ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($r['client_name']); ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($r['room_name']); ?></td>
                <td class="py-2 px-4">
                    <?php for($i=1;$i<=5;$i++){
                        echo '<span class="star">'.($i<=$r['rating']?'★':'☆').'</span>';
                    } ?>
                </td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($r['message']); ?></td>
                <td class="py-2 px-4"><?php echo ucfirst($r['status']); ?></td>
                <td class="py-2 px-4">
                    <a href="approve_review.php?id=<?php echo $r['id']; ?>" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded mb-1 inline-block">Approve</a>
                    <a href="delete_review.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Are you sure?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded inline-block">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
