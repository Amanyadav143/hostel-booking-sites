<?php
session_start();
include "db.php";
include "csrf.php";
include "security.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

if(!isset($_GET['room_id'])){
    header("Location: index.php");
    exit;
}

$room_id = intval($_GET['room_id']);
$user_id = $_SESSION['user']['id'];
$user_name = htmlspecialchars($_SESSION['user']['name']);
$msg = "";
$show_modal = false;

if(isset($_POST['submit_review'])){
    verify_csrf();

    $rating = intval($_POST['rating']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO reviews(user_id, room_id, rating, message, status, created_at) VALUES(?,?,?,?, 'pending', NOW())");
    $stmt->bind_param("iiis", $user_id, $room_id, $rating, $message);
    $stmt->execute();

    $msg = "Review submitted successfully! ✅";
    $show_modal = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Submit Review</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<div class="bg-white shadow mb-6">
    <div class="container mx-auto flex justify-between items-center p-5">
        <h1 class="text-2xl font-bold">Submit Review</h1>
        <div>
            <span class="mr-4 font-semibold"><?php echo $user_name; ?></span>
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Logout</a>
        </div>
    </div>
</div>

<div class="container mx-auto p-5">
    <?php if($msg) echo "<p class='text-green-600 mb-4'>$msg</p>"; ?>

    <form method="POST" class="bg-white p-6 rounded shadow max-w-lg mx-auto">
        <?php csrf(); ?>
        <label class="block mb-2 font-semibold">Rating (1-5)</label>
        <input type="number" name="rating" min="1" max="5" class="w-full mb-4 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>

        <label class="block mb-2 font-semibold">Message</label>
        <textarea name="message" class="w-full mb-4 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" required></textarea>

        <button type="submit" name="submit_review" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition transform hover:-translate-y-1 w-full">
            Submit Review
        </button>
    </form>
</div>

<!-- Success Modal -->
<?php if($show_modal): ?>
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded shadow p-8 max-w-md text-center">
        <h2 class="text-2xl font-bold mb-4"><?php echo $msg; ?></h2>
        <button onclick="document.getElementById('successModal').style.display='none'" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>
<?php endif; ?>

<script>
feather.replace()
</script>
</body>
</html>
