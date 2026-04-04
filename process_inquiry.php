<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['contact_name'] ?? '';
    $email = $_POST['contact_email'] ?? '';
    $phone = $_POST['contact_phone'] ?? '';
    $location = $_POST['contact_location'] ?? '';
    $subject = $_POST['contact_subject'] ?? '';
    $message = $_POST['contact_message'] ?? '';

    // Basic Validation
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: index.php?inquiry=error#page-contact");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO donation_inquiries (full_name, email, phone, location, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $location, $subject, $message]);
        
        header("Location: index.php?inquiry=success#page-contact");
    } catch (PDOException $e) {
        header("Location: index.php?inquiry=error#page-contact");
    }
    exit;
}
header("Location: index.php");
exit;
