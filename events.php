<?php
require_once 'includes/db_connect.php';
require_once 'includes/helpers.php';
$events = $pdo->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events | The Tribe Called Roots Humanitarian Foundation</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    </div>
                </a>
                
                <div class="hidden md:flex space-x-8 font-semibold text-slate-600 dark:text-slate-400 text-sm items-center">
                    <a href="index.php" class="hover:text-maroon-600 transition-all py-2">Home</a>
                    <a href="about.php" class="hover:text-maroon-600 transition-all py-2">About Us</a>
                    <a href="events.php" class="text-maroon-600 border-b-2 border-maroon-600 py-2">Events</a>
                    <a href="projects.php" class="hover:text-maroon-600 transition-all py-2">Projects</a>
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
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24">
        
        <section class="py-20 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <span class="text-maroon-600 dark:text-maroon-400 font-bold tracking-widest uppercase text-sm">Our Calendar</span>
                <h1 class="text-4xl md:text-7xl font-extrabold mt-4 mb-6 dark:text-white leading-tight font-heading">Upcoming Events</h1>
                <p class="text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto font-light">
                    Transforming communities in Benin City through education, health, and social welfare initiatives planned for 2026.
                </p>
            </div>
        </section>

        <!-- Events Grid -->
        <section class="py-12 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12">

                    <?php if (empty($events)): ?>
                        <div class="col-span-full text-center py-20">
                            <h3 class="text-2xl font-bold text-slate-500">No events found</h3>
                        </div>
                    <?php else: ?>
                        <?php foreach ($events as $e): 
                            $theme = $e['theme_color'] ?? 'maroon'; 
                            $c = [
                                'maroon'  => ['bg'=>'bg-slate-900', 'border'=>'border-maroon-500/20', 'text'=>'text-maroon-400', 'badge'=>'bg-maroon-600', 'blend'=>'bg-maroon-900/20', 'gradient'=>'from-slate-900 via-slate-900/40'],
                                'amber'   => ['bg'=>'bg-slate-950', 'border'=>'border-amber-500/20', 'text'=>'text-amber-400', 'badge'=>'bg-amber-600', 'blend'=>'bg-amber-900/20', 'gradient'=>'from-slate-950 via-slate-950/40'],
                                'emerald' => ['bg'=>'bg-slate-900', 'border'=>'border-emerald-500/20', 'text'=>'text-emerald-400', 'badge'=>'bg-emerald-600', 'blend'=>'bg-emerald-900/20', 'gradient'=>'from-slate-900 via-slate-900/40'],
                                'blue'    => ['bg'=>'bg-slate-950', 'border'=>'border-blue-500/20', 'text'=>'text-blue-400', 'badge'=>'bg-blue-600', 'blend'=>'bg-blue-900/20', 'gradient'=>'from-slate-950 via-slate-950/40'],
                                'purple'  => ['bg'=>'bg-slate-900', 'border'=>'border-purple-500/20', 'text'=>'text-purple-400', 'badge'=>'bg-purple-600', 'blend'=>'bg-purple-900/20', 'gradient'=>'from-slate-900 via-slate-900/40'],
                                'slate'   => ['bg'=>'bg-slate-800', 'border'=>'border-slate-500/20', 'text'=>'text-slate-400', 'badge'=>'bg-slate-600', 'blend'=>'bg-slate-900/20', 'gradient'=>'from-slate-800 via-slate-800/40']
                            ];
                            $t = $c[$theme] ?? $c['maroon'];
                        ?>
                        <div class="<?= $t['bg'] ?> <?= $t['border'] ?> text-white rounded-[3rem] shadow-2xl flex flex-col border transition-transform hover:-translate-y-2 duration-300">
                            <div class="relative h-72 overflow-hidden <?= $t['bg'] ?>">
                                <img src="<?= htmlspecialchars($e['flyer_path'] ? $e['flyer_path'] : 'https://images.unsplash.com/photo-1507152832244-10d45c7eda57?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') ?>" alt="Event Flyer" class="w-full h-full object-cover <?= empty($e['flyer_path']) ? 'opacity-80' : '' ?>">
                                <div class="absolute inset-0 bg-gradient-to-t <?= $t['gradient'] ?> to-transparent"></div>
                                <div class="absolute inset-0 <?= $t['blend'] ?> mix-blend-multiply"></div>
                                <div class="absolute bottom-6 left-8 relative z-10">
                                    <span class="<?= $t['badge'] ?> text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded shadow-lg"><?= htmlspecialchars(ucfirst($e['status'])) ?></span>
                                    <h2 class="text-3xl font-black mt-3 font-heading tracking-tight leading-none"><?= htmlspecialchars($e['title']) ?></h2>
                                </div>
                            </div>
                            <div class="p-10 lg:p-12 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="grid grid-cols-2 gap-6 mb-8 text-left bg-white/5 p-4 rounded-2xl border border-white/10">
                                        <div>
                                            <p class="text-[10px] font-bold <?= $t['text'] ?> uppercase mb-1 tracking-wider">Date</p>
                                            <p class="text-lg font-bold text-white"><?= date('M jS, Y', strtotime($e['event_date'])) ?></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold <?= $t['text'] ?> uppercase mb-1 tracking-wider">Location</p>
                                            <p class="text-sm font-semibold leading-tight text-white"><?= htmlspecialchars($e['location']) ?></p>
                                        </div>
                                    </div>
                                    <div class="space-y-4 mb-10 text-left">
                                        <p class="text-slate-300 text-sm italic leading-relaxed whitespace-pre-line"><?= htmlspecialchars($e['description']) ?></p>
                                    </div>
                                </div>
                                <div class="pt-8 border-t border-white/10 text-left mt-auto">
                                    <p class="text-[10px] font-bold text-slate-500 uppercase mb-2 tracking-widest">Support & Partnership</p>
                                    <p class="text-lg font-bold font-heading tracking-tight text-white"><?= htmlspecialchars($site_settings['contact_phone'] ?? '+234 809 200 0080') ?> | <?= htmlspecialchars($site_settings['contact_email'] ?? 'ttcrhf@mail.com') ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </section>

    </main>

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
            </div>
            <div class="pt-12 border-t border-white/5 text-[10px] font-bold tracking-[0.3em] uppercase text-center">
                &copy; <?= date('Y') ?> The Tribe Called Roots Humanitarian Foundation.
            </div>
        </div>
    </footer>
</body>
</html>
