<?php
include 'includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["role"] = $row["role"];

            header("Location: " . $row["role"] . "/index.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Helpdesk</title>
  <link rel="stylesheet" href="../css/login.css">

</head>
<body>

<?php if (isset($error)): ?>
  <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="username">Username:</label><br>
  <input type="text" id="username" name="username" required><br><br>
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" required><br><br>
  <input type="submit" value="Login">
</form>

<p>Belum punya akun? <a href="register.php">Register</a></p>

</body>
</html>