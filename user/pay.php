<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$amount = $_POST['amount'];

// Get current balance
$result = $conn->query("SELECT balance FROM wallet WHERE user_id = $user_id");
$row = $result->fetch_assoc();

if ($row['balance'] >= $amount) {

    // Deduct balance
    $conn->query("UPDATE wallet SET balance = balance - $amount WHERE user_id = $user_id");

    // Save transaction
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, amount, type, description) VALUES (?, ?, 'debit', 'Trip Booking')");
    $stmt->bind_param("id", $user_id, $amount);
    $stmt->execute();

    echo "Payment successful!";
} else {
    echo "Insufficient balance!";
}
?>