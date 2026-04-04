<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';

// Add Page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    // Generate slug from title if not provided
    $slug = $_POST['slug'] ?? '';
    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
    $show_in_nav = isset($_POST['show_in_nav']) ? 1 : 0;
    
    if (!empty($title) && !empty($slug)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO custom_pages (title, slug, show_in_nav) VALUES (?, ?, ?)");
            $stmt->execute([$title, $slug, $show_in_nav]);
            $message = "Page initialized! You can now open the Visual Builder.";
        } catch(PDOException $e) {
            $message = "Error: Slug already exists or database error.";
        }
    }
}

// Delete Page
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $pdo->prepare("DELETE FROM custom_pages WHERE id = ?")->execute([$_GET['delete']]);
    $message = "Page deleted permanently from the core matrix.";
}

$pages = $pdo->query("SELECT * FROM custom_pages ORDER BY created_at DESC")->fetchAll();
$page_title = 'Manage Custom Pages - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-4 md:p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Manage Custom Pages</h1>
            <p class="text-slate-500 mt-2 md:mt-0 font-medium text-sm">Create fresh pages, manage custom URLs, and integrate them into the global navbar.</p>
        </header>
        
        <?php if($message): ?>
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Create Form -->
            <div class="xl:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Initialize Fresh Page</h2>
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="add">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Page Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="e.g. Financial Report 2026" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm trans">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Custom URL String (Optional)</label>
                            <input type="text" name="slug" placeholder="e.g. financial-report-2026" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none text-sm trans">
                            <p class="text-xs text-slate-400 mt-1">Leave blank to inherit auto-generated domain string.</p>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                            <input type="checkbox" name="show_in_nav" id="show_in_nav" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            <label for="show_in_nav" class="text-sm font-semibold text-slate-700 cursor-pointer">Inject Tab into Global Navigation Menu?</label>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition w-full shadow-lg shadow-blue-500/20">Initialize & Route</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Matrix Output -->
            <div class="xl:col-span-2">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Active Page Array</h2>
                    <?php if(empty($pages)): ?>
                        <div class="text-center py-16 rounded-xl border border-dashed border-slate-200 bg-slate-50">
                            <p class="text-slate-500 font-medium tracking-wide">No custom blueprints mapped. Awaiting Super Admin generation.</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-slate-100 text-sm text-slate-400 uppercase tracking-widest">
                                        <th class="pb-4 font-bold">Document Title</th>
                                        <th class="pb-4 font-bold">URL Routing Path</th>
                                        <th class="pb-4 font-bold text-center">Global Navbar</th>
                                        <th class="pb-4 font-bold text-right">Super Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pages as $p): ?>
                                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition duration-300 group">
                                        <td class="py-5 font-bold text-slate-800 tracking-tight"><?= htmlspecialchars($p['title']) ?></td>
                                        <td class="py-5 text-slate-500 text-sm font-mono tracking-tighter">/page.php?slug=<?= htmlspecialchars($p['slug']) ?></td>
                                        <td class="py-5 text-center">
                                            <?= $p['show_in_nav'] ? '<span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full font-bold border border-emerald-300 shadow-sm">ACTIVE</span>' : '<span class="px-3 py-1 bg-slate-100 text-slate-500 text-xs rounded-full font-bold border border-slate-200">HIDDEN</span>' ?>
                                        </td>
                                        <td class="py-5 flex justify-end gap-3 opacity-80 group-hover:opacity-100 transition">
                                            <a href="../page.php?slug=<?= htmlspecialchars($p['slug']) ?>" target="_blank" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 hover:text-slate-900 transition flex items-center gap-1">View Native</a>
                                            <a href="page_builder.php?id=<?= $p['id'] ?>" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-black shadow-lg shadow-slate-900/20 transition flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg> 
                                                Visual Builder
                                            </a>
                                            <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('WARNING: Are you sure you want to completely erase this page array?')" class="px-3 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-500 hover:text-white transition flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
