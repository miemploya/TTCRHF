<?php
require_once 'includes/db_connect.php';
require_once 'includes/helpers.php';
$gallery = $pdo->query("SELECT * FROM gallery ORDER BY display_order ASC, created_at DESC")->fetchAll();
$partners = $pdo->query("SELECT * FROM partners ORDER BY display_order ASC, created_at DESC")->fetchAll();

$home_bg_img = !empty($site_settings['home_hero_bg_image']) ? $site_settings['home_hero_bg_image'] : 'https://images.unsplash.com/photo-1509059852496-f3822ae057bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80';
$home_bg_hex = $site_settings['home_hero_bg_color'] ?? '#000000';
list($r, $g, $b) = sscanf($home_bg_hex, "#%02x%02x%02x");
$overlay = "rgba($r, $g, $b, 0.7)";
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTCRHF | The Tribe Called Roots Humanitarian Foundation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- International Standard Fonts: Plus Jakarta Sans for Headers, Inter for Body -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
        // Tailwind Configuration for Dark Mode
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
            --brand-primary: <?= htmlspecialchars($site_settings['brand_color'] ?? '#a01c1c') ?>;
            --brand-maroon: #4A0E0E;
            --brand-dark: #064e3b;
        }
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        h1, h2, h3, h4, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { 
            background: linear-gradient(<?= $overlay ?>, <?= $overlay ?>), url('<?= htmlspecialchars($home_bg_img) ?>'); 
            background-size: cover; background-position: center; 
        }
        .hidden { display: none; }
        .active-nav { color: var(--brand-maroon) !important; border-bottom: 2px solid var(--brand-maroon); }
        .stat-card { transition: all 0.3s ease; height: 100%; }
        .stat-card:hover { transform: translateY(-5px); }
        .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 2rem; }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        
        /* Logo SVG Styling */
        .logo-svg { width: 100%; height: 100%; fill: currentColor; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 overflow-x-hidden transition-colors duration-300">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-lg border-b border-slate-200 dark:bg-slate-900/95 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                <div class="flex items-center gap-4 cursor-pointer" onclick="navigateTo('home')">
                    <!-- RECREATED OFFICIAL LOGO AS IMG -->
                    <div class="w-16 h-16 transition-colors duration-300 rounded-full overflow-hidden border-2 border-slate-900 dark:border-white">
                        <img src="<?= htmlspecialchars($card_logo) ?>" alt="TTCRHF Logo" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xl tracking-tight leading-none" style="color: <?= htmlspecialchars($nav_title_color) ?>">TTCRHF</span>
                        <span class="text-[9px] font-bold tracking-[0.1em] uppercase" style="color: <?= htmlspecialchars($nav_subtitle_color) ?>">The Tribe Called Roots</span>
                    </div>
                </div>
                
                <div class="hidden md:flex space-x-8 font-semibold text-slate-600 dark:text-slate-400 text-sm items-center">
                    <a href="index.php" class="nav-link hover:text-maroon-600 transition-all py-2">Home</a>
                    <a href="about.php" class="nav-link hover:text-maroon-600 transition-all py-2">About Us</a>
                    <a href="events.php" class="nav-link hover:text-maroon-600 transition-all py-2">Events</a>
                    <a href="projects.php" class="nav-link hover:text-maroon-600 transition-all py-2">Projects</a>
                    <a href="gallery.php" class="nav-link hover:text-maroon-600 transition-all py-2">Gallery</a>
                    <?php if (!isset($site_settings['show_library_page']) || $site_settings['show_library_page'] == '1'): ?>
                    <a href="library.php" class="nav-link hover:text-maroon-600 transition-all py-2">Library</a>
                    <?php endif; ?>
                    <?php 
                    $dynamic_nav = $pdo->query("SELECT title, slug FROM custom_pages WHERE show_in_nav = 1 ORDER BY created_at ASC")->fetchAll();
                    foreach($dynamic_nav as $dn): 
                    ?>
                        <a href="page.php?slug=<?= htmlspecialchars($dn['slug']) ?>" class="nav-link hover:text-maroon-600 transition-all py-2"><?= htmlspecialchars($dn['title']) ?></a>
                    <?php endforeach; ?>
                    
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-maroon-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                        <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>
                </div>

                <div class="flex items-center gap-4">
                    <button onclick="navigateTo('donate')" class="bg-maroon-600 text-white px-7 py-3 rounded-full font-bold text-sm hover:bg-maroon-700 transition transform hover:scale-105 shadow-xl shadow-maroon-100 dark:shadow-none">Donate Now</button>
                    <button class="md:hidden p-2 text-slate-600 dark:text-slate-400" onclick="toggleMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-6 py-8 space-y-6">
            <a href="index.php" class="block w-full text-left font-bold text-slate-700 dark:text-slate-200 text-lg">Home</a>
            <a href="about.php" class="block w-full text-left font-bold text-slate-700 dark:text-slate-200 text-lg">About Us</a>
            <a href="events.php" class="block w-full text-left font-bold text-slate-700 dark:text-slate-200 text-lg">Events</a>
            <a href="projects.php" class="block w-full text-left font-bold text-slate-700 dark:text-slate-200 text-lg">Projects</a>
            <a href="gallery.php" class="block w-full text-left font-bold text-slate-700 dark:text-slate-200 text-lg">Gallery</a>
            <?php if (!isset($site_settings['show_library_page']) || $site_settings['show_library_page'] == '1'): ?>
            <a href="library.php" class="block w-full text-left font-bold text-slate-700 dark:text-slate-200 text-lg">Library</a>
            <?php endif; ?>
            <?php 
            foreach($dynamic_nav as $dn): 
            ?>
                <a href="page.php?slug=<?= htmlspecialchars($dn['slug']) ?>" class="block w-full text-left font-bold text-slate-700 dark:text-slate-200 text-lg"><?= htmlspecialchars($dn['title']) ?></a>
            <?php endforeach; ?>
            <button onclick="toggleTheme()" class="w-full text-left font-bold text-maroon-600 text-lg py-2 border-t border-slate-100 dark:border-slate-800">Toggle Theme</button>
        </div>
    </nav>

    <!-- Content Sections -->
    <main id="main-content" class="pt-24">
        
        <!-- HOME PAGE -->
        <div id="page-home" class="page-section">
            <!-- Hero -->
            <section class="hero-gradient min-h-[85vh] flex items-center relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center text-white relative z-10">
                    <span class="inline-block bg-maroon-500/20 backdrop-blur-md border border-maroon-400/30 text-maroon-300 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-8">Serving Africa & Beyond</span>
                    <h1 class="text-5xl md:text-8xl font-extrabold mb-8 leading-[1.1] tracking-tight"><?= $site_settings['home_hero_title'] ?? '' ?></h1>
                    <div class="text-lg md:text-2xl mb-12 max-w-3xl mx-auto text-slate-200 font-light leading-relaxed">
                        <?= $site_settings['home_hero_subtitle'] ?? '' ?>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-5 justify-center">
                        <button onclick="navigateTo('projects')" class="bg-maroon-600 text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-maroon-700 transition shadow-2xl shadow-maroon-900/40">Our Interventions</button>
                    </div>
                </div>
            </section>

            <!-- Video Introduction Section -->
            <section class="py-24 bg-white dark:bg-slate-950">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-5xl font-bold mb-4 text-slate-900 dark:text-white"><?= htmlspecialchars($site_settings['home_video_title'] ?? '') ?></h2>
                        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto"><?= htmlspecialchars($site_settings['home_video_subtitle'] ?? '') ?></p>
                    </div>
                    <div class="video-container shadow-2xl dark:shadow-maroon-900/20">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="<?= htmlspecialchars($site_settings['home_video_url'] ?? '') ?>" title="TTCRHF Intro Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </section>

            <!-- Comprehensive Pillar Grid -->
            <section class="py-24 bg-slate-50 dark:bg-slate-900/50">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8 text-left">
                        <div class="max-w-2xl">
                            <span class="font-extrabold tracking-widest uppercase text-lg md:text-xl bg-gradient-to-r from-maroon-600 to-teal-400 bg-clip-text text-transparent block mb-4">Core Focus</span>
                            <h2 class="text-4xl md:text-5xl font-bold mt-4 text-slate-900 dark:text-white leading-tight">Five Pillars of Rural <br>Transformation.</h2>
                        </div>
                        <button onclick="navigateTo('projects')" class="text-maroon-600 dark:text-maroon-400 font-bold flex items-center gap-2 hover:gap-4 transition-all">View Project Details &rarr;</button>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
                        <!-- Community Health Initiatives (Cyan) -->
                        <div class="group h-[22rem] [perspective:1000px] flip-card">
                            <div class="relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-cyan-500/20 flip-inner">
                                <!-- Front Face -->
                                <div class="absolute inset-0 p-10 bg-cyan-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col">
                                    <div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-cyan-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </div>
                                    <h3 class="text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-cyan-600 transition-colors">Community Health</h3>
                                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Promoting wellness through medical outreach and health education initiatives.</p>
                                </div>
                                <!-- Back Face -->
                                <div class="absolute inset-0 bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-cyan-500 shadow-inner">
                                    <div class="bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4">
                                        <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain filter drop-shadow-lg" alt="TTCRHF Logo">
                                    </div>
                                    <h3 class="text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm">Community Health</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Counseling Services (Teal) -->
                        <div class="group h-[22rem] [perspective:1000px] flip-card">
                            <div class="relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-teal-500/20 flip-inner">
                                <!-- Front Face -->
                                <div class="absolute inset-0 p-10 bg-teal-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col">
                                    <div class="w-14 h-14 bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                                    <h3 class="text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-teal-600 transition-colors">Counseling Services</h3>
                                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Providing psychological support and professional guidance for emotional well-being.</p>
                                </div>
                                <!-- Back Face -->
                                <div class="absolute inset-0 bg-gradient-to-br from-teal-600 to-teal-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-teal-500 shadow-inner">
                                    <div class="bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4">
                                        <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain filter drop-shadow-lg" alt="TTCRHF Logo">
                                    </div>
                                    <h3 class="text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm">Counseling Services</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Volunteer Programs (Orange) -->
                        <div class="group h-[22rem] [perspective:1000px] flip-card">
                            <div class="relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-orange-500/20 flip-inner">
                                <!-- Front Face -->
                                <div class="absolute inset-0 p-10 bg-orange-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col">
                                    <div class="w-14 h-14 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-orange-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                            </div>
                                    <h3 class="text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-orange-600 transition-colors">Volunteer Programs</h3>
                                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Mobilizing community members to serve, support, and lift up their neighbors.</p>
                                </div>
                                <!-- Back Face -->
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-orange-500 shadow-inner">
                                    <div class="bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4">
                                        <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain filter drop-shadow-lg" alt="TTCRHF Logo">
                                    </div>
                                    <h3 class="text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm">Volunteer Programs</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Awareness Campaigns (Rose) -->
                        <div class="group h-[22rem] [perspective:1000px] flip-card">
                            <div class="relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-rose-500/20 flip-inner">
                                <!-- Front Face -->
                                <div class="absolute inset-0 p-10 bg-rose-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col">
                                    <div class="w-14 h-14 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.68c.406.406.954.636 1.528.636h3.18a3.25 3.25 0 003.25-3.25v-1.12c0-1.794-1.456-3.25-3.25-3.25h-3.18a2.16 2.16 0 00-1.528.636l-3.327 3.328a1.5 1.5 0 000 2.122l3.327 3.328z" /></svg>
                            </div>
                                    <h3 class="text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-rose-600 transition-colors">Awareness Campaigns</h3>
                                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Educating the public on critical social, health, and developmental issues.</p>
                                </div>
                                <!-- Back Face -->
                                <div class="absolute inset-0 bg-gradient-to-br from-rose-600 to-rose-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-rose-500 shadow-inner">
                                    <div class="bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4">
                                        <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain filter drop-shadow-lg" alt="TTCRHF Logo">
                                    </div>
                                    <h3 class="text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm">Awareness Campaigns</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Infrastructure (Amber) -->
                        <div class="group h-[22rem] [perspective:1000px]">
                            <div class="relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-amber-500/20">
                                <!-- Front Face -->
                                <div class="absolute inset-0 p-10 bg-amber-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col">
                                    <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                                    <h3 class="text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-amber-600 transition-colors">Infrastructure</h3>
                                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Providing solar-powered boreholes and sustainable community lighting for rural Edo safe-zones.</p>
                                </div>
                                <!-- Back Face -->
                                <div class="absolute inset-0 bg-gradient-to-br from-amber-600 to-amber-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-amber-500 shadow-inner">
                                    <div class="bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4">
                                        <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain filter drop-shadow-lg" alt="TTCRHF Logo">
                                    </div>
                                    <h3 class="text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm">Infrastructure</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Orphanage Support (Pink) -->
                        <div class="group h-[22rem] [perspective:1000px]">
                            <div class="relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-pink-500/20">
                                <!-- Front Face -->
                                <div class="absolute inset-0 p-10 bg-pink-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col">
                                    <div class="w-14 h-14 bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-pink-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </div>
                                    <h3 class="text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-pink-600 transition-colors">Orphanage Support</h3>
                                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Comprehensive welfare reaches including structural aid, nutritional supply, and healthcare.</p>
                                </div>
                                <!-- Back Face -->
                                <div class="absolute inset-0 bg-gradient-to-br from-pink-600 to-pink-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-pink-500 shadow-inner">
                                    <div class="bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4">
                                        <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain filter drop-shadow-lg" alt="TTCRHF Logo">
                                    </div>
                                    <h3 class="text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm">Orphanage Support</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Empowerment Grants (Emerald) -->
                        <div class="group h-[22rem] [perspective:1000px]">
                            <div class="relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-maroon-500/20">
                                <!-- Front Face -->
                                <div class="absolute inset-0 p-10 bg-maroon-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col">
                                    <div class="w-14 h-14 bg-maroon-100 dark:bg-maroon-900/30 text-maroon-600 dark:text-maroon-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-maroon-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" /></svg>
                            </div>
                                    <h3 class="text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-maroon-600 transition-colors">Empowerment Grants</h3>
                                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Non-repayable grants to help petty traders and SMEs thrive in underserved rural markets.</p>
                                </div>
                                <!-- Back Face -->
                                <div class="absolute inset-0 bg-gradient-to-br from-maroon-600 to-maroon-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-maroon-500 shadow-inner">
                                    <div class="bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4">
                                        <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain filter drop-shadow-lg" alt="TTCRHF Logo">
                                    </div>
                                    <h3 class="text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm">Empowerment Grants</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

<?php
$partner_logo = !empty($site_settings['home_partnership_logo']) ? $site_settings['home_partnership_logo'] : 'openclax_logo.png';
$partner_tag = $site_settings['home_partnership_tag'] ?? 'Strategic Partnership';
$partner_title = $site_settings['home_partnership_title'] ?? 'Empowering Education with <span class="text-blue-600">Openclax</span>';
$partner_desc = $site_settings['home_partnership_desc'] ?? '<p>We are proud to announce our strategic alliance with <strong>Openclax</strong>...</p>';
?>
            <!-- STRATEGIC PARTNERSHIP SECTION -->
            <section class="py-24 bg-white dark:bg-slate-950">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-16 items-center">
                        <!-- Logos Visual -->
                        <div class="relative flex justify-center items-center">
                            <div class="absolute inset-0 bg-gradient-to-r from-maroon-100 to-blue-100 dark:from-maroon-900/20 dark:to-blue-900/20 blur-3xl rounded-full opacity-50"></div>
                            <div class="relative z-10 flex items-center gap-8 md:gap-12 animate-float">
                                <!-- TTCRHF Logo -->
                                <div class="w-32 h-32 md:w-40 md:h-40 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl flex items-center justify-center p-2 border-4 border-maroon-500/20">
                                    <img src="<?= htmlspecialchars($card_logo) ?>" class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal" alt="TTCRHF">
                                </div>
                                <!-- X Icon -->
                                <div class="text-slate-300 dark:text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </div>
                                <!-- Partner Logo -->
                                <div class="w-32 h-32 md:w-40 md:h-40 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl flex items-center justify-center p-2 border-4 border-blue-500/20">
                                    <!-- Use absolute slash path to support local / uploads directory correctly if relative -->
                                    <img src="<?= (strpos($partner_logo, 'uploads/') !== false) ? htmlspecialchars($partner_logo) : htmlspecialchars($partner_logo) ?>" class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal" alt="Partner">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-bold tracking-widest uppercase text-sm mb-4 block"><?= htmlspecialchars($partner_tag) ?></span>
                            <h2 class="text-3xl md:text-5xl font-bold mb-6 text-slate-900 dark:text-white font-heading"><?= $partner_title ?></h2>
                            <div class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed mb-8">
                                <?= $partner_desc ?>
                            </div>
                            <button onclick="navigateTo('contact')" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold hover:gap-4 transition-all group">
                                Learn about the initiative <span class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-full group-hover:bg-blue-600 group-hover:text-white transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg></span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <?php if(!empty($partners)): ?>
            <!-- DYNAMIC VALUED PARTNERS GRID (SMALL BOXES) -->
            <section class="py-16 bg-slate-50 dark:bg-slate-900 border-y border-slate-100 dark:border-slate-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h3 class="text-2xl md:text-3xl font-bold mb-10 text-slate-800 dark:text-white font-heading">Our Valued Partners</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach($partners as $p): ?>
                        <div class="bg-white dark:bg-slate-950 p-8 rounded-[2rem] shadow-sm border border-slate-200/60 dark:border-slate-800 flex flex-col items-center group hover:-translate-y-1 hover:shadow-2xl hover:border-blue-500/30 hover:shadow-blue-500/10 transition-all duration-300">
                            <div class="h-20 flex items-center justify-center mb-6">
                                <img src="<?= htmlspecialchars($p['image_path']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="max-h-full max-w-full object-contain filter grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 mix-blend-multiply dark:mix-blend-normal">
                            </div>
                            <h4 class="font-bold text-slate-800 dark:text-white mb-2"><?= htmlspecialchars($p['name']) ?></h4>
                            <?php if(!empty($p['description'])): ?>
                                <p class="text-[13px] text-slate-500 dark:text-slate-400 font-light leading-relaxed"><?= htmlspecialchars($p['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Orphanage Visit Photo Grid -->
            <section class="py-24 bg-white dark:bg-slate-950">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4 dark:text-white">Orphanage Outreach Highlights</h2>
                        <p class="text-slate-500 dark:text-slate-400">Bringing smiles and sustainable support to the most vulnerable members of our Tribe.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="rounded-3xl overflow-hidden shadow-xl dark:shadow-maroon-900/10 transform hover:scale-[1.02] transition-transform">
                            <img src="orphanage1.jpg" class="w-full h-80 object-cover" alt="Orphanage visit 1">
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-xl dark:shadow-maroon-900/10 transform hover:scale-[1.02] transition-transform">
                            <img src="orphanage2.jpg" class="w-full h-80 object-cover" alt="Orphanage visit 2">
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-xl dark:shadow-maroon-900/10 transform hover:scale-[1.02] transition-transform">
                            <img src="orphanage3.jpg" class="w-full h-80 object-cover" alt="Orphanage visit 3">
                        </div>
                    </div>
                </div>
            </section>

            <!-- CONTACT PAGE -->
            <div id="page-contact" class="page-section hidden py-24 px-4 bg-slate-50 dark:bg-slate-900 text-center">
                <div class="max-w-4xl mx-auto">
                     <span class="text-maroon-600 dark:text-maroon-400 font-bold tracking-widest uppercase text-sm mb-4 block">Get In Touch</span>
                    <h1 class="text-5xl font-bold mb-12 dark:text-white font-heading">Contact the Foundation</h1>
                    <div class="bg-white dark:bg-slate-800 rounded-[3rem] shadow-xl p-8 md:p-12 text-left">
                        <div class="grid md:grid-cols-2 gap-12">
                            <div>
                                <h3 class="text-2xl font-bold mb-6 dark:text-white">Send a Message</h3>
                                <form class="space-y-6" onsubmit="event.preventDefault(); showModal('Message Sent', 'Thank you for reaching out. We will get back to you shortly.');">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Name</label>
                                        <input type="text" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 focus:ring-2 focus:ring-maroon-500 outline-none transition" placeholder="Your Name">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email</label>
                                        <input type="email" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 focus:ring-2 focus:ring-maroon-500 outline-none transition" placeholder="email@example.com">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Message</label>
                                        <textarea rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 focus:ring-2 focus:ring-maroon-500 outline-none transition" placeholder="How can we work together?"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-maroon-600 text-white py-4 rounded-xl font-bold hover:bg-maroon-700 transition transform hover:-translate-y-1">Send Message</button>
                                </form>
                            </div>
                            <div class="flex flex-col justify-center space-y-8">
                                <div class="bg-maroon-50 dark:bg-maroon-900/20 p-8 rounded-3xl border border-maroon-100 dark:border-maroon-800/30">
                                    <h4 class="font-bold text-maroon-900 dark:text-maroon-100 mb-4 text-xl">Headquarters</h4>
                                    <p class="text-maroon-800 dark:text-maroon-200 leading-relaxed">
                                        2/4, Christ Coming Drive,<br>
                                        Ulemo, Benin City,<br>
                                        Edo State, Nigeria
                                    </p>
                                </div>
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-8 rounded-3xl border border-blue-100 dark:border-blue-800/30">
                                    <h4 class="font-bold text-blue-900 dark:text-blue-100 mb-4 text-xl">Direct Contact</h4>
                                    <p class="text-blue-800 dark:text-blue-200 leading-relaxed mb-2"><strong>Email:</strong> ttcrhf@mail.com</p>
                                    <p class="text-blue-800 dark:text-blue-200 leading-relaxed"><strong>Phone:</strong> +234 809 200 0080</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partnership Section -->
            <section class="py-24 bg-maroon-950 text-white">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <h2 class="text-2xl font-bold mb-12 tracking-widest uppercase opacity-60 font-heading">Global Strategic Partners</h2>
                    <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-80 grayscale hover:grayscale-0 transition-all">
                        <span class="text-3xl font-heading font-bold italic">Ministry of Ed.</span>
                        <span class="text-3xl font-heading font-bold">SolarGlobal</span>
                        <span class="text-3xl font-heading font-bold">EdoEmpowers</span>
                        <span class="text-3xl font-heading font-bold">Tech4Rural</span>
                    </div>
                    <div class="mt-16 bg-maroon-900/30 p-12 rounded-[3rem] border border-maroon-800">
                        <h3 class="text-3xl font-bold mb-6 font-heading">Become a Partner</h3>
                        <p class="text-maroon-100 mb-8 max-w-xl mx-auto">Join the Tribe called Roots and help us scale our impact across more rural communities.</p>
                        <button class="bg-white text-maroon-950 px-8 py-3 rounded-full font-bold hover:bg-maroon-50 transition">Get in Touch</button>
                    </div>
                </div>
            </section>
        </div>

        <!-- ABOUT PAGE -->
        <div id="page-about" class="page-section hidden py-24 px-4 max-w-7xl mx-auto">
            <!-- Hero Intro -->
            <div class="text-center mb-20 max-w-4xl mx-auto">
                <span class="text-maroon-600 dark:text-maroon-400 font-bold tracking-widest uppercase text-sm mb-4 block">Who We Are</span>
                <h1 class="text-4xl md:text-5xl font-bold mb-8 dark:text-white font-heading leading-tight">The Tribe Called Roots <br>Humanitarian Foundation (TTCRHF)</h1>
                <div class="relative">
                    <div class="absolute inset-0 bg-maroon-100 dark:bg-maroon-900/20 transform -skew-y-1 rounded-3xl -z-10"></div>
                    <p class="text-slate-600 dark:text-slate-300 text-lg md:text-xl leading-relaxed p-8 glass-panel">
                        "At The Tribe Called Roots Humanitarian Foundation, we believe that sustainable change begins with communal strength and targeted support. We are a non-governmental organization dedicated to bridging the gap for the underserved and empowering the next generation of leaders in our communities."
                    </p>
                </div>
            </div>

            <!-- Pillars of Impact -->
            <div class="mb-24">
                <h2 class="text-3xl font-bold mb-12 text-center dark:text-white font-heading">Our Core Pillars of Impact</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- 1. Education (Blue) -->
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-lg border border-slate-100 dark:border-slate-800 hover:border-blue-500/50 hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">1. Educational Advancement & Digital Literacy</h3>
                        <p class="text-sm text-slate-500 mb-4">Partnering with Openclax to bridge the digital divide.</p>
                        <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Free Digital Access:</strong> Openclax platform for SSCE prep.</span></li>
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>CBT Readiness:</strong> Skills for modern testing.</span></li>
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Resource Distribution:</strong> Essential study materials.</span></li>
                        </ul>
                    </div>

                    <!-- 2. Health (Red) -->
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-lg border border-slate-100 dark:border-slate-800 hover:border-red-500/50 hover:shadow-2xl hover:shadow-red-500/10 hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-red-600 group-hover:text-white transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">2. Holistic Health & Wellbeing</h3>
                        <p class="text-sm text-slate-500 mb-4">Ensuring a sound mind and healthy body.</p>
                        <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Counseling Services:</strong> Mental health support.</span></li>
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Free Medical Eye Treatment:</strong> Exams and treatments for the needy.</span></li>
                        </ul>
                    </div>

                    <!-- 3. Infrastructure (Amber) -->
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-lg border border-slate-100 dark:border-slate-800 hover:border-amber-500/50 hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">3. Rural Infrastructural Development</h3>
                        <p class="text-sm text-slate-500 mb-4">High-impact projects for longevity.</p>
                        <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Clean Water:</strong> Industrial boreholes.</span></li>
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Renewable Energy:</strong> Solar lighting for security.</span></li>
                        </ul>
                    </div>

                    <!-- 4. Economic Empowerment (Emerald) -->
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-lg border border-slate-100 dark:border-slate-800 hover:border-maroon-500/50 hover:shadow-2xl hover:shadow-maroon-500/10 hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-maroon-100 dark:bg-maroon-900/30 text-maroon-600 dark:text-maroon-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-maroon-600 group-hover:text-white transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 dark:text-white group-hover:text-maroon-600 dark:group-hover:text-maroon-400 transition-colors">4. Economic Empowerment & Social Welfare</h3>
                        <p class="text-sm text-slate-500 mb-4">Financial foundations for growth.</p>
                        <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>SME Grants:</strong> For local economic growth.</span></li>
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Vulnerable Outreach:</strong> Support for orphanages and extreme poverty.</span></li>
                        </ul>
                    </div>

                    <!-- 5. Community Engagement (Purple) -->
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-lg border border-slate-100 dark:border-slate-800 hover:border-purple-500/50 hover:shadow-2xl hover:shadow-purple-500/10 hover:-translate-y-2 transition-all duration-300 group md:col-span-2 lg:col-span-1">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">5. Community Engagement & Advocacy</h3>
                        <p class="text-sm text-slate-500 mb-4">Collective action for impact.</p>
                        <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Volunteer Programs:</strong> Structured community service.</span></li>
                            <li class="flex gap-2"><span class="text-maroon-500">✔</span> <span><strong>Awareness Campaigns:</strong> Public education on rights and health.</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Vision Statement -->
            <div class="bg-slate-900 text-white p-12 md:p-16 rounded-[3rem] text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                     <svg viewBox="0 0 200 200" class="w-full h-full"><path d="M0 100 Q 50 200 100 100 T 200 100" fill="none" stroke="white" stroke-width="2"/></svg>
                </div>
                <span class="inline-block border border-white/30 rounded-full px-4 py-1 text-xs font-bold uppercase tracking-widest mb-6">Our Vision</span>
                <h3 class="text-2xl md:text-4xl font-bold font-heading leading-relaxed max-w-4xl mx-auto">
                    "To create a world where geography does not determine a person's access to opportunity, education, or basic human dignity."
                </h3>
            </div>
        </div>

        <!-- PROJECTS PAGE -->
        <div id="page-projects" class="page-section hidden py-24 px-4 max-w-7xl mx-auto">
            <h1 class="text-5xl font-bold mb-12 text-center dark:text-white font-heading">Impact Pillars</h1>
            <div class="grid md:grid-cols-2 gap-12 text-left">
                <div class="bg-white dark:bg-slate-900 p-12 rounded-[3rem] shadow-lg border border-slate-100 dark:border-slate-800">
                    <h3 class="text-3xl font-bold mb-4 dark:text-white font-heading">Infrastructure</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Implementing clean water boreholes and solar lighting projects across neglected rural clusters in Edo State.</p>
                </div>
                <div class="bg-white dark:bg-slate-900 p-12 rounded-[3rem] shadow-lg border border-slate-100 dark:border-slate-800">
                    <h3 class="text-3xl font-bold mb-4 dark:text-white font-heading">Orphanage Support</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">We provide long-term structural and educational support to orphanages, ensuring consistent feeding and vocational training.</p>
                </div>
            </div>
        </div>



        <!-- GALLERY PAGE -->
        <div id="page-gallery" class="page-section hidden py-24 px-4 max-w-7xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-12 dark:text-white font-heading">Visual Impact</h1>
            <?php if (empty($gallery)): ?>
                <div class="py-20 text-slate-500">No images have been uploaded to the gallery yet.</div>
            <?php else: ?>
                <?php 
                // Only take the first 10 images for the homepage
                $display_gallery = array_slice($gallery, 0, 10);
                $chunks = array_chunk($display_gallery, 5);
                foreach ($chunks as $chunkIndex => $chunk):
                    $isFirstPattern = ($chunkIndex % 2 == 0);
                ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px] <?= $chunkIndex > 0 ? 'mt-6' : '' ?>">
                    <?php 
                    foreach ($chunk as $i => $img): 
                        if ($isFirstPattern) {
                            $class = ($i == 0) ? 'md:col-span-2 md:row-span-2' : (($i == 3) ? 'md:col-span-1' : (($i == 4) ? 'md:col-span-2' : ''));
                        } else {
                            $class = ($i == 1) ? 'md:col-span-2 md:row-span-2' : (($i == 3) ? 'md:col-span-2' : (($i == 4) ? 'md:col-span-1' : ''));
                        }
                    ?>
                    <div class="<?= $class ?> relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                        <img src="<?= htmlspecialchars($img['image_path']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact">
                        <?php if (!empty($img['title'])): ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-8">
                            <span class="text-white font-bold text-xl"><?= htmlspecialchars($img['title']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- DONATE PAGE -->
        <div id="page-donate" class="page-section hidden">
            <!-- Hero with Gradient -->
            <div class="bg-gradient-to-br from-maroon-900 to-slate-900 text-white py-20 px-6 relative overflow-hidden">
                 <div class="absolute top-0 right-0 w-1/2 h-full bg-maroon-500/10 blur-[100px] rounded-full"></div>
                 <div class="max-w-4xl mx-auto text-center relative z-10">
                     <span class="inline-block bg-white/10 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6">Seeds of Change</span>
                     <h1 class="text-4xl md:text-6xl font-bold font-heading mb-6">Invest in Rural Futures.</h1>
                     <p class="text-xl text-maroon-100 max-w-2xl mx-auto leading-relaxed">Your contribution directly funds solar boreholes, orphanage nutrition plans, and digital exam scholarships. 100% transparency.</p>
                 </div>
            </div>

            <div class="max-w-5xl mx-auto px-4 -mt-12 relative z-20 pb-24">
                <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-slate-100 dark:border-slate-800 p-8 md:p-12">
                    
                    <!-- Impact Tiers (visual reference) -->
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-8 text-center">Choose Your Impact</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                        <?php for($i=1; $i<=4; $i++): 
                            $amt = $site_settings["donate_tier_{$i}_amt"] ?? '';
                            $desc = $site_settings["donate_tier_{$i}_desc"] ?? '';
                            if(!$amt) continue;
                        ?>
                        <button type="button" onclick="selectImpactTier('$<?= htmlspecialchars($amt) ?> - <?= htmlspecialchars(addslashes($desc)) ?>')" class="impact-tier bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-maroon-500 hover:bg-maroon-50 dark:hover:bg-maroon-900/20 active:scale-95 transition-all p-6 rounded-2xl group text-center">
                            <span class="block text-3xl font-extrabold text-maroon-600 dark:text-maroon-400 mb-2 group-hover:scale-110 transition-transform">$<?= htmlspecialchars($amt) ?></span>
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-maroon-700 dark:group-hover:text-maroon-300"><?= htmlspecialchars($desc) ?></span>
                        </button>
                        <?php endfor; ?>
                    </div>

                    <div class="h-px bg-slate-100 dark:bg-slate-800 my-10"></div>

                    <!-- Direct Donation Form -->
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2 text-center font-heading">Complete Your Donation</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-center mb-10 text-sm">Enter your details and securely launch the Paystack checkout modal.</p>

                    <form id="donate-form" class="space-y-6 max-w-2xl mx-auto">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Display Name <span class="text-red-500">*</span></label>
                                <input type="text" name="donor_name" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition text-slate-900 dark:text-white" placeholder="Name or Organization">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Secure Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="donor_email" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition text-slate-900 dark:text-white" placeholder="you@receipt.com">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Amount You Wish to Donate (USD) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-xl font-bold text-slate-400">$</span>
                                <input type="text" name="donor_amount" id="donate-amount-input" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3.5 pl-12 pr-6 text-xl font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 transition-all font-mono" placeholder="Select a tier above or type custom">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="donate-submit-btn" class="w-full bg-maroon-600 text-white py-5 rounded-full font-bold text-xl hover:bg-maroon-700 transition shadow-xl shadow-maroon-200 dark:shadow-maroon-900/20 transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Launch Financial Checkout
                        </button>

                        <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-4 tracking-wide text-balance">This transaction is strictly regulated and encrypted through Paystack API.</p>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <!-- CONTACT / ENQUIRY SECTION -->
    <section id="page-contact" class="page-section bg-slate-100 dark:bg-slate-900 py-24 px-4 relative z-20 shadow-inner">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold mb-4 font-heading text-slate-900 dark:text-white">Get In Touch</h2>
                <p class="text-xl text-slate-500 dark:text-slate-400 font-light">Have questions about our rural initiatives? Send our central office a direct message.</p>
            </div>
            
            <?php if(isset($_GET['inquiry']) && $_GET['inquiry'] === 'success'): ?>
            <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 p-6 rounded-2xl mb-10 shadow-sm text-center font-medium">
                Message successfully routed! Our administration team will review your contact and reply to you directly.
            </div>
            <?php endif; ?>

            <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] shadow-xl border border-slate-200 dark:border-slate-800 p-8 md:p-12 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                <form action="process_inquiry.php" method="POST" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Contact Name <span class="text-red-500">*</span></label>
                            <input type="text" name="contact_name" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-slate-900 dark:text-white" placeholder="Full Name">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="contact_email" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-slate-900 dark:text-white" placeholder="Email Contact">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Phone Number</label>
                            <input type="tel" name="contact_phone" class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-slate-900 dark:text-white" placeholder="Optional Phone">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Location</label>
                            <input type="text" name="contact_location" class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-slate-900 dark:text-white" placeholder="City or Region">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Subject <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_subject" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-slate-900 dark:text-white" placeholder="Brief subject header">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Full Message <span class="text-red-500">*</span></label>
                        <textarea name="contact_message" required rows="5" class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-slate-900 dark:text-white" placeholder="Type your full enquiry here..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-slate-900 text-white dark:bg-blue-600 dark:hover:bg-blue-700 py-5 rounded-xl font-bold text-lg hover:bg-black transition shadow-xl transform flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Dispatch Secure Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Detailed Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 text-left">
            <div class="grid md:grid-cols-4 gap-16 mb-16">
                <!-- Brand Info -->
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white">
                            <img src="<?= htmlspecialchars($card_logo) ?>" alt="TTCRHF Logo" class="w-full h-full object-cover">
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white uppercase font-heading">TTCRHF</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-8 font-light">The Tribe Called Roots Humanitarian Foundation is an international NGO dedicated to rural upliftment, infrastructure, and educational equity.</p>
                </div>

                <!-- Contact Details -->
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase tracking-widest text-xs font-heading">Contact Info</h4>
                        <li class="flex items-start gap-3">📍 <?= htmlspecialchars($site_settings['contact_address'] ?? '') ?></li>
                        <li class="flex items-start gap-3">✉️ <?= htmlspecialchars($site_settings['contact_email'] ?? '') ?></li>
                        <li class="flex items-start gap-3">📞 <?= htmlspecialchars($site_settings['contact_phone'] ?? '') ?></li>
                    </ul>
                </div>

                <!-- Useful Links -->
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase tracking-widest text-xs font-heading">Foundation</h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li><a href="about.php" class="hover:text-maroon-500 transition">Our History</a></li>
                        <li><a href="projects.php" class="hover:text-maroon-500 transition">Water & Solar Projects</a></li>

                        <li><button onclick="openPartnershipModal()" class="text-maroon-400 font-bold hover:text-maroon-300 transition">Partner With Us</button></li>
                    </ul>
                </div>

                <!-- Registration / Details -->
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase tracking-widest text-xs font-heading">Transparency</h4>
                    <p class="text-xs mb-4 font-light">Corporate Affairs Commission Registered.</p>
                </div>
            </div>

            <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 text-[9px] font-bold tracking-[0.2em] uppercase">
                <p>&copy; 2026 The Tribe Called Roots Humanitarian Foundation. All Rights Reserved.</p>
                <div class="flex gap-12 font-heading">
                    <a href="#" class="hover:text-maroon-500">Privacy Policy</a>
                    <a href="#" class="hover:text-maroon-500">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Partnership Button -->
    <button onclick="openPartnershipModal()" class="fixed bottom-6 right-6 md:bottom-10 md:right-10 z-[90] bg-maroon-600 text-white shadow-xl shadow-maroon-600/30 rounded-full px-6 py-4 font-bold flex items-center gap-3 hover:bg-maroon-700 hover:scale-105 transition-all group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        <span class="hidden md:inline-block">Partner With Us</span>
    </button>

    <!-- Partnership Modal -->
    <div id="partnership-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-md hidden p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-12 max-w-lg w-full shadow-2xl relative border dark:border-slate-800 max-h-[90vh] overflow-y-auto">
            <button onclick="closePartnershipModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <span class="text-maroon-600 font-bold tracking-widest uppercase text-xs mb-1 block">Collaborate</span>
            <h3 class="text-3xl font-extrabold mb-2 font-heading dark:text-white">Partner With Us</h3>
            <p class="text-slate-500 mb-8 font-light">Join TTCRHF in our mission to uplift rural communities. Submit your details below.</p>
            
            <form action="process_partnership.php" method="POST" class="space-y-4 text-left">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Organization / Name <span class="text-red-500">*</span></label>
                        <input type="text" name="organization_name" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none placeholder-slate-400" placeholder="Your Org or Full Name">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Contact Person <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_name" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none placeholder-slate-400" placeholder="Contact Name">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none placeholder-slate-400" placeholder="Email Address">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Phone Number</label>
                        <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none placeholder-slate-400" placeholder="Phone Number">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Amount</label>
                        <input type="text" name="partnership_amount" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none placeholder-slate-400" placeholder="e.g. $1000">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Frequency</label>
                        <select name="donation_frequency" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none">
                            <option value="One-Time">One-Time</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Annually">Annually</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Period</label>
                        <select name="partnership_period" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none">
                            <option value="Ongoing">Ongoing</option>
                            <option value="1 Year">1 Year</option>
                            <option value="2 Years">2 Years</option>
                            <option value="3+ Years">3+ Years</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">How can we partner?</label>
                    <textarea name="message" rows="2" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none placeholder-slate-400" placeholder="Briefly describe your partnership idea..."></textarea>
                </div>
                <button type="submit" class="w-full bg-maroon-600 text-white font-bold py-4 rounded-xl hover:bg-maroon-700 transition">Submit Request</button>
            </form>
        </div>
    </div>

    <!-- Custom Modal -->
    <div id="modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-md hidden p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-12 max-w-lg w-full shadow-2xl text-center border dark:border-slate-800">
            <h3 id="modal-title" class="text-3xl font-extrabold mb-4 dark:text-white font-heading">Success</h3>
            <p id="modal-text" class="text-slate-600 dark:text-slate-400 mb-10 leading-relaxed font-light"></p>
            <button onclick="closeModal()" class="bg-maroon-600 text-white w-full py-5 rounded-2xl font-bold hover:bg-maroon-700 transition">Continue</button>
        </div>
    </div>

    <?php if (isset($_GET['partner_status'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if($_GET['partner_status'] == 'success'): ?>
            showModal('Received!', 'Thank you for your interest in partnering with us. Our team will review your message and contact you shortly.');
            <?php else: ?>
            showModal('Error', 'There was a problem submitting your partnership request. Please ensure all fields are correctly filled and try again.');
            <?php endif; ?>
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    </script>
    <?php endif; ?>

    <script>
        // Theme Management Logic
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        function navigateTo(pageId) {
            document.querySelectorAll('.page-section').forEach(section => section.classList.add('hidden'));
            const target = document.getElementById('page-' + pageId);
            if (target) {
                target.classList.remove('hidden');
                window.scrollTo(0, 0);
            }
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active-nav'));
            const activeLink = document.getElementById('nav-' + pageId);
            if (activeLink) activeLink.classList.add('active-nav');
            document.getElementById('mobile-menu').classList.add('hidden');
        }

        function triggerThankYou() {
            showModal("Roots Support", "Redirecting you to our secure payment gateway. Your contribution helps bridge the gap for rural communities in Edo State.");
        }

        // Donation tier selection
        function selectImpactTier(tier) {
            const amountInput = document.getElementById('donate-amount-input');
            if (amountInput) {
                amountInput.value = tier;
                amountInput.focus();
                // Highlight the selected tier
                document.querySelectorAll('.impact-tier').forEach(btn => {
                    btn.classList.remove('ring-2', 'ring-maroon-500', 'border-maroon-500');
                });
                event.currentTarget.classList.add('ring-2', 'ring-maroon-500', 'border-maroon-500');
            }
        }

        // Paystack Inline JS for Donation
        document.addEventListener('DOMContentLoaded', function() {
            const donateForm = document.getElementById('donate-form');
            if (donateForm) {
                // Dynamically load Paystack script
                const script = document.createElement('script');
                script.src = "https://js.paystack.co/v1/inline.js";
                document.head.appendChild(script);

                donateForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const name = donateForm.querySelector('[name="donor_name"]').value;
                    const email = donateForm.querySelector('[name="donor_email"]').value;
                    let amountStr = donateForm.querySelector('[name="donor_amount"]').value;
                    
                    const EXCHANGE_RATE = <?= (float)($site_settings['exchange_rate'] ?? 1500) ?>; // Dynamically fetched from Global Settings
                    
                    // Extract numeric USD amount
                    let amountNumUSD = parseFloat(amountStr.replace(/[^0-9.]/g, ''));
                    if (isNaN(amountNumUSD) || amountNumUSD <= 0) {
                        showModal('Invalid Amount', 'Please enter a valid donation amount.');
                        return;
                    }
                    
                    // Convert USD to NGN natively, then to kobo
                    const amountInNGN = amountNumUSD * EXCHANGE_RATE;
                    const amountInKobo = Math.round(amountInNGN * 100);

                    const submitBtn = document.getElementById('donate-submit-btn');
                    const originalHTML = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<svg class="animate-spin h-6 w-6 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Connecting to Paystack...';
                    submitBtn.disabled = true;
                    
                    let handler = PaystackPop.setup({
                        key: 'pk_live_fe44d6dcb94e042a279fa9eab13489dace54abd7',
                        email: email,
                        amount: amountInKobo,
                        currency: 'NGN',
                        ref: 'TTCRHF_' + Math.floor((Math.random() * 1000000000) + 1),
                        callback: function(response) {
                            // Verify on backend
                            fetch('verify_payment.php?reference=' + response.reference + '&name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email) + '&amount=' + amountNumUSD)
                            .then(res => res.json())
                            .then(data => {
                                if(data.success) {
                                    showModal('Thank You! 🌱', 'Your donation was successful. We appreciate your support for Edo State.');
                                    donateForm.reset();
                                } else {
                                    showModal('Notice', 'Payment completed but verification failed.');
                                }
                                submitBtn.innerHTML = originalHTML;
                                submitBtn.disabled = false;
                            });
                        },
                        onClose: function() {
                            showModal('Cancelled', 'Transaction was not completed.');
                            submitBtn.innerHTML = originalHTML;
                            submitBtn.disabled = false;
                        }
                    });
                    
                    handler.openIframe();
                });
            }
        });

        function showModal(title, text) {
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-text').innerText = text;
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            navigateTo('home');
        }

        function openPartnershipModal() {
            document.getElementById('partnership-modal').classList.remove('hidden');
        }

        function closePartnershipModal() {
            document.getElementById('partnership-modal').classList.add('hidden');
        }

        window.onload = () => {
            navigateTo('home');
            
            // Auto Flip Cards Sequence
            const flipCards = document.querySelectorAll('.flip-card .flip-inner');
            if(flipCards.length > 0) {
                let activeFlipIndex = 0;
                setInterval(() => {
                    // Remove override from all
                    flipCards.forEach(card => card.style.cssText = '');
                    // Flip current
                    flipCards[activeFlipIndex].style.cssText = 'transform: rotateY(180deg) translateY(-0.5rem) !important; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25) !important;';
                    
                    activeFlipIndex++;
                    if(activeFlipIndex >= flipCards.length) activeFlipIndex = 0;
                }, 3000);
            }
        };
    </script>
</body>
</html>
