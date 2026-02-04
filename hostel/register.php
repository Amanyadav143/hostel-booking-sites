<?php 
session_start();
include "db.php";

if(isset($_POST['register'])){
    include "csrf.php";
    verify_csrf();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($check->num_rows > 0){
        $msg = "Email already exists!";
    } else {
        $sql = "INSERT INTO users(name,email,password) VALUES('$name','$email','$pass')";
        if($conn->query($sql)){
            $msg = "Registered Successfully! Please Login.";
        } else {
            $msg = "Something went wrong!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>
<body>

<h2>Register</h2>

<?php if(isset($msg)) echo "<p style='color:red'>$msg</p>"; ?>

<form method="POST">
<?php include "csrf.php"; csrf(); ?>

<input type="text" name="name" placeholder="Full Name" required><br><br>
<input type="email" name="email" placeholder="Email" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>
<button name="register">Register</button>
</form>

<br>
<a href="login.php">Already have account? Login</a>

</body>
</html>
