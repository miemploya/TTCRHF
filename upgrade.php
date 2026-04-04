<?php
require 'includes/db_connect.php';

try {
    $pdo->exec("ALTER TABLE partnership_inquiries 
                ADD COLUMN partnership_amount VARCHAR(100) DEFAULT NULL AFTER phone,
                ADD COLUMN donation_frequency VARCHAR(50) DEFAULT NULL AFTER partnership_amount,
                ADD COLUMN partnership_period VARCHAR(100) DEFAULT NULL AFTER donation_frequency;");
    echo "Columns added successfully.\n";
} catch(PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Columns already exist.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
