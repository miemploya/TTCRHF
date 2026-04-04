<?php
require_once 'includes/db_connect.php';

try {
    $stmt = $pdo->prepare("INSERT INTO library_requests (material_id, full_name, email, phone) VALUES (1, 'John Doe', 'john@example.com', '123456')");
    $stmt->execute();
    echo "Inserted library request\n";
} catch (Exception $e) {
    echo "Error (it's fine if material 1 doesn't exist): " . $e->getMessage() . "\n";
}

try {
    $stmt = $pdo->query("SELECT * FROM library_requests");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo "Error querying: " . $e->getMessage() . "\n";
}
