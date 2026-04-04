<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';

// Handle Page Settings Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'settings') {
    $keys = ['projects_header_title', 'projects_header_desc', 'projects_bg_color'];
    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    foreach ($keys as $k) {
        if (isset($_POST[$k])) {
            $stmt->execute([$k, $_POST[$k]]);
        }
    }
    $message = "Projects Page Settings updated and immediately synced to Frontend!";
}

// Handle Add Project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $display_order = $_POST['display_order'] ?? 0;
    
    if (!empty($title) && !empty($description)) {
        $stmt = $pdo->prepare("INSERT INTO impact_pillars (title, description, display_order) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $display_order]);
        $message = "Impact Pillar added successfully!";
    } else {
        $message = "Title and Description are required.";
    }
}

// Handle Delete Project
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM impact_pillars WHERE id = ?")->execute([$id]);
    $message = "Impact Pillar deleted successfully!";
}

$pillars = $pdo->query("SELECT * FROM impact_pillars ORDER BY display_order ASC, created_at DESC")->fetchAll();

$stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
$settings_raw = [];
while ($row = $stmt->fetch()) {
    $settings_raw[$row['setting_key']] = $row['setting_value'];
}
?>
<?php include 'includes/header.php'; ?>

    <main class="flex-1 p-4 md:p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Manage Projects</h1>
            <p class="text-slate-500 mt-2 md:mt-0 font-medium text-sm">Control the structural pillars displaying on the public Projects page.</p>
        </header>
                
                <?php if($message): ?>
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                    <?= htmlspecialchars($message) ?>
                </div>
                <?php endif; ?>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Page Master Settings</h2>
                    <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <input type="hidden" name="action" value="settings">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Header Title</label>
                            <input type="text" name="projects_header_title" value="<?= htmlspecialchars($settings_raw['projects_header_title'] ?? 'Impact Pillars') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Header Description</label>
                            <input type="text" name="projects_header_desc" value="<?= htmlspecialchars($settings_raw['projects_header_desc'] ?? 'A systemic breakdown of our core operational domains across Edo State, delivering generational empowerment through strategic, focused intervention scopes.') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm truncate">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Page Background Color</label>
                            <div class="flex gap-4">
                                <input type="color" name="projects_bg_color" value="<?= htmlspecialchars($settings_raw['projects_bg_color'] ?? '#f8fafc') ?>" class="h-11 w-11 rounded cursor-pointer">
                                <input type="text" value="<?= htmlspecialchars($settings_raw['projects_bg_color'] ?? '#f8fafc') ?>" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm" disabled>
                            </div>
                        </div>
                        <div class="md:col-span-3 pt-2">
                            <button type="submit" class="bg-slate-800 text-white font-bold py-3 px-8 rounded-xl hover:bg-slate-900 transition">Save Master Settings</button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    
                    <!-- Add Pillar Form -->
                    <div class="xl:col-span-1">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-xl font-bold text-slate-800 mb-6">Create Impact Pillar</h2>
                            
                            <form method="POST" class="space-y-4">
                                <input type="hidden" name="action" value="add">
                                
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pillar Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm" placeholder="e.g. Infrastructure">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Full Description <span class="text-red-500">*</span></label>
                                    <textarea name="description" required rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm" placeholder="e.g. Implementing clean water boreholes..."></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Display Order</label>
                                    <input type="number" name="display_order" value="0" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                                </div>
                                
                                <div class="pt-4 flex gap-4">
                                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition w-full">Save Pillar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Pillars List -->
                    <div class="xl:col-span-2">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-xl font-bold text-slate-800 mb-6">Active Impact Pillars</h2>
                            
                            <?php if(empty($pillars)): ?>
                                <p class="text-slate-500 text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-200">No pillars added yet. Use the form to construct your project scopes!</p>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <?php foreach($pillars as $p): ?>
                                    <div class="border border-slate-200 rounded-2xl p-6 relative group hover:border-blue-500 hover:shadow-lg transition-all flex flex-col">
                                        <h3 class="font-bold text-xl text-slate-800 mb-3"><?= htmlspecialchars($p['title']) ?></h3>
                                        <p class="text-sm text-slate-500 mb-4 font-light leading-relaxed flex-grow"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                                        
                                        <div class="flex justify-between items-center w-full pt-4 border-t border-slate-100">
                                            <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full font-medium">Order: <?= $p['display_order'] ?></span>
                                            <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to completely delete this project pillar?')" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg hover:bg-red-100 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
    </main>
</body>
</html>
