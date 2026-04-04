<?php
require_once __DIR__ . '/db_connect.php';

function get_global_settings($pdo) {
    try {
        return $pdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch(Exception $e) {
        return [];
    }
}

$site_settings = get_global_settings($pdo);
$brand_color_hex = $site_settings['brand_color'] ?? '#a01c1c';
$nav_title_color = $site_settings['nav_title_color'] ?? '#0f172a';
$nav_subtitle_color = $site_settings['nav_subtitle_color'] ?? '#dc2626';
$site_logo = !empty($site_settings['site_logo']) ? $site_settings['site_logo'] : 'ttcrhf_logo.png?v=2';
$card_logo = !empty($site_settings['card_logo']) ? $site_settings['card_logo'] : $site_logo;
?>
