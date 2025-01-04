<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

if ($_SESSION["role"] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="admindashboard.css">
</head>

<header>
<h1>Selamat datang, <?php echo get_user_name($conn, $_SESSION["user_id"]); ?></h1>
</header>
 

<body>
<a href="tickets.php">Kelola Tiket</a> | 
<a href="users.php">Kelola User</a> | 
<a href="reports.php">Laporan</a> | 
<a href="../logout.php">Logout</a>

</body>
</html>