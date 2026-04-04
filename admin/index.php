<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

// Fetch quick stats
$total_events = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$total_gallery = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$total_donations = $pdo->query("SELECT SUM(amount) FROM donations WHERE status='success'")->fetchColumn() ?: 0;

$page_title = 'Dashboard Overview - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-12 animate-fade-up">
            <div>
                <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Overview</h1>
                <p class="text-slate-500 font-medium mt-1">Welcome back, <?= htmlspecialchars($_SESSION['username']) ?></p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-maroon-100 to-maroon-50 border border-maroon-200 text-maroon-700 flex items-center justify-center font-black text-xl shadow-sm transform hover:scale-105 transition-transform duration-300 font-heading">
                    <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div class="glass-panel p-8 rounded-[2rem] flex items-center gap-6 animate-fade-up stagger-1 group hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-blue-500/30 font-heading group-hover:scale-110 transition-transform"><?= $total_events ?></div>
                <div>
                    <h3 class="text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">Total Events</h3>
                    <p class="text-slate-800 font-medium">Campaigns & Outreach</p>
                </div>
            </div>
            <div class="glass-panel p-8 rounded-[2rem] flex items-center gap-6 animate-fade-up stagger-2 group hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-purple-500/30 font-heading group-hover:scale-110 transition-transform"><?= $total_gallery ?></div>
                <div>
                    <h3 class="text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">Gallery Media</h3>
                    <p class="text-slate-800 font-medium">Images Uploaded</p>
                </div>
            </div>
            <div class="glass-panel p-8 rounded-[2rem] flex items-center gap-6 animate-fade-up stagger-3 group hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-emerald-500/30 font-heading group-hover:scale-110 transition-transform">$</div>
                <div>
                    <h3 class="text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">Total Donations</h3>
                    <p class="text-3xl font-black font-heading text-slate-800 tracking-tight">$<?= number_format($total_donations, 2) ?></p>
                </div>
            </div>
        </div>

    </main>
</body>
</html>
