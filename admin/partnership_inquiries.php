<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

// Handle Action
if (isset($_GET['mark_contacted'])) {
    $id = (int)$_GET['mark_contacted'];
    $pdo->prepare("UPDATE partnership_inquiries SET status = 'contacted' WHERE id = ?")->execute([$id]);
    header("Location: partnership_inquiries.php?msg=" . urlencode("Status Updated"));
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM partnership_inquiries WHERE id = ?")->execute([$id]);
    header("Location: partnership_inquiries.php?msg=" . urlencode("Inquiry Deleted"));
    exit;
}

$inquiries = $pdo->query("SELECT * FROM partnership_inquiries ORDER BY created_at DESC")->fetchAll();
$msg = $_GET['msg'] ?? '';

$page_title = 'Partnership Inquiries - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Partnership Inquiries</h1>
        </header>

        <?php if ($msg): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium animate-fade-up"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <div class="glass-panel rounded-2xl overflow-hidden animate-fade-up stagger-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 border-b border-slate-200/50 flex flex-col md:table-row font-heading text-sm text-slate-500 uppercase tracking-widest">
                        <th class="p-4 font-bold">Organization / Name</th>
                        <th class="p-4 font-bold">Contact Info</th>
                        <th class="p-4 font-bold w-1/3">Message</th>
                        <th class="p-4 font-bold text-right">Status & Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inquiries)): ?>
                        <tr><td colspan="4" class="p-4 text-center text-slate-500 font-medium">No partnership inquiries received yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($inquiries as $inq): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 group transition-colors">
                            <td class="p-4 align-top">
                                <div class="font-bold text-slate-800"><?= htmlspecialchars($inq['organization_name']) ?></div>
                                <div class="text-sm font-medium text-slate-600 mt-1"><?= htmlspecialchars($inq['contact_name']) ?></div>
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-2"><?= date('M jS, Y', strtotime($inq['created_at'])) ?></div>
                            </td>
                            <td class="p-4 align-top">
                                <div class="text-sm font-medium text-slate-600"><a href="mailto:<?= htmlspecialchars($inq['email']) ?>" class="text-blue-600 hover:underline"><?= htmlspecialchars($inq['email']) ?></a></div>
                                <div class="text-xs text-slate-500 mt-1"><?= htmlspecialchars($inq['phone']) ?></div>
                                <?php if(!empty($inq['partnership_amount'])): ?>
                                    <div class="mt-2 bg-green-50 text-green-700 text-xs font-bold px-2 py-1 rounded inline-block border border-green-100">
                                        <?= htmlspecialchars($inq['partnership_amount']) ?> (<?= htmlspecialchars($inq['donation_frequency']) ?>) - <?= htmlspecialchars($inq['partnership_period']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 align-top max-w-sm">
                                <div class="text-sm text-slate-500 leading-relaxed max-h-24 overflow-y-auto custom-scrollbar pr-2"><?= nl2br(htmlspecialchars($inq['message'] ?? 'No message provided.')) ?></div>
                            </td>
                            <td class="p-4 align-top">
                                <div class="flex items-center justify-end gap-3">
                                    <?php if ($inq['status'] === 'pending'): ?>
                                        <span class="px-2 py-1 bg-amber-50 text-amber-600 rounded-md text-xs font-bold ring-1 ring-amber-200 uppercase tracking-widest">Pending</span>
                                        <a href="?mark_contacted=<?= $inq['id'] ?>" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition px-3 py-1.5 rounded-lg hover:bg-blue-50">Mark Read</a>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded-md text-xs font-bold ring-1 ring-slate-200 uppercase tracking-widest">Read & Contacted</span>
                                    <?php endif; ?>
                                    <span class="text-slate-300">|</span>
                                    <a href="?delete=<?= $inq['id'] ?>" onclick="return confirm('Delete this partnership request permanently?')" class="text-sm font-bold text-red-500 hover:text-red-700 transition px-2 py-1.5 rounded-lg hover:bg-red-50">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
