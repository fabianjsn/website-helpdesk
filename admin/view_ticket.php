<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

if ($_SESSION["role"] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET["id"])) {
    $ticket_id = $_GET["id"];

    // Ambil data tiket
    $sql = "SELECT t.*, u.nama AS nama_user 
            FROM tickets t
            JOIN users u ON t.user_id = u.id
            WHERE t.id = $ticket_id";
    $result = $conn->query($sql);
    $ticket = $result->fetch_assoc();

    // Ambil balasan pada tiket
    $sql = "SELECT r.*, u.nama AS nama_pengirim 
            FROM replies r
            JOIN users u ON r.user_id = u.id
            WHERE r.ticket_id = $ticket_id
            ORDER BY r.created_at ASC";
    $replies_result = $conn->query($sql);

    // Update tiket (jika ada post data)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $status = $_POST["status"];
        $assigned_to = $_POST["assigned_to"]; 
        $message = $_POST["message"];

        // Update status dan assigned_to tiket
        $sql = "UPDATE tickets SET status = '$status', assigned_to = $assigned_to WHERE id = $ticket_id";
        $conn->query($sql);

        // Tambah balasan
        if (!empty($message)) {
            $user_id = $_SESSION["user_id"];
            $sql = "INSERT INTO replies (ticket_id, user_id, message, created_at) 
                    VALUES ($ticket_id, $user_id, '$message', NOW())";
            $conn->query($sql);
        }

        // Redirect kembali ke halaman tiket
        header("Location: view_ticket.php?id=$ticket_id");
        exit();
    }
} else {
    header("Location: tickets.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Lihat Tiket (Admin)</title>
  <link rel="stylesheet" type="text/css" href="tickets.css">

</head>
<body>

<h1><?php echo $ticket['subject']; ?></h1>

<p><strong>Status:</strong> <?php echo $ticket['status']; ?></p>
<p><strong>Dibuat oleh:</strong> <?php echo $ticket['nama_user']; ?> pada <?php echo $ticket['created_at']; ?></p>
<p><strong>Ditugaskan kepada:</strong> 
    <?php 
    if ($ticket['assigned_to']) {
        echo get_user_name($conn, $ticket['assigned_to']); 
    } else {
        echo "Belum ditugaskan";
    }
    ?>
</p>
<p><?php echo $ticket['description']; ?></p>

<h2>Balasan</h2>

<?php if ($replies_result->num_rows > 0): ?>
  <?php while ($reply = $replies_result->fetch_assoc()): ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
      <p><strong><?php echo $reply['nama_pengirim']; ?></strong> (<?php echo $reply['created_at']; ?>):</p>
      <p><?php echo $reply['message']; ?></p>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <p>Belum ada balasan pada tiket ini.</p>
<?php endif; ?>

<h2>Tambahkan Balasan atau Update Status</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $ticket_id); ?>">
  <label for="status">Status:</label><br>
  <select id="status" name="status">
    <option value="open" <?php if ($ticket['status'] == 'open') echo 'selected'; ?>>Open</option>
    <option value="pending" <?php if ($ticket['status'] == 'pending') echo 'selected'; ?>>Pending</option>
    <option value="closed" <?php if ($ticket['status'] == 'closed') echo 'selected'; ?>>Closed</option>
  </select><br><br>

  <label for="assigned_to">Tugaskan kepada:</label><br>
  <select id="assigned_to" name="assigned_to">
    <option value="">-- Pilih Support --</option>
    <?php
    // Ambil daftar user dengan role 'support'
    $support_sql = "SELECT id, nama FROM users WHERE role = 'support'";
    $support_result = $conn->query($support_sql);
    while ($support = $support_result->fetch_assoc()): ?>
      <option value="<?php echo $support['id']; ?>" 
              <?php if ($ticket['assigned_to'] == $support['id']) echo 'selected'; ?>>
        <?php echo $support['nama']; ?>
      </option>
    <?php endwhile; ?>
  </select><br><br>

  <label for="message">Pesan:</label><br>
  <textarea id="message" name="message"></textarea><br><br>

  <input type="submit" value="Submit">
</form> 

<br>
<a href="tickets.php">Kembali ke Daftar Tiket</a>

</body>
</html>