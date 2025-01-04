<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard User</title>
  <link rel="stylesheet" href="../css/users.css">
</head>
<body>

<h1>Selamat datang, <?php echo get_user_name($conn, $_SESSION["user_id"]); ?>!</h1>

<a href="create_ticket.php">Buat Tiket Baru</a> |
<a href="my_tickets.php">Tiket Saya</a> |
<a href="../logout.php">Logout</a>

</body>
</html>