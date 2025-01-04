<?php
include '../includes/database.php';
include '../includes/functions.php';
check_login();

if (isset($_GET["id"])) {
    $ticket_id = $_GET["id"];

    // Ambil data tiket
    $sql = "SELECT * FROM tickets WHERE id = $ticket_id";
    $result = $conn->query($sql);
    $ticket = $result->fetch_assoc();

    // Ambil balasan pada tiket
    $sql = "SELECT r.*, u.nama AS nama_pengirim
            FROM replies r
            JOIN users u ON r.user_id = u.id
            WHERE r.ticket_id = $ticket_id
            ORDER BY r.created_at ASC";
    $replies_result = $conn->query($sql);

    // Tambah balasan (jika ada post data)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = $_POST["message"];
        if (!empty($message)) {
            $user_id = $_SESSION["user_id"];
            $sql = "INSERT INTO replies (ticket_id, user_id, message, created_at)
                    VALUES ($ticket_id, $user_id, '$message', NOW())";
            $conn->query($sql);

            // Redirect kembali ke halaman tiket
            header("Location: view_ticket.php?id=$ticket_id");
            exit();
        }
    }
} else {
    header("Location: my_tickets.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Lihat Tiket</title>
  <link rel="stylesheet" href="../css/lihat_tiket.css">
</head>
<body>

<h1><?php echo $ticket['subject']; ?></h1>

<p><strong>Status:</strong> <?php echo $ticket['status']; ?></p>
<p><strong>Dibuat oleh:</strong> <?php echo get_user_name($conn, $ticket['user_id']); ?> pada <?php echo $ticket['created_at']; ?></p>
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

<h2>Tambahkan Balasan</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $ticket_id); ?>">
  <label for="message">Pesan:</label><br>
  <textarea id="message" name="message"></textarea><br><br>
  <input type="submit" value="Submit">
</form>

<br>
<a href="my_tickets.php">Kembali ke Tiket Saya</a>

</body>
</html>