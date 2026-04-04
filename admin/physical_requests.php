<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $request_id = (int)$_POST['request_id'];
    
    if ($_POST['action'] === 'approve') {
        $due_date = $_POST['due_date'] ?? null;
        if (!empty($due_date)) {
            $stmt = $pdo->prepare("UPDATE physical_book_requests SET status = 'approved', due_date = ? WHERE id = ?");
            $stmt->execute([$due_date, $request_id]);
            $message = "Request approved effectively.";
        } else {
            $message = "Please provide a valid due date to approve.";
        }
    } elseif ($_POST['action'] === 'return') {
        $stmt = $pdo->prepare("UPDATE physical_book_requests SET status = 'returned' WHERE id = ?");
        $stmt->execute([$request_id]);
        $message = "Marked as returned.";
    } elseif ($_POST['action'] === 'reject') {
        $stmt = $pdo->prepare("UPDATE physical_book_requests SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$request_id]);
        $message = "Request denied.";
    }
}

$page_title = 'Physical Copy Requests - TTCRHF Admin';
require_once 'includes/header.php';

$requests = $pdo->query("
    SELECT r.*, m.title as material_title 
    FROM physical_book_requests r
    JOIN library_materials m ON r.material_id = m.id
    ORDER BY r.requested_at DESC
")->fetchAll();
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Physical hard Copy Requests</h1>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium animate-fade-up"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="glass-panel rounded-2xl overflow-hidden animate-fade-up stagger-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 border-b border-slate-200/50 text-sm text-slate-500 uppercase tracking-widest font-heading">
                        <th class="p-4 font-bold">Details</th>
                        <th class="p-4 font-bold">Contact</th>
                        <th class="p-4 font-bold">ID Upload</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No physical requests found yet.</td></tr>
                    <?php else: foreach ($requests as $r): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="p-4">
                                <p class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($r['full_name']) ?></p>
                                <span class="bg-maroon-50 text-maroon-700 px-2 py-0.5 rounded text-xs font-semibold border border-maroon-100 inline-block mt-1">
                                    <?= htmlspecialchars($r['material_title']) ?>
                                </span>
                                <p class="text-xs text-slate-400 mt-1">Req: <?= date('M j, Y', strtotime($r['requested_at'])) ?></p>
                            </td>
                            <td class="p-4">
                                <p class="text-sm text-slate-600"><a href="mailto:<?= htmlspecialchars($r['email']) ?>" class="text-blue-600 hover:underline"><?= htmlspecialchars($r['email']) ?></a></p>
                                <p class="text-sm text-slate-600"><?= htmlspecialchars($r['phone']) ?></p>
                            </td>
                            <td class="p-4">
                                <a href="../<?= htmlspecialchars($r['id_card_path']) ?>" target="_blank" class="text-blue-600 font-bold hover:underline text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> View ID
                                </a>
                            </td>
                            <td class="p-4">
                                <?php if ($r['status'] == 'pending'): ?>
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">Pending</span>
                                <?php elseif ($r['status'] == 'approved'): ?>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Approved</span><br>
                                    <span class="text-xs text-slate-500 mt-1 block">Due: <?= date('M j', strtotime($r['due_date'])) ?></span>
                                <?php elseif ($r['status'] == 'returned'): ?>
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Returned</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <?php if ($r['status'] == 'pending'): ?>
                                    <form method="POST" class="inline-block mt-1">
                                        <input type="hidden" name="action" value="approve">
                                        <input type="hidden" name="request_id" value="<?= $r['id'] ?>">
                                        <div class="flex items-center gap-2">
                                            <input type="date" name="due_date" required class="text-xs border rounded p-1 w-24">
                                            <button type="submit" class="text-xs bg-blue-600 text-white px-2 py-1 rounded font-bold hover:bg-blue-700">Approve</button>
                                        </div>
                                    </form>
                                    <form method="POST" class="inline-block mt-1">
                                        <input type="hidden" name="action" value="reject">
                                        <input type="hidden" name="request_id" value="<?= $r['id'] ?>">
                                        <button type="submit" onclick="return confirm('Reject request?')" class="text-xs text-red-600 font-bold hover:underline">Reject</button>
                                    </form>
                                <?php elseif ($r['status'] == 'approved'): ?>
                                    <form method="POST" class="inline-block">
                                        <input type="hidden" name="action" value="return">
                                        <input type="hidden" name="request_id" value="<?= $r['id'] ?>">
                                        <button type="submit" onclick="return confirm('Mark book as returned?')" class="text-xs bg-emerald-600 text-white px-3 py-1.5 rounded font-bold hover:bg-emerald-700">Mark Returned</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-xs text-slate-400">Closed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
