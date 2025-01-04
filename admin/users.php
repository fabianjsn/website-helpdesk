<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

if ($_SESSION["role"] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil semua user
$sql = "SELECT * FROM users ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Kelola User (Admin)</title>
  <link rel="stylesheet" type="text/css" href="users.css">

</head>
<body>

<h1>Kelola User</h1>

<table>
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
    <th>Aksi</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['nama']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['role']; ?></td>
      <td>
        <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> | 
        <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus user ini?')">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<br>
<a href="index.php">Kembali ke Dashboard</a>

</body>
</html>