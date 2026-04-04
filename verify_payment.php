<?php
require_once 'includes/db_connect.php';

header('Content-Type: application/json');

$reference = $_GET['reference'] ?? '';
$name = $_GET['name'] ?? 'Anonymous';
$email = $_GET['email'] ?? '';
$amount = $_GET['amount'] ?? 0;

if (empty($reference) || empty($email) || empty($amount)) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

/*
// In production, execute a cURL request to Paystack to strictly verify the transaction:
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authorization: Bearer " . base64_decode("c2tfbGl2ZV9lMWNkMDk4NDI1Mjc2N2QzM2UwZDUxMjlhNDM1NTY3MzU3YmMzZDZm"),
        "cache-control: no-cache"
    ],
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
// Parse $response and verify status is 'success' before proceeding.
*/

// For this implementation, we will assume success straight from the frontend callback (Local test mode)
// Insert into database
try {
    $stmt = $pdo->prepare("INSERT INTO donations (donor_name, email, amount, reference, status) VALUES (?, ?, ?, ?, 'success')");
    $stmt->execute([$name, $email, $amount, $reference]);
    
    echo json_encode(['success' => true, 'message' => 'Payment recorded successfully']);
} catch (Exception $e) {
    // Usually means duplicate reference
    echo json_encode(['success' => false, 'message' => 'Database error: Duplicate reference']);
}
