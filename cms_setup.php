<?php
$host = 'localhost';
$dbname = 'ttcrhf';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Add theme_color to events if it doesn't exist
    try {
        $pdo->exec("ALTER TABLE events ADD COLUMN theme_color VARCHAR(50) DEFAULT 'maroon'");
        echo "Added theme_color to events table.\n";
    } catch(PDOException $e) {
        // Column probably exists, skip error
        echo "theme_color column may already exist.\n";
    }

    // Create site_settings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
        setting_key VARCHAR(100) PRIMARY KEY,
        setting_value LONGTEXT
    )");
    
    // Seed default settings
    $settings = [
        'brand_color' => '#a01c1c',
        'site_logo' => 'ttcrhf_logo.png?v=2',
        'contact_email' => 'ttcrhf@mail.com',
        'contact_phone' => '+234 809 200 0080',
        'contact_address' => '2/4, Christ Coming Drive, Ulemo, Benin City, Edo State.',
        
        // Home Page
        'home_hero_title' => 'The Tribe Called <br><span class="text-[var(--brand-primary)]">Roots Foundation.</span>',
        'home_hero_subtitle' => 'Empowering the less privileged through international standard infrastructure, small business grants, and digital education excellence.',
        'home_video_url' => 'https://www.youtube.com/embed/W4tmxw1mORI',
        'home_video_title' => 'Our Story in Motion',
        'home_video_subtitle' => 'Watch how we are transforming rural landscapes through the Tribe Called Roots mission.',
        
        // About Page
        'about_hero_title' => 'A Mission for 2026: <br><span class="text-maroon-400">Roots of Transformation</span>',
        'about_mission' => '<p>Welcome to The Tribe Called Roots. Our journey is defined by a simple yet non-negotiable mission: to reach into the most underserved rural communities and plant the seeds of self-sufficiency and dignity.</p><p>Our roadmap for <strong>2026</strong> is anchored in a landmark commitment to educational equity. We are prioritizing the <strong>CBT transition mandate</strong>, ensuring that through our strategic partnership with <strong>Openclax</strong>, every rural student in Edo State has the digital tools to excel in national examinations.</p><p>Beyond education, we are scaling our health interventions and business grant programs to provide a holistic foundation for growth. I believe that geography should never determine destiny. Join us as we build a world where progress is inclusive, and every community is illuminated through knowledge and opportunity.</p>'
    ];
    
    $stmtUpdate = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    foreach ($settings as $key => $val) {
        $stmtUpdate->execute([$key, $val]);
    }
    
    echo "Site settings seeded successfully.\n";

    // Create library_materials table
    $pdo->exec("CREATE TABLE IF NOT EXISTS library_materials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        file_path VARCHAR(255) NOT NULL,
        cover_image_path VARCHAR(255),
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create library_requests table
    $pdo->exec("CREATE TABLE IF NOT EXISTS library_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        material_id INT NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50),
        requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (material_id) REFERENCES library_materials(id) ON DELETE CASCADE
    )");
    
    // Create physical_book_requests table
    $pdo->exec("CREATE TABLE IF NOT EXISTS physical_book_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        material_id INT NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        id_card_path VARCHAR(255) NOT NULL,
        status ENUM('pending', 'approved', 'returned', 'rejected') DEFAULT 'pending',
        due_date DATE DEFAULT NULL,
        requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (material_id) REFERENCES library_materials(id) ON DELETE CASCADE
    )");
    
    // Create partnership_inquiries table
    $pdo->exec("CREATE TABLE IF NOT EXISTS partnership_inquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        organization_name VARCHAR(255) NOT NULL,
        contact_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        partnership_amount VARCHAR(100) DEFAULT NULL,
        donation_frequency VARCHAR(50) DEFAULT NULL,
        partnership_period VARCHAR(100) DEFAULT NULL,
        message TEXT,
        status ENUM('pending', 'contacted') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    echo "Library and Partnership tables seeded successfully.\n";

} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage() . "\n");
}
?>
