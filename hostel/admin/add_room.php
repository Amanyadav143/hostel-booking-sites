<?php
include "../security.php";
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){
    header("Location: ../index.php");
    exit;
}
include "../db.php";
include "../csrf.php";
verify_csrf();

$msg = "";

if(isset($_POST['add_room'])){
    verify_csrf();
    $name = htmlspecialchars($_POST['name']);
    $price = intval($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $facilities = htmlspecialchars($_POST['facilities']);

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = "../uploads/".$image;
    move_uploaded_file($tmp_name, $upload_dir);

    $stmt = $conn->prepare("INSERT INTO rooms(name, price, description, facilities, image) VALUES(?,?,?,?,?)");
    $stmt->bind_param("sisss",$name, $price, $description, $facilities, $image);
    $stmt->execute();

    $msg = "Room added successfully! ✅";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Room</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold mb-5">Add New Room</h1>
    <?php if($msg) echo "<p class='text-green-600 mb-4'>$msg</p>"; ?>
    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow max-w-lg">
        <?php csrf(); ?>
        <label class="block mb-2 font-semibold">Room Name</label>
        <input type="text" name="name" class="w-full mb-3 p-2 border rounded" required>

        <label class="block mb-2 font-semibold">Price</label>
        <input type="number" name="price" class="w-full mb-3 p-2 border rounded" required>

        <label class="block mb-2 font-semibold">Description</label>
        <textarea name="description" class="w-full mb-3 p-2 border rounded" rows="3" required></textarea>

        <label class="block mb-2 font-semibold">Facilities</label>
        <input type="text" name="facilities" class="w-full mb-3 p-2 border rounded" placeholder="WiFi, AC, etc." required>

        <label class="block mb-2 font-semibold">Room Image</label>
        <input type="file" name="image" class="w-full mb-4" required>

        <button type="submit" name="add_room" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition hover:-translate-y-1">Add Room</button>
    </form>
</div>

</body>
</html>
