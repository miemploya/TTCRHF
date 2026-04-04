<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$page_title = 'Library Requests / Downloads - TTCRHF Admin';
require_once 'includes/header.php';

// Fetch requests with material info
$requests = $pdo->query("
    SELECT r.*, m.title as material_title 
    FROM library_requests r
    JOIN library_materials m ON r.material_id = m.id
    ORDER BY r.requested_at DESC
")->fetchAll();
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Library Downloads Tracker</h1>
        </header>

        <div class="glass-panel rounded-2xl overflow-hidden animate-fade-up stagger-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 border-b border-slate-200/50 text-sm text-slate-500 uppercase tracking-widest font-heading">
                        <th class="p-4 font-bold">Date</th>
                        <th class="p-4 font-bold">User Details</th>
                        <th class="p-4 font-bold">Requested Material</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr><td colspan="3" class="p-4 text-center text-slate-500">No requests found yet.</td></tr>
                    <?php else: foreach ($requests as $r): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="p-4 text-sm text-slate-500"><?= date('M j, Y h:i A', strtotime($r['requested_at'])) ?></td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800"><?= htmlspecialchars($r['full_name']) ?></p>
                                <p class="text-sm text-slate-600 block"><a href="mailto:<?= htmlspecialchars($r['email']) ?>" class="text-blue-600 hover:underline"><?= htmlspecialchars($r['email']) ?></a></p>
                                <?php if(!empty($r['phone'])): ?>
                                    <p class="text-sm text-slate-600"><?= htmlspecialchars($r['phone']) ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <span class="bg-maroon-50 text-maroon-700 px-3 py-1 rounded-lg text-sm font-semibold border border-maroon-100">
                                    <?= htmlspecialchars($r['material_title']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
