<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $material_id = (int)$_POST['material_id'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($material_id) || empty($full_name) || empty($email)) {
        header("Location: library.php?status=error");
        exit;
    }

    try {
        // Log the request
        $stmt = $pdo->prepare("INSERT INTO library_requests (material_id, full_name, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$material_id, $full_name, $email, $phone]);

        // Get the material path
        $stmtMaterial = $pdo->prepare("SELECT file_path, title FROM library_materials WHERE id = ?");
        $stmtMaterial->execute([$material_id]);
        $material = $stmtMaterial->fetch();

        if ($material && file_exists($material['file_path'])) {
            $filepath = $material['file_path'];
            $filename = basename($filepath);

            // Force Download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
        } else {
            // Material doesn't exist
            header("Location: library.php?status=error");
            exit;
        }

    } catch (PDOException $e) {
        header("Location: library.php?status=error");
        exit;
    }
} else {
    header("Location: library.php");
    exit;
}
