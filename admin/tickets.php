<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

if ($_SESSION["role"] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

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
  <title>Kelola Tiket (Admin)</title>
  <link rel="stylesheet" type="text/css" href="tickets.css">


</head>
<body>

<h1>Kelola Tiket</h1>

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
      <td>
        <a href="view_ticket.php?id=<?php echo $row['id']; ?>">Lihat</a> | 
        <a href="edit_ticket.php?id=<?php echo $row['id']; ?>">Edit</a> | 
        <a href="delete_ticket.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus tiket ini?')">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<br>
<a href="index.php">Kembali ke Dashboard</a>

</body>
</html>