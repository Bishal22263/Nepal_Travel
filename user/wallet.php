<?php
session_start();
include 'db.php';

// make sure user is logged in
$user_id = $_SESSION['user_id'];

// GET BALANCE
$result = $conn->query("SELECT balance FROM wallet WHERE user_id = $user_id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Wallet</title>
</head>
<body>

<h2>💰 My Wallet</h2>

<!-- BALANCE -->
<h3>Balance: Rs. <?php echo $row['balance']; ?></h3>

<hr>

<!-- ADD MONEY -->
<h3>Add Money</h3>
<form action="add_money.php" method="POST">
    <input type="number" name="amount" placeholder="Enter amount" required>
    <button type="submit">Add Money</button>
</form>

<hr>

<!-- PAY -->
<h3>Pay for Trip</h3>
<form action="pay.php" method="POST">
    <input type="number" name="amount" placeholder="Trip price" required>
    <button type="submit">Pay Now</button>
</form>

<hr>

<!-- TRANSACTION HISTORY -->
<h3>Transaction History</h3>

<?php
$result = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
    echo $row['type'] . " - Rs." . $row['amount'] . " (" . $row['description'] . ")<br>";
}
?>

</body>
</html>