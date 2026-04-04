<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';
$upload_dir = '../uploads/logo/';

// Handle Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_global') {
    $keys = ['brand_color', 'nav_title_color', 'nav_subtitle_color', 'contact_email', 'contact_phone', 'contact_address', 'exchange_rate', 'show_library_page'];
    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    
    foreach ($keys as $k) {
        if (isset($_POST[$k])) {
            $stmt->execute([$k, $_POST[$k]]);
        }
    }
    
    // Handle Logo Upload
    if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $tmp_name = $_FILES['site_logo']['tmp_name'];
        $name = basename($_FILES['site_logo']['name']);
        $new_name = 'logo_' . time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $name);
        $target_file = $upload_dir . $new_name;
        
        if (move_uploaded_file($tmp_name, $target_file)) {
            $stmt->execute(['uploads/logo/' . $new_name, 'site_logo']);
        } else {
            $message = "Error uploading logo.";
        }
    }

    // Handle Card Logo Upload
    if (isset($_FILES['card_logo']) && $_FILES['card_logo']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $tmp_name = $_FILES['card_logo']['tmp_name'];
        $name = basename($_FILES['card_logo']['name']);
        $new_name = 'cardlogo_' . time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $name);
        $target_file = $upload_dir . $new_name;
        
        if (move_uploaded_file($tmp_name, $target_file)) {
            $stmt->execute(['uploads/logo/' . $new_name, 'card_logo']);
        } else {
            $message = "Error uploading card logo.";
        }
    }
    
    if (empty($message)) $message = "Settings updated successfully!";
}

// Fetch current settings
$settings_raw = $pdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
?>
<?php
$page_title = 'Global Settings - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-[Plus Jakarta Sans] text-slate-800 tracking-tight">Global Settings</h1>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="glass-panel p-8 rounded-2xl mb-10 max-w-3xl animate-fade-up stagger-1">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="save_global">
                
                <div>
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Branding</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Brand Primary Color (HEX)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="brand_color" value="<?= htmlspecialchars($settings_raw['brand_color'] ?? '#a01c1c') ?>" class="w-12 h-12 rounded cursor-pointer border-0 p-0">
                                <span class="text-sm text-slate-500">This color will replace all maroon accents globally.</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nav Title Color (TTCRHF)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="nav_title_color" value="<?= htmlspecialchars($settings_raw['nav_title_color'] ?? '#0f172a') ?>" class="w-12 h-12 rounded cursor-pointer border-0 p-0">
                                <span class="text-sm text-slate-500">Color for the main TTCRHF text in the navbar.</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nav Subtitle Color ("The Tribe Called Roots")</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="nav_subtitle_color" value="<?= htmlspecialchars($settings_raw['nav_subtitle_color'] ?? '#dc2626') ?>" class="w-12 h-12 rounded cursor-pointer border-0 p-0">
                                <span class="text-sm text-slate-500">Color for the small subtitle text in the navbar.</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Site Logo</label>
                            <?php if(!empty($settings_raw['site_logo'])): ?>
                                <div class="mb-3 w-32 h-32 bg-slate-100 rounded-xl flex items-center justify-center p-2">
                                    <img src="../<?= htmlspecialchars($settings_raw['site_logo']) ?>" class="max-h-full object-contain">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="site_logo" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">
                            <p class="text-xs text-slate-500 mt-1">Leave empty to keep current logo.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pillar Card Back Logo</label>
                            <?php if(!empty($settings_raw['card_logo'])): ?>
                                <div class="mb-3 w-32 h-32 bg-slate-100 rounded-xl flex items-center justify-center p-2">
                                    <img src="../<?= htmlspecialchars($settings_raw['card_logo']) ?>" class="max-h-full object-contain">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="card_logo" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">
                            <p class="text-xs text-slate-500 mt-1">Leave empty to use main site logo as fallback.</p>
                        </div>
                    </div>
                </div>
                
                <div class="pt-6">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Financial Setup</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">USD Default Exchange Rate</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">₦</span>
                                <input type="number" step="0.01" name="exchange_rate" value="<?= htmlspecialchars($settings_raw['exchange_rate'] ?? '1500') ?>" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Acts as the multiplier to convert USD tier selections to NGN before routing to Paystack.</p>
                        </div>
                    </div>
                </div>
                
                <div class="pt-6">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Public Email Address</label>
                            <input type="email" name="contact_email" value="<?= htmlspecialchars($settings_raw['contact_email'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Public Phone Number</label>
                            <input type="text" name="contact_phone" value="<?= htmlspecialchars($settings_raw['contact_phone'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Physical Address</label>
                            <input type="text" name="contact_address" value="<?= htmlspecialchars($settings_raw['contact_address'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Module Visibility</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Library Page</label>
                            <select name="show_library_page" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                                <option value="1" <?= ($settings_raw['show_library_page'] ?? '1') == '1' ? 'selected' : '' ?>>Show to Public</option>
                                <option value="0" <?= ($settings_raw['show_library_page'] ?? '1') == '0' ? 'selected' : '' ?>>Hide from Public</option>
                            </select>
                            <p class="text-xs text-slate-500 mt-2">When hidden, the page is inaccessible and removed from navigation.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 transition">Save Settings</button>
                    <button type="reset" class="bg-slate-200 text-slate-700 font-bold py-3 px-8 rounded-xl hover:bg-slate-300 transition">Reset Form</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
