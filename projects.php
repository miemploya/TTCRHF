<?php 
require_once 'includes/db_connect.php'; 
require_once 'includes/helpers.php'; 

$projects_title = $site_settings['projects_header_title'] ?? 'Impact Pillars';
$projects_desc = $site_settings['projects_header_desc'] ?? 'A systemic breakdown of our core operational domains across Edo State, delivering generational empowerment through strategic, focused intervention scopes.';
$projects_bg = $site_settings['projects_bg_color'] ?? '#f8fafc'; // Tailwind slate-50

$pillars = $pdo->query("SELECT * FROM impact_pillars ORDER BY display_order ASC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects | The Tribe Called Roots Humanitarian Foundation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- International Standard Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        maroon: {
                            50: 'color-mix(in srgb, var(--brand-primary) 5%, white)',
                            100: 'color-mix(in srgb, var(--brand-primary) 10%, white)',
                            200: 'color-mix(in srgb, var(--brand-primary) 30%, white)',
                            300: 'color-mix(in srgb, var(--brand-primary) 50%, white)',
                            400: 'color-mix(in srgb, var(--brand-primary) 70%, white)',
                            500: 'color-mix(in srgb, var(--brand-primary) 85%, white)',
                            600: 'var(--brand-primary)',
                            700: 'color-mix(in srgb, var(--brand-primary) 80%, black)',
                            800: 'color-mix(in srgb, var(--brand-primary) 60%, black)',
                            900: 'color-mix(in srgb, var(--brand-primary) 40%, black)',
                            950: 'color-mix(in srgb, var(--brand-primary) 20%, black)',
                        },
                    },
                },
            },
        }
    </script>
    <style>
        :root {
            --brand-primary: <?= $brand_color_hex ?>;
        }
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        h1, h2, h3, h4, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        .logo-svg { width: 100%; height: 100%; fill: currentColor; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-lg border-b border-slate-200 dark:bg-slate-900/95 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                <a href="index.php" class="flex items-center gap-4 cursor-pointer">
                    <div class="w-16 h-16 transition-colors duration-300 rounded-full overflow-hidden border-2 border-slate-900 dark:border-white">
                        <img src="<?= htmlspecialchars($site_logo) ?>" alt="TTCRHF Logo" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xl tracking-tight leading-none font-heading uppercase" style="color: <?= htmlspecialchars($nav_title_color) ?>">TTCRHF</span>
                        <span class="text-[9px] font-bold tracking-[0.1em] uppercase" style="color: <?= htmlspecialchars($nav_subtitle_color) ?>">The Tribe Called Roots</span>
                    </div>
                </a>
                
                <div class="hidden md:flex space-x-8 font-semibold text-slate-600 dark:text-slate-400 text-sm items-center text-left">
                    <a href="index.php" class="hover:text-maroon-600 transition-all py-2">Home</a>
                    <a href="about.php" class="hover:text-maroon-600 transition-all py-2">About Us</a>
                    <a href="events.php" class="hover:text-maroon-600 transition-all py-2">Events</a>
                    <a href="projects.php" class="text-maroon-600 border-b-2 border-maroon-600 py-2">Projects</a>
                    <a href="gallery.php" class="hover:text-maroon-600 transition-all py-2">Gallery</a>
                    <?php if (!isset($site_settings['show_library_page']) || $site_settings['show_library_page'] == '1'): ?>
                    <a href="library.php" class="hover:text-maroon-600 transition-all py-2">Library</a>
                    <?php endif; ?>
                    <?php 
                    $dynamic_nav = $pdo->query("SELECT title, slug FROM custom_pages WHERE show_in_nav = 1 ORDER BY created_at ASC")->fetchAll();
                    foreach($dynamic_nav as $dn): 
                    ?>
                        <a href="page.php?slug=<?= htmlspecialchars($dn['slug']) ?>" class="hover:text-maroon-600 transition-all py-2"><?= htmlspecialchars($dn['title']) ?></a>
                    <?php endforeach; ?>
                    
                    <button onclick="toggleTheme()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-maroon-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Sections -->
    <main class="pt-24 min-h-screen transition-colors duration-500" style="background-color: <?= htmlspecialchars($projects_bg) ?>;">
        
        <!-- PROJECTS PAGE CONTENT -->
        <section class="page-section py-24 px-4 max-w-7xl mx-auto">
            <div class="text-center mb-20 animate-fade-in-up">
                <span class="inline-block px-5 py-2 rounded-full bg-maroon-100/50 dark:bg-maroon-900/30 text-maroon-600 dark:text-maroon-400 font-bold tracking-widest text-[11px] uppercase mb-6 shadow-sm border border-maroon-200 dark:border-maroon-800">Our Operations</span>
                <h1 class="text-6xl md:text-8xl font-black mb-6 text-slate-900 dark:text-white font-heading tracking-tight"><?= htmlspecialchars($projects_title) ?></h1>
                <p class="text-lg md:text-2xl text-slate-500 dark:text-slate-400 max-w-3xl mx-auto font-light leading-relaxed"><?= htmlspecialchars($projects_desc) ?></p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 text-left">
                <?php $delay = 100; foreach($pillars as $p): ?>
                <div class="group relative bg-white dark:bg-slate-900/80 backdrop-blur-sm p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 hover:-translate-y-4 hover:shadow-2xl hover:shadow-maroon-600/10 hover:border-maroon-500/30 transition-all duration-500 card-animate" style="animation-delay: <?= $delay ?>ms;">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-maroon-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-[2.5rem] pointer-events-none"></div>
                    
                    <div class="w-16 h-16 bg-maroon-50 dark:bg-maroon-900/40 text-maroon-600 dark:text-maroon-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-maroon-600 group-hover:text-white transition-all duration-500 transform group-hover:-rotate-3 group-hover:scale-110 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-4 text-slate-900 dark:text-white font-heading group-hover:text-maroon-700 dark:group-hover:text-maroon-400 transition-colors"><?= htmlspecialchars($p['title']) ?></h3>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                </div>
                <?php $delay += 100; endforeach; ?>
            </div>
            
            <?php if(empty($pillars)): ?>
            <div class="text-center py-20 bg-white/50 dark:bg-slate-900/30 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700 max-w-2xl mx-auto">
                <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-slate-500 dark:text-slate-400 font-medium tracking-wide">Infrastructure matrix offline. Awaiting Super Admin blueprints.</p>
            </div>
            <?php endif; ?>
        </section>

    </main>
    <style>
        .animate-fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .card-animate { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        @keyframes fadeInUp { 
            0% { opacity: 0; transform: translateY(30px) scale(0.98); } 
            100% { opacity: 1; transform: translateY(0) scale(1); } 
        }
    </style>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 transition-colors duration-300 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 text-left">
            <div class="grid md:grid-cols-4 gap-16 mb-16">
                <div class="col-span-1">
                    <div class="flex items-center gap-4 mb-8 text-white">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white">
                            <img src="<?= htmlspecialchars($site_logo) ?>" alt="TTCRHF Logo" class="w-full h-full object-cover">
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white uppercase font-heading">TTCRHF</span>
                    </div>
                </div>
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase text-xs font-heading">Contacts</h4>
                    <p class="text-sm font-light leading-relaxed">📍 <?= htmlspecialchars($site_settings['contact_address'] ?? '') ?><br>📞 <?= htmlspecialchars($site_settings['contact_phone'] ?? '') ?><br>✉️ <?= htmlspecialchars($site_settings['contact_email'] ?? '') ?></p>
                </div>
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase text-xs font-heading">Legacy</h4>
                    <p class="text-sm font-light leading-relaxed">Our Mission<br>CBT Initiative<br>Economic Growth</p>
                </div>
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase text-xs font-heading">Official Website</h4>
                    <p class="text-sm font-light text-maroon-400 underline italic font-heading">thetribecalledroots.org</p>
                </div>
            </div>
            <div class="pt-12 border-t border-white/5 text-[9px] font-bold tracking-[0.3em] uppercase text-center">
                &copy; 2026 The Tribe Called Roots Humanitarian Foundation.
            </div>
        </div>
    </footer>

    <script>
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            const theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
        }
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</body>
</html>
