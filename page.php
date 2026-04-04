<?php 
require_once 'includes/db_connect.php'; 
require_once 'includes/helpers.php'; 

if (!isset($_GET['slug'])) {
    header("Location: index.php");
    exit;
}

$slug = $_GET['slug'];
$stmt = $pdo->prepare("SELECT * FROM custom_pages WHERE slug = ?");
$stmt->execute([$slug]);
$pageData = $stmt->fetch();

if (!$pageData) {
    die("Error 404: Layout Engine Offline or Blueprint not found.");
}
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageData['title']) ?> | The Tribe Called Roots Humanitarian Foundation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Plus Jakarta Sans', 'sans-serif'], },
                    colors: {
                        maroon: {
                            50: 'color-mix(in srgb, var(--brand-primary) 5%, white)',
                            600: 'var(--brand-primary)',
                            900: 'color-mix(in srgb, var(--brand-primary) 40%, black)',
                            950: 'color-mix(in srgb, var(--brand-primary) 20%, black)',
                        },
                    },
                },
            },
        }
    </script>
    <style>
        :root { --brand-primary: <?= $brand_color_hex ?>; }
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        h1, h2, h3, h4, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* GrapesJS Injected Block Styles */
        <?= $pageData['css_content'] ?>
    </style>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300 overflow-x-hidden">

    <!-- Global Navigation -->
    <nav class="fixed w-full z-[999] bg-white/95 backdrop-blur-lg border-b border-slate-200 dark:bg-slate-900/95 dark:border-slate-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                <a href="index.php" class="flex items-center gap-4 cursor-pointer">
                    <div class="w-16 h-16 transition-colors duration-300 rounded-full overflow-hidden border-2 border-slate-900 dark:border-white shadow-md">
                        <img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo" class="w-full h-full object-cover">
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
                    <a href="projects.php" class="hover:text-maroon-600 transition-all py-2">Projects</a>
                    <a href="gallery.php" class="hover:text-maroon-600 transition-all py-2">Gallery</a>
                    <?php if (!isset($site_settings['show_library_page']) || $site_settings['show_library_page'] == '1'): ?>
                    <a href="library.php" class="hover:text-maroon-600 transition-all py-2">Library</a>
                    <?php endif; ?>
                    <?php 
                    $dynamic_nav = $pdo->query("SELECT title, slug FROM custom_pages WHERE show_in_nav = 1 ORDER BY created_at ASC")->fetchAll();
                    foreach($dynamic_nav as $dn): 
                        $isActive = ($slug == $dn['slug']);
                    ?>
                        <a href="page.php?slug=<?= htmlspecialchars($dn['slug']) ?>" class="hover:text-maroon-600 transition-all py-2 <?= $isActive ? 'text-maroon-600 border-b-2 border-maroon-600' : '' ?> font-bold tracking-tight"><?= htmlspecialchars($dn['title']) ?></a>
                    <?php endforeach; ?>
                    
                    <button onclick="toggleTheme()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-maroon-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors shadow-inner">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Canvas DOM Injection -->
    <main class="pt-[96px] min-h-screen">
        <?= $pageData['html_content'] ?>
    </main>

    <!-- Global Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 transition-colors duration-300 border-t border-white/5 relative z-[100]">
        <div class="max-w-7xl mx-auto px-4 text-left">
            <div class="grid md:grid-cols-4 gap-16 mb-16">
                <div class="col-span-1">
                    <div class="flex items-center gap-4 mb-8 text-white">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white shadow-lg">
                            <img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo block" class="w-full h-full object-cover">
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
                    <p class="text-sm font-light text-maroon-400 underline italic font-heading hover:text-white transition">thetribecalledroots.org</p>
                </div>
            </div>
            <div class="pt-12 border-t border-white/5 text-[9px] font-bold tracking-[0.3em] uppercase text-center opacity-50 hover:opacity-100 transition">
                &copy; <?= date("Y") ?> The Tribe Called Roots Humanitarian Foundation.
            </div>
        </div>
    </footer>

    <!-- Theme Control logic -->
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
