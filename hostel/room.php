<?php
session_start();
include "db.php";
include "csrf.php";
verify_csrf();

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$room_id = intval($_GET['id']);
$room = $conn->query("SELECT * FROM rooms WHERE id=$room_id")->fetch_assoc();
if(!$room){
    header("Location: index.php");
    exit;
}

$msg = "";
$show_modal = false;

if(isset($_POST['book'])){
    verify_csrf();

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;

    // Insert booking into DB
    $stmt = $conn->prepare("INSERT INTO bookings(user_id, room_id, name, email, phone, message, status, booking_date) VALUES(?,?,?,?,?,?,?,NOW())");
    $status = 'pending';
    $stmt->bind_param("iissss",$user_id, $room_id, $name, $email, $phone, $message);
    $stmt->execute();

    // WhatsApp link
    $admin_phone = "977981XXXXXXX"; // Change to admin WhatsApp number
    $text = urlencode("New Booking:\nRoom: ".$room['name']."\nName: $name\nEmail: $email\nPhone: $phone\nMessage: $message");
    $whatsapp_link = "https://wa.me/$admin_phone?text=$text";

    $msg = "Booking successful! ✅";
    $show_modal = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($room['name']); ?> - Hostel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-10">
    <a href="index.php" class="text-blue-500 hover:underline mb-5 inline-block">&larr; Back to Rooms</a>

    <div class="grid md:grid-cols-2 gap-6 bg-white p-6 rounded shadow">
        <img src="uploads/<?php echo $room['image']; ?>" class="w-full h-80 object-cover rounded shadow mb-4 md:mb-0">
        <div>
            <h1 class="text-3xl font-bold mb-3"><?php echo htmlspecialchars($room['name']); ?></h1>
            <p class="text-gray-700 mb-2 font-semibold">Price: Rs <?php echo $room['price']; ?></p>
            <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($room['description']); ?></p>
            <p class="text-gray-700 font-semibold mb-4">Facilities: <?php echo htmlspecialchars($room['facilities']); ?></p>

            <form method="POST" class="bg-gray-100 p-4 rounded shadow" enctype="multipart/form-data">
                <?php csrf(); ?>
                <label class="block mb-2 font-semibold">Name</label>
                <input type="text" name="name" class="w-full mb-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                <label class="block mb-2 font-semibold">Email</label>
                <input type="email" name="email" class="w-full mb-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                <label class="block mb-2 font-semibold">Phone</label>
                <input type="text" name="phone" class="w-full mb-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                <label class="block mb-2 font-semibold">Message</label>
                <textarea name="message" class="w-full mb-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>

                <button type="submit" name="book" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition transform hover:-translate-y-1">Book Now</button>
            </form>
        </div>
    </div>
</div>

<!-- Booking Success Modal -->
<?php if($show_modal): ?>
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded shadow p-8 max-w-md text-center">
        <h2 class="text-2xl font-bold mb-4"><?php echo $msg; ?></h2>
        <p class="mb-4">Click below to notify admin via WhatsApp</p>
        <a href="<?php echo $whatsapp_link; ?>" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded inline-block mb-3">Notify on WhatsApp</a>
        <button onclick="document.getElementById('successModal').style.display='none'" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>
<?php endif; ?>

<script>
feather.replace()
</script>
</body>
</html>
