<?php
require_once 'includes/db_connect.php';

try {
    // Create new table for donation inquiries
    $pdo->exec("CREATE TABLE IF NOT EXISTS donation_inquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(150) NOT NULL,
        email VARCHAR(150) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        location VARCHAR(150) NOT NULL,
        amount_tier VARCHAR(100) NOT NULL,
        status ENUM('pending', 'contacted') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    echo "Table 'donation_inquiries' generated successfully.\n";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
