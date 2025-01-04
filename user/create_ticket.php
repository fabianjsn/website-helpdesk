<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST["subject"];
    $description = $_POST["description"];
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO tickets (user_id, subject, description, status, created_at)
            VALUES ($user_id, '$subject', '$description', 'open', NOW())";

    if ($conn->query($sql) === TRUE) {
        $success = "Tiket berhasil dibuat!";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Buat Tiket Baru</title>
  <link rel="stylesheet" href="../css/create_tiket.css">
</head>
<body>

<h1>Buat Tiket Baru</h1>

<?php if (isset($error)): ?>
  <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (isset($success)): ?>
  <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="subject">Subjek:</label><br>
  <input type="text" id="subject" name="subject" required><br><br>
  <label for="description">Deskripsi:</label><br>
  <textarea id="description" name="description" required></textarea><br><br>
  <input type="submit" value="Submit">
</form>

<br>
<a href="index.php">Kembali ke Dashboard</a>

</body>
</html>