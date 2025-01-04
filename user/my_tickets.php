<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM tickets WHERE user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tiket Saya</title>
  <link rel="stylesheet" href="../css/my_ticket.css">
</head>
<body>

<h1>Tiket Saya</h1>

<table>
  <tr>
    <th>ID</th>
    <th>Subjek</th>
    <th>Status</th>
    <th>Dibuat pada</th>
    <th>Aksi</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['subject']; ?></td>
      <td><?php echo $row['status']; ?></td>
      <td><?php echo $row['created_at']; ?></td>
      <td><a href="view_ticket.php?id=<?php echo $row['id']; ?>">Lihat</a></td>
    </tr>
  <?php endwhile; ?>
</table>

<br>
<a href="index.php">Kembali ke Dashboard</a>

</body>
</html>