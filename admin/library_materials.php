<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';
$upload_dir = '../uploads/library/';
$cover_dir = '../uploads/library/covers/';

if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
if (!is_dir($cover_dir)) mkdir($cover_dir, 0777, true);

// Handle Add Material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'active';
    
    $file_path = '';
    $cover_path = '';
    
    // Handle File Upload
    if (isset($_FILES['material_file']) && $_FILES['material_file']['error'] === UPLOAD_ERR_OK) {
        $name = time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", basename($_FILES['material_file']['name']));
        if (move_uploaded_file($_FILES['material_file']['tmp_name'], $upload_dir . $name)) {
            $file_path = 'uploads/library/' . $name;
        } else {
            $message = "Error uploading document file.";
        }
    }
    
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $name = time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", basename($_FILES['cover_image']['name']));
        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_dir . $name)) {
            $cover_path = 'uploads/library/covers/' . $name;
        } else {
            $message = "Error uploading cover image.";
        }
    }
    
    if (empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO library_materials (title, description, file_path, cover_image_path, status) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $file_path, $cover_path, $status])) {
            $message = "Library material added successfully!";
        } else {
            $message = "Database error.";
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT file_path, cover_image_path FROM library_materials WHERE id = ?");
    $stmt->execute([$id]);
    $material = $stmt->fetch();
    
    if ($material) {
        if (!empty($material['file_path']) && file_exists('../' . $material['file_path'])) unlink('../' . $material['file_path']);
        if (!empty($material['cover_image_path']) && file_exists('../' . $material['cover_image_path'])) unlink('../' . $material['cover_image_path']);
        
        $pdo->prepare("DELETE FROM library_materials WHERE id = ?")->execute([$id]);
        $message = "Material deleted successfully!";
    }
}

$materials = $pdo->query("SELECT m.*, (SELECT COUNT(*) FROM library_requests r WHERE r.material_id = m.id) as download_count FROM library_materials m ORDER BY created_at DESC")->fetchAll();
$page_title = 'Manage Library Materials - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Manage Library Materials</h1>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium animate-fade-up"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="glass-panel p-8 rounded-2xl mb-10 animate-fade-up stagger-1">
            <h2 class="text-xl font-bold mb-6 font-heading">Publish New Material</h2>
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="add">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none"></textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Document File (PDF, DOCX) <span class="text-red-500">*</span></label>
                        <input type="file" name="material_file" required accept=".pdf,.doc,.docx" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Cover Image (Optional)</label>
                        <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                </div>
                <div class="pt-4 flex gap-4">
                    <button type="submit" class="bg-maroon-600 text-white font-bold py-2 px-6 rounded-xl hover:bg-maroon-700 transition">Upload Material</button>
                    <button type="reset" class="bg-slate-200 text-slate-700 font-bold py-2 px-6 rounded-xl hover:bg-slate-300 transition">Reset Form</button>
                </div>
            </form>
        </div>

        <div class="glass-panel rounded-2xl overflow-hidden animate-fade-up stagger-2">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 border-b border-slate-200/50 text-sm text-slate-500 uppercase tracking-widest font-heading">
                        <th class="p-4 font-bold">Material</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold">Downloads</th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($materials)): ?>
                        <tr><td colspan="4" class="p-4 text-center text-slate-500">No materials found</td></tr>
                    <?php else: foreach ($materials as $m): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <?php if(!empty($m['cover_image_path'])): ?>
                                        <img src="../<?= htmlspecialchars($m['cover_image_path']) ?>" class="w-12 h-16 object-cover rounded shadow-sm">
                                    <?php else: ?>
                                        <div class="w-12 h-16 bg-slate-200 rounded flex items-center justify-center text-slate-400 text-xs font-bold">FILE</div>
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-bold text-slate-800"><?= htmlspecialchars($m['title']) ?></p>
                                        <p class="text-xs text-slate-500 max-w-sm truncate"><?= htmlspecialchars($m['description']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs font-bold <?= $m['status'] == 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-700' ?>">
                                    <?= ucfirst($m['status']) ?>
                                </span>
                            </td>
                            <td class="p-4 font-bold text-maroon-600"><?= $m['download_count'] ?> Requests</td>
                            <td class="p-4 text-right">
                                <a href="../<?= htmlspecialchars($m['file_path']) ?>" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm font-bold mr-3">View</a>
                                <a href="?delete=<?= $m['id'] ?>" onclick="return confirm('Delete this material?')" class="text-red-500 hover:text-red-700 text-sm font-bold">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
