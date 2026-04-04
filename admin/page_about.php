<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_about') {
    $keys = ['about_hero_title', 'about_mission', 'about_bg_color'];
    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    
    foreach ($keys as $k) {
        if (isset($_POST[$k])) {
            $stmt->execute([$k, $_POST[$k]]);
        }
    }

    $upload_dir = '../uploads/pages/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
        $name = basename($_FILES['about_image']['name']);
        $new_name = 'about_img_' . time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $name);
        if (move_uploaded_file($_FILES['about_image']['tmp_name'], $upload_dir . $new_name)) {
            $stmt->execute(['about_image', 'uploads/pages/' . $new_name]);
        }
    }
    
    $message = "About page content updated successfully!";
}

$settings_raw = $pdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
?>
<?php
$page_title = 'Edit About Page - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Edit About Page Content</h1>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium animate-fade-up"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="glass-panel p-8 rounded-2xl mb-10 max-w-4xl animate-fade-up stagger-1">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="save_about">
                
                <div>
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Chairman / Focus Image</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Section Background Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="about_bg_color" value="<?= htmlspecialchars($settings_raw['about_bg_color'] ?? '#0f172a') ?>" class="w-12 h-12 rounded cursor-pointer border-0 p-0">
                                <span class="text-xs text-slate-500">The solid color wrapping the focus section.</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Primary Focus Image (e.g., Chairman)</label>
                            <?php if(!empty($settings_raw['about_image'])): ?>
                                <img src="../<?= htmlspecialchars($settings_raw['about_image']) ?>" class="h-10 w-auto mb-2 rounded border border-slate-200 object-cover">
                            <?php endif; ?>
                            <input type="file" name="about_image" accept="image/*" class="w-full px-2 py-1 rounded-xl border border-slate-200 text-sm">
                        </div>
                    </div>

                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Hero Section</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hero Title</label>
                            <input type="hidden" name="about_hero_title" id="about_hero_title_input">
                            <div class="mb-4">
                                <div id="quill-about-hero" class="bg-white" style="height: 150px;"><?= $settings_raw['about_hero_title'] ?? '' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Mission Statement</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Mission Content</label>
                            <input type="hidden" name="about_mission" id="about_mission_input">
                            <div class="mb-8">
                                <div id="quill-mission" class="bg-white" style="height: 250px;"><?= $settings_raw['about_mission'] ?? '' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 transition">Save About Page</button>
                    <button type="reset" class="bg-slate-200 text-slate-700 font-bold py-3 px-8 rounded-xl hover:bg-slate-300 transition">Reset Form</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        var toolbarOptions = [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link', 'clean']
        ];

        var quillAboutHero = new Quill('#quill-about-hero', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });

        var quillMission = new Quill('#quill-mission', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });

        // Sync Quill content to hidden input before submit
        document.querySelector('form').onsubmit = function() {
            document.querySelector('#about_hero_title_input').value = quillAboutHero.root.innerHTML;
            document.querySelector('#about_mission_input').value = quillMission.root.innerHTML;
        };
    </script>
</body>
</html>
