<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$amount = $_POST['amount'];

if ($amount > 0) {
    // Update balance
    $conn->query("UPDATE wallet SET balance = balance + $amount WHERE user_id = $user_id");

    // Save transaction
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, amount, type, description) VALUES (?, ?, 'credit', 'Wallet Top-up')");
    $stmt->bind_param("id", $user_id, $amount);
    $stmt->execute();

    echo "Money added successfully!";
}
?>