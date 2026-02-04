<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $res = $conn->query($sql);

    if($res->num_rows > 0){
        $user = $res->fetch_assoc();
        $_SESSION['user'] = $user;

        if($user['role'] == "admin"){
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $msg = "Invalid Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if(isset($msg)) echo "<p style='color:red'>$msg</p>"; ?>

<form method="POST">
<?php include "csrf.php"; csrf(); ?>

<input type="email" name="email" placeholder="Email" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>
<button name="login">Login</button>
</form>

<br>
<a href="register.php">Create New Account</a>

</body>
</html>
