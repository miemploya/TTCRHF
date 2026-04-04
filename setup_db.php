<?php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect without DB first to create it
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS ttcrhf");
    $pdo->exec("USE ttcrhf");
    
    // Create admins table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create inquiries CRM table
    $pdo->exec("CREATE TABLE IF NOT EXISTS donation_inquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        location VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('pending', 'contacted') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create events table
    $pdo->exec("CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        event_date DATE NOT NULL,
        location VARCHAR(255) NOT NULL,
        flyer_path VARCHAR(255),
        status ENUM('upcoming', 'past') DEFAULT 'upcoming',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create gallery table
    $pdo->exec("CREATE TABLE IF NOT EXISTS gallery (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        image_path VARCHAR(255) NOT NULL,
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create partners table
    $pdo->exec("CREATE TABLE IF NOT EXISTS partners (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        image_path VARCHAR(255) NOT NULL,
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create impact_pillars table
    $pdo->exec("CREATE TABLE IF NOT EXISTS impact_pillars (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create custom_pages table for GrapesJS Visual Builder
    $pdo->exec("CREATE TABLE IF NOT EXISTS custom_pages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        slug VARCHAR(255) NOT NULL UNIQUE,
        title VARCHAR(255) NOT NULL,
        html_content LONGTEXT,
        css_content LONGTEXT,
        show_in_nav TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create donations table
    $pdo->exec("CREATE TABLE IF NOT EXISTS donations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        donor_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        reference VARCHAR(100) NOT NULL UNIQUE,
        status VARCHAR(50) DEFAULT 'success',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert default admin
    $admin_user = 'ttcrhf';
    $admin_pass = 'VOLUROMI';
    $hash = password_hash($admin_pass, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->execute([$admin_user]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->execute([$admin_user, $hash]);
        echo "Admin user created successfully.\n";
    } else {
        echo "Admin user already exists.\n";
    }
    
    echo "Database setup completed successfully.\n";
    
} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage() . "\n");
}
?>
