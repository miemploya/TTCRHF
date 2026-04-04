<?php
require_once 'c:\xampp\htdocs\TTCR\includes\db_connect.php';
$tiers = [
    'donate_tier_1_amt' => '10', 'donate_tier_1_desc' => 'Edu-Kit (Stationery)',
    'donate_tier_2_amt' => '25', 'donate_tier_2_desc' => 'CBT Exam Fee',
    'donate_tier_3_amt' => '50', 'donate_tier_3_desc' => 'Orphanage Meal Plan',
    'donate_tier_4_amt' => '100', 'donate_tier_4_desc' => 'SME Micro-Grant'
];
$stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
foreach ($tiers as $k => $v) {
    $stmt->execute([$k, $v]);
}
echo "Donation tiers seeded successfully.\n";
