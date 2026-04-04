<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';
$upload_dir = '../uploads/partners/';

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle Add Partner
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $display_order = $_POST['display_order'] ?? 0;
    
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK && !empty($name)) {
        $filename = basename($_FILES['logo']['name']);
        $new_name = 'partner_' . time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $filename);
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $new_name)) {
            $stmt = $pdo->prepare("INSERT INTO partners (name, description, image_path, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $description, 'uploads/partners/' . $new_name, $display_order]);
            $message = "Partner added successfully!";
        } else {
            $message = "Error uploading logo.";
        }
    } else {
        $message = "Name and Logo are required.";
    }
}

// Handle Delete Partner
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT image_path FROM partners WHERE id = ?");
    $stmt->execute([$id]);
    $partner = $stmt->fetch();
    
    if ($partner) {
        if (file_exists('../' . $partner['image_path'])) {
            unlink('../' . $partner['image_path']);
        }
        $pdo->prepare("DELETE FROM partners WHERE id = ?")->execute([$id]);
        $message = "Partner deleted successfully!";
    }
}

$partners = $pdo->query("SELECT * FROM partners ORDER BY display_order ASC, created_at DESC")->fetchAll();
?>
<?php include 'includes/header.php'; ?>

    <main class="flex-1 p-4 md:p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Manage Partners</h1>
            <p class="text-slate-500 mt-2 md:mt-0 font-medium text-sm">Upload logos and descriptions for the Home Page 'Small Boxes' module.</p>
        </header>
                
                <?php if($message): ?>
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                    <?= htmlspecialchars($message) ?>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    
                    <!-- Add Partner Form -->
                    <div class="xl:col-span-1">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-xl font-bold text-slate-800 mb-6">Add New Partner</h2>
                            
                            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                                <input type="hidden" name="action" value="add">
                                
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Partner Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Partner Logo Image <span class="text-red-500">*</span></label>
                                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center hover:bg-slate-50 transition cursor-pointer">
                                        <input type="file" name="logo" accept="image/*" required class="w-full">
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2">Transparent PNG or SVG recommended. Max 2MB.</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Short Description</label>
                                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm" placeholder="e.g. Empowering public schools with free computer-based testing resources."></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Display Order</label>
                                    <input type="number" name="display_order" value="0" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                                </div>
                                
                                <div class="pt-4 flex gap-4">
                                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition w-full">Upload Partner</button>
                                    <button type="reset" class="bg-slate-200 text-slate-700 font-bold py-3 px-6 rounded-xl hover:bg-slate-300 transition w-full">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Partners List -->
                    <div class="xl:col-span-2">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-xl font-bold text-slate-800 mb-6">Active Partners</h2>
                            
                            <?php if(empty($partners)): ?>
                                <p class="text-slate-500 text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-200">No partner organizations added yet. Use the form to add some!</p>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <?php foreach($partners as $p): ?>
                                    <div class="border border-slate-200 rounded-2xl p-6 relative group hover:border-blue-500 hover:shadow-lg transition-all flex flex-col items-center text-center">
                                        <div class="h-20 flex items-center justify-center mb-4">
                                            <img src="../<?= htmlspecialchars($p['image_path']) ?>" class="max-h-full max-w-full object-contain mix-blend-multiply drop-shadow-sm filter">
                                        </div>
                                        <h3 class="font-bold text-lg text-slate-800 mb-2"><?= htmlspecialchars($p['name']) ?></h3>
                                        <p class="text-sm text-slate-500 mb-4 font-light leading-relaxed flex-grow"><?= htmlspecialchars($p['description']) ?></p>
                                        
                                        <div class="flex justify-between items-center w-full pt-4 border-t border-slate-100">
                                            <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full font-medium">Order: <?= $p['display_order'] ?></span>
                                            <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to remove this partner?')" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg hover:bg-red-100 transition">
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
