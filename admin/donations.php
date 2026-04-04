<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$donations = $pdo->query("SELECT * FROM donations ORDER BY created_at DESC")->fetchAll();
?>
<?php
$page_title = 'Donations - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Donation Records</h1>
        </header>

        <div class="glass-panel rounded-2xl overflow-hidden animate-fade-up stagger-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 border-b border-slate-200/50 flex flex-col md:table-row font-heading text-sm text-slate-500 uppercase tracking-widest">
                        <th class="p-4 font-bold">Donor Name</th>
                        <th class="p-4 font-semibold">Email</th>
                        <th class="p-4 font-semibold">Amount</th>
                        <th class="p-4 font-semibold">Reference</th>
                        <th class="p-4 font-semibold">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($donations)): ?>
                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No donations yet</td></tr>
                    <?php else: ?>
                        <?php foreach ($donations as $d): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="p-4 font-medium"><?= htmlspecialchars($d['donor_name']) ?></td>
                            <td class="p-4 text-sm text-slate-600"><?= htmlspecialchars($d['email']) ?></td>
                            <td class="p-4 text-sm font-bold text-green-600">$<?= number_format($d['amount'], 2) ?></td>
                            <td class="p-4 text-xs font-mono text-slate-400"><?= htmlspecialchars($d['reference']) ?></td>
                            <td class="p-4 text-sm text-slate-500"><?= date('M jS, Y', strtotime($d['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
