<?php
$current_page = basename($_SERVER['PHP_SELF']);
$nav_items = [
    'index.php' => 'Dashboard',
    'settings.php' => 'Global Settings',
    'page_home.php' => 'Home Page Content',
    'page_about.php' => 'About Page Content',
    'pages.php' => 'Manage Custom Pages',
    'partners.php' => 'Manage Partners',
    'projects.php' => 'Manage Projects',
    'events.php' => 'Manage Events',
    'gallery.php' => 'Manage Gallery',
    'library_materials.php' => 'Library Materials',
    'library_requests.php' => 'Library Requests',
    'physical_requests.php' => 'Physical Copy Requests',
    'donations.php' => 'Donations',
    'inquiries.php' => 'Inquiry Inbox',
    'partnership_inquiries.php' => 'Partnership Inbox'
];
?>
<aside class="w-64 bg-white/70 backdrop-blur-2xl border-r border-slate-200/60 shadow-[4px_0_24px_rgba(0,0,0,0.02)] min-h-screen flex flex-col hidden md:flex fixed h-full z-20 transition-all duration-300">
    <div class="h-20 flex items-center px-4 border-b border-slate-200/50 bg-gradient-to-r relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-maroon-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-maroon-600 to-maroon-800 text-white flex items-center justify-center font-black mr-2 shadow-sm transform group-hover:scale-105 transition-transform duration-300 font-heading text-base">T</div>
        <div class="flex flex-col">
            <span class="font-heading font-black text-base tracking-tight text-slate-800 leading-none">TTCRHF</span>
            <span class="text-[8px] font-bold text-slate-400 tracking-widest uppercase mt-0.5">Super Admin</span>
        </div>
    </div>
    <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto custom-scrollbar">
        <?php foreach ($nav_items as $url => $label): 
            $isActive = ($current_page === $url);
            if ($url === 'events.php'): ?>
                <div class="h-px bg-slate-200/50 my-4 mx-2 relative">
                    <span class="absolute -top-2 left-2 bg-white/70 px-1 text-[9px] font-bold text-slate-400 uppercase tracking-widest backdrop-blur-md">Modules</span>
                </div>
            <?php endif; ?>
            
            <a href="<?= $url ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition-all duration-300 relative overflow-hidden group <?= $isActive ? 'bg-maroon-50 text-maroon-700 shadow-[inset_0_2px_4px_rgba(160,28,28,0.05)]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                <?php if($isActive): ?>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-maroon-600 rounded-r-md"></div>
                <?php endif; ?>
                <span class="relative z-10 font-heading text-[13px]"><?= htmlspecialchars($label) ?></span>
                <?php if(!$isActive): ?>
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="p-5 border-t border-slate-200/50 bg-slate-50/30">
        <a href="logout.php" class="flex items-center justify-center w-full px-4 py-3 border border-slate-200/80 text-slate-600 rounded-xl hover:bg-white hover:border-red-200 hover:shadow-sm transition-all duration-300 text-sm font-bold group bg-white/50 backdrop-blur-sm">
            <span class="group-hover:text-red-600 transition-colors font-heading tracking-wide">Secure Logout</span>
        </a>
    </div>
</aside>
