<?php
include 'includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password
    $nama = $_POST["nama"];
    $email = $_POST["email"];

    $sql = "INSERT INTO users (username, password, nama, email, role) 
            VALUES ('$username', '$password', '$nama', '$email', 'user')";

    if ($conn->query($sql) === TRUE) {
        $success = "Registrasi berhasil! Silakan login.";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register Helpdesk</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>

<?php if (isset($error)): ?>
  <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (isset($success)): ?>
  <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="username">Username:</label><br>
  <input type="text" id="username" name="username" required><br><br>
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" required><br><br>
  <label for="nama">Nama:</label><br>
  <input type="text" id="nama" name="nama" required><br><br>
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" required><br><br>
  <input type="submit" value="Register">
</form>

<p>Sudah punya akun? <a href="login.php">Login</a></p>

</body>
</html>