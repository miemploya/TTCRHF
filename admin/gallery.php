<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';
$upload_dir = '../uploads/gallery/';

// Ensure upload directory exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle Add Image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $display_order = (int)($_POST['display_order'] ?? 0);
    
    // Handle File Upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        // Sanitize filename
        $name = preg_replace("/[^a-zA-Z0-9.\-_]/", "", $name);
        $new_name = time() . '_' . $name;
        $target_file = $upload_dir . $new_name;
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($imageFileType, $allowed)) {
            if (move_uploaded_file($tmp_name, $target_file)) {
                $image_path = 'uploads/gallery/' . $new_name;
            } else {
                $message = "Error uploading image.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, GIF, WEBP allowed.";
        }
    } else {
        $message = "Please select an image.";
    }
    
    if (empty($message) && !empty($image_path)) {
        $stmt = $pdo->prepare("INSERT INTO gallery (title, image_path, display_order) VALUES (?, ?, ?)");
        if ($stmt->execute([$title, $image_path, $display_order])) {
            $message = "Image added successfully!";
        } else {
            $message = "Database error.";
        }
    }
}

// Handle Delete Image
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetch();
    
    if ($img) {
        if (!empty($img['image_path']) && file_exists('../' . $img['image_path'])) {
            unlink('../' . $img['image_path']);
        }
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        $message = "Image deleted successfully!";
    }
}

// Fetch gallery
$gallery = $pdo->query("SELECT * FROM gallery ORDER BY display_order ASC, created_at DESC")->fetchAll();
?>
<?php
$page_title = 'Manage Gallery - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Manage Gallery</h1>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium animate-fade-up"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Add Image Form -->
        <div class="glass-panel p-8 rounded-2xl mb-10 animate-fade-up stagger-1">
            <h2 class="text-xl font-bold mb-6 font-heading">Upload New Image</h2>
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="add">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Title / Caption</label>
                        <input type="text" name="title" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Display Order (0=first)</label>
                        <input type="number" name="display_order" value="0" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Select Image File</label>
                    <input type="file" name="image" accept="image/*" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                </div>
                <div class="pt-4 flex gap-4">
                    <button type="submit" class="bg-maroon-600 text-white font-bold py-2 px-6 rounded-xl hover:bg-maroon-700 transition">Upload Image</button>
                    <button type="reset" class="bg-slate-200 text-slate-700 font-bold py-2 px-6 rounded-xl hover:bg-slate-300 transition">Reset Form</button>
                </div>
            </form>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 animate-fade-up stagger-2">
            <?php if (empty($gallery)): ?>
                <div class="col-span-full p-8 text-center text-slate-500 bg-white rounded-2xl border border-slate-100">No images in gallery</div>
            <?php else: ?>
                <?php foreach ($gallery as $g): ?>
                <div class="glass-panel rounded-2xl overflow-hidden group hover:-translate-y-2 transition-all duration-300">
                    <img src="../<?= htmlspecialchars($g['image_path']) ?>" class="w-full h-48 object-cover" alt="Gallery Image">
                    <div class="p-4">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2 truncate"><?= htmlspecialchars($g['title']) ?: 'Untitled' ?></h4>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Order: <?= $g['display_order'] ?></span>
                            <a href="?delete=<?= $g['id'] ?>" onclick="return confirm('Delete this image?')" class="text-red-500 hover:text-red-700 font-bold">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
