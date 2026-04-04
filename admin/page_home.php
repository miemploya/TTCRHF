<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_home') {
    $keys = ['home_hero_title', 'home_hero_subtitle', 'home_video_url', 'home_video_title', 'home_video_subtitle',
             'donate_tier_1_amt', 'donate_tier_1_desc', 'donate_tier_2_amt', 'donate_tier_2_desc',
             'donate_tier_3_amt', 'donate_tier_3_desc', 'donate_tier_4_amt', 'donate_tier_4_desc', 'home_hero_bg_color',
             'home_partnership_tag', 'home_partnership_title', 'home_partnership_desc'];
    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    
    foreach ($keys as $k) {
        if (isset($_POST[$k])) {
            $stmt->execute([$k, $_POST[$k]]);
        }
    }
    
    $upload_dir = '../uploads/pages/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    if (isset($_FILES['home_hero_bg_image']) && $_FILES['home_hero_bg_image']['error'] === UPLOAD_ERR_OK) {
        $name = basename($_FILES['home_hero_bg_image']['name']);
        $new_name = 'home_hero_' . time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $name);
        if (move_uploaded_file($_FILES['home_hero_bg_image']['tmp_name'], $upload_dir . $new_name)) {
            $stmt->execute(['home_hero_bg_image', 'uploads/pages/' . $new_name]);
        }
    }
    
    if (isset($_FILES['home_partnership_logo']) && $_FILES['home_partnership_logo']['error'] === UPLOAD_ERR_OK) {
        $name = basename($_FILES['home_partnership_logo']['name']);
        $new_name = 'partner_logo_' . time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $name);
        if (move_uploaded_file($_FILES['home_partnership_logo']['tmp_name'], $upload_dir . $new_name)) {
            $stmt->execute(['home_partnership_logo', 'uploads/pages/' . $new_name]);
        }
    }
    
    $message = "Home page content updated successfully!";
}

$settings_raw = $pdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll(PDO::FETCH_KEY_PAIR);

$page_title = 'Edit Home Page - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Edit Home Page Content</h1>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium animate-fade-up"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="glass-panel p-8 rounded-2xl mb-10 max-w-3xl animate-fade-up stagger-1">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="save_home">
                
                <div>
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Hero Section Background</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Overlay Background Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="home_hero_bg_color" value="<?= htmlspecialchars($settings_raw['home_hero_bg_color'] ?? '#000000') ?>" class="w-12 h-12 rounded cursor-pointer border-0 p-0">
                                <span class="text-xs text-slate-500">Dark tint covering the image.</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Primary Background Image</label>
                            <?php if(!empty($settings_raw['home_hero_bg_image'])): ?>
                                <img src="../<?= htmlspecialchars($settings_raw['home_hero_bg_image']) ?>" class="h-10 w-auto mb-2 rounded border border-slate-200 object-cover">
                            <?php endif; ?>
                            <input type="file" name="home_hero_bg_image" accept="image/*" class="w-full px-2 py-1 rounded-xl border border-slate-200 text-sm">
                        </div>
                    </div>

                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Hero Text</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hero Title</label>
                            <input type="hidden" name="home_hero_title" id="home_hero_title_input">
                            <div class="mb-4">
                                <div id="quill-hero-title" class="bg-white" style="height: 150px;"><?= $settings_raw['home_hero_title'] ?? '' ?></div>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Use the toolbar color picker to highlight specific words.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hero Subtitle</label>
                            <input type="hidden" name="home_hero_subtitle" id="home_hero_subtitle_input">
                            <div class="mb-8">
                                <div id="quill-hero-subtitle" class="bg-white" style="height: 150px;"><?= $settings_raw['home_hero_subtitle'] ?? '' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Video Section</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Video Embed URL (e.g. YouTube/Streamable)</label>
                            <input type="url" name="home_video_url" value="<?= htmlspecialchars($settings_raw['home_video_url'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Video Header Title</label>
                            <input type="text" name="home_video_title" value="<?= htmlspecialchars($settings_raw['home_video_title'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Video Header Subtitle</label>
                            <textarea name="home_video_subtitle" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none"><?= htmlspecialchars($settings_raw['home_video_subtitle'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Donation / Impact Tiers</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tier 1 -->
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-4">
                            <h4 class="font-bold text-slate-700 text-sm">Tier 1</h4>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Amount ($)</label>
                                <input type="number" name="donate_tier_1_amt" value="<?= htmlspecialchars($settings_raw['donate_tier_1_amt'] ?? '10') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none step="1">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Description (e.g. Edu-Kit)</label>
                                <input type="text" name="donate_tier_1_desc" value="<?= htmlspecialchars($settings_raw['donate_tier_1_desc'] ?? 'Edu-Kit (Stationery)') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                        </div>
                        <!-- Tier 2 -->
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-4">
                            <h4 class="font-bold text-slate-700 text-sm">Tier 2</h4>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Amount ($)</label>
                                <input type="number" name="donate_tier_2_amt" value="<?= htmlspecialchars($settings_raw['donate_tier_2_amt'] ?? '25') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none step="1">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Description</label>
                                <input type="text" name="donate_tier_2_desc" value="<?= htmlspecialchars($settings_raw['donate_tier_2_desc'] ?? 'CBT Exam Fee') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                        </div>
                        <!-- Tier 3 -->
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-4">
                            <h4 class="font-bold text-slate-700 text-sm">Tier 3</h4>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Amount ($)</label>
                                <input type="number" name="donate_tier_3_amt" value="<?= htmlspecialchars($settings_raw['donate_tier_3_amt'] ?? '50') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none step="1">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Description</label>
                                <input type="text" name="donate_tier_3_desc" value="<?= htmlspecialchars($settings_raw['donate_tier_3_desc'] ?? 'Orphanage Meal Plan') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                        </div>
                        <!-- Tier 4 -->
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-4">
                            <h4 class="font-bold text-slate-700 text-sm">Tier 4</h4>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Amount ($)</label>
                                <input type="number" name="donate_tier_4_amt" value="<?= htmlspecialchars($settings_raw['donate_tier_4_amt'] ?? '100') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none step="1">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Description</label>
                                <input type="text" name="donate_tier_4_desc" value="<?= htmlspecialchars($settings_raw['donate_tier_4_desc'] ?? 'SME Micro-Grant') ?>" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Strategic Partnership</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Partnership Tag</label>
                            <input type="text" name="home_partnership_tag" value="<?= htmlspecialchars($settings_raw['home_partnership_tag'] ?? 'Strategic Partnership') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Partnership Title</label>
                            <input type="text" name="home_partnership_title" value="<?= htmlspecialchars($settings_raw['home_partnership_title'] ?? 'Empowering Education with <span class="text-blue-600">Openclax</span>') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none font-mono text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Partner Logo</label>
                            <?php if(!empty($settings_raw['home_partnership_logo'])): ?>
                                <img src="../<?= htmlspecialchars($settings_raw['home_partnership_logo']) ?>" class="h-10 w-auto mb-2 rounded border border-slate-200 object-contain">
                            <?php endif; ?>
                            <input type="file" name="home_partnership_logo" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Partnership Description (Allows Bullet Points)</label>
                            <input type="hidden" name="home_partnership_desc" id="home_partnership_desc_input">
                            <div class="mb-4">
                                <div id="quill-partnership-desc" class="bg-white" style="height: 200px;"><?= $settings_raw['home_partnership_desc'] ?? '<p>We are proud to announce our strategic alliance with <strong>Openclax</strong>...</p>' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 transition">Save Home Page</button>
                    <button type="reset" class="bg-slate-200 text-slate-700 font-bold py-3 px-8 rounded-xl hover:bg-slate-300 transition">Reset Form</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        var toolbarOptions = [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['clean']
        ];

        var quillHeroTitle = new Quill('#quill-hero-title', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });

        var quillHeroSubtitle = new Quill('#quill-hero-subtitle', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });

        var quillPartnershipDesc = new Quill('#quill-partnership-desc', {
            theme: 'snow',
            modules: { toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ] }
        });

        document.querySelector('form').onsubmit = function() {
            document.querySelector('#home_hero_title_input').value = quillHeroTitle.root.innerHTML;
            document.querySelector('#home_hero_subtitle_input').value = quillHeroSubtitle.root.innerHTML;
            document.querySelector('#home_partnership_desc_input').value = quillPartnershipDesc.root.innerHTML;
        };
    </script>
</body>
</html>
