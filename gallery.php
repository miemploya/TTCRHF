<?php
require_once 'includes/db_connect.php';
require_once 'includes/helpers.php';
$gallery = $pdo->query("SELECT * FROM gallery ORDER BY display_order ASC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | The Tribe Called Roots Humanitarian Foundation</title>
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
                    <a href="events.php" class="hover:text-maroon-600 transition-all py-2">Events</a>
                    <a href="projects.php" class="hover:text-maroon-600 transition-all py-2">Projects</a>
                    <a href="gallery.php" class="text-maroon-600 border-b-2 border-maroon-600 py-2">Gallery</a>
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
                <span class="text-maroon-600 dark:text-maroon-400 font-bold tracking-widest uppercase text-sm">Visual Impact</span>
                <h1 class="text-4xl md:text-7xl font-extrabold mt-4 mb-6 dark:text-white leading-tight font-heading">Our Gallery</h1>
                <p class="text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto font-light">
                    Memories from the field. Transforming rural communities, one project at a time.
                </p>
            </div>
        </section>

        <!-- Dynamic Masonry Grid -->
        <section class="py-12 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4">
                <?php if (empty($gallery)): ?>
                    <div class="py-20 text-slate-500 text-center text-xl font-bold">No images have been uploaded to the gallery yet.</div>
                <?php else: ?>
                    <?php 
                    $chunks = array_chunk($gallery, 5);
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
