<?php
require_once 'includes/db_connect.php';

$upload_dir = 'uploads/library/id_cards/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_id = (int)$_POST['material_id'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($material_id) || empty($full_name) || empty($email) || empty($phone)) {
        header("Location: library.php?status=error");
        exit;
    }

    $id_card_path = '';
    
    // Handle File Upload
    if (isset($_FILES['id_card']) && $_FILES['id_card']['error'] === UPLOAD_ERR_OK) {
        $name = time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", basename($_FILES['id_card']['name']));
        if (move_uploaded_file($_FILES['id_card']['tmp_name'], $upload_dir . $name)) {
            $id_card_path = 'uploads/library/id_cards/' . $name;
        } else {
            header("Location: library.php?status=error");
            exit;
        }
    } else {
        header("Location: library.php?status=error");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO physical_book_requests (material_id, full_name, email, phone, id_card_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$material_id, $full_name, $email, $phone, $id_card_path]);

        header("Location: library.php?status=success_physical");
        exit;

    } catch (PDOException $e) {
        header("Location: library.php?status=error");
        exit;
    }
} else {
    header("Location: library.php");
    exit;
}
