<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

if ($_SESSION["role"] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Filter tanggal
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Helpdesk (Admin)</title>
  <link rel="stylesheet" type="text/css" href="laporan.css">

  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f0f0f0;
    }
  </style>
</head>
<body>

<h1>Laporan</h1>

<form method="get" action="">
  <label for="start_date">Tanggal Awal:</label>
  <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
  <label for="end_date">Tanggal Akhir:</label>
  <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
  <input type="submit" value="Filter">
</form>

<h2>Jumlah Tiket per Status</h2>
<table>
  <thead>
    <tr>
      <th>Status</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $sql = "SELECT status, COUNT(*) AS jumlah 
            FROM tickets 
            WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY status";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['status']; ?></td>
        <td><?php echo $row['jumlah']; ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>


<h2>Tiket yang Dibuat per Hari</h2>
<table>
  <thead>
    <tr>
      <th>Tanggal</th>
      <th>Jumlah Tiket</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT DATE(created_at) AS tanggal, COUNT(*) AS jumlah 
            FROM tickets 
            WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY tanggal";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['tanggal']; ?></td>
        <td><?php echo $row['jumlah']; ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<h2>Jumlah Tiket per User</h2>
<table>
  <thead>
    <tr>
      <th>User</th>
      <th>Jumlah Tiket</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT u.nama, COUNT(t.id) AS jumlah 
            FROM users u
            LEFT JOIN tickets t ON u.id = t.user_id
            WHERE t.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY u.nama";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['jumlah']; ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<br>
<a href="index.php">Kembali ke Dashboard</a>

</body>
</html>