<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization_name = trim($_POST['organization_name'] ?? '');
    $contact_name = trim($_POST['contact_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $partnership_amount = trim($_POST['partnership_amount'] ?? '');
    $donation_frequency = trim($_POST['donation_frequency'] ?? '');
    $partnership_period = trim($_POST['partnership_period'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($organization_name) || empty($contact_name) || empty($email)) {
        header("Location: index.php?partner_status=error");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO partnership_inquiries (organization_name, contact_name, email, phone, partnership_amount, donation_frequency, partnership_period, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$organization_name, $contact_name, $email, $phone, $partnership_amount, $donation_frequency, $partnership_period, $message]);

        header("Location: index.php?partner_status=success");
        exit;

    } catch (PDOException $e) {
        header("Location: index.php?partner_status=error");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
