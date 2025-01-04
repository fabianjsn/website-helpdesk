<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

// Ambil semua tiket 
$sql = "SELECT t.*, u.nama AS nama_user
        FROM tickets t
        JOIN users u ON t.user_id = u.id
        ORDER BY t.created_at DESC"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Support</title>
  <link rel="stylesheet" href="../css/support.css">
</head>
<body>

<h1>Selamat datang, <?php echo get_user_name($conn, $_SESSION["user_id"]); ?>!</h1>

<h2>Daftar Tiket</h2> 

<table>
  <tr>
    <th>ID</th>
    <th>Subjek</th>
    <th>User</th>
    <th>Status</th>
    <th>Dibuat pada</th>
    <th>Aksi</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['subject']; ?></td>
      <td><?php echo $row['nama_user']; ?></td>
      <td><?php echo $row['status']; ?></td>
      <td><?php echo $row['created_at']; ?></td>
      <td><a href="view_ticket.php?id=<?php echo $row['id']; ?>">Lihat</a></td> 
    </tr>
  <?php endwhile; ?>
</table>

<br>
<a href="../logout.php">Logout</a>

</body>
</html>