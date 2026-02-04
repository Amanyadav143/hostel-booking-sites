<?php
include "../security.php";
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){
    header("Location: ../index.php");
    exit;
}
include "../db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold mb-5">Manage Rooms</h1>
    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Name</th>
                <th class="py-2 px-4 border">Price</th>
                <th class="py-2 px-4 border">Facilities</th>
                <th class="py-2 px-4 border">Image</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $rooms = $conn->query("SELECT * FROM rooms ORDER BY id DESC");
        while($r = $rooms->fetch_assoc()):
        ?>
            <tr class="text-center border-b hover:bg-gray-100 transition">
                <td class="py-2 px-4"><?php echo $r['id']; ?></td>
                <td class="py-2 px-4 font-semibold"><?php echo htmlspecialchars($r['name']); ?></td>
                <td class="py-2 px-4"><?php echo $r['price']; ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($r['facilities']); ?></td>
                <td class="py-2 px-4">
                    <img src="../uploads/<?php echo $r['image']; ?>" class="w-20 h-20 object-cover rounded mx-auto">
                </td>
                <td class="py-2 px-4">
                    <a href="edit_room.php?id=<?php echo $r['id']; ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mb-1 inline-block">Edit</a>
                    <a href="delete_room.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Are you sure?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded inline-block">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
