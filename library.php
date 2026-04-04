<?php
require_once 'includes/db_connect.php';
require_once 'includes/helpers.php';

if (isset($site_settings['show_library_page']) && $site_settings['show_library_page'] == '0') {
    header("Location: index.php");
    exit;
}

$materials = $pdo->query("SELECT * FROM library_materials WHERE status = 'active' ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library | The Tribe Called Roots Humanitarian Foundation</title>
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
                            500: 'color-mix(in srgb, var(--brand-primary) 85%, white)',
                            600: 'var(--brand-primary)',
                            700: 'color-mix(in srgb, var(--brand-primary) 80%, black)',
                            900: 'color-mix(in srgb, var(--brand-primary) 40%, black)',
                        },
                    },
                },
            },
        }
    </script>
    <style>
        :root { --brand-primary: <?= htmlspecialchars($brand_color_hex ?? '#a01c1c') ?>; }
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
                    <a href="gallery.php" class="hover:text-maroon-600 transition-all py-2">Gallery</a>
                    <?php if (!isset($site_settings['show_library_page']) || $site_settings['show_library_page'] == '1'): ?>
                    <a href="library.php" class="text-maroon-600 border-b-2 border-maroon-600 py-2">Library</a>
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

    <main class="pt-24 pb-24">
        <section class="py-20 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <span class="text-maroon-600 dark:text-maroon-400 font-bold tracking-widest uppercase text-sm">Educational Resources</span>
                <h1 class="text-4xl md:text-7xl font-extrabold mt-4 mb-6 dark:text-white leading-tight font-heading">Digital Library</h1>
                <p class="text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto font-light">
                    Access our free collection of published materials. Register to download or view instantly.
                </p>
                <?php if(isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                    <p class="mt-4 text-red-500 font-bold mb-4 bg-red-50 p-4 rounded-xl inline-block">There was an error processing your request. Please try again.</p>
                <?php elseif(isset($_GET['status']) && $_GET['status'] == 'success_physical'): ?>
                    <p class="mt-4 text-green-700 font-bold mb-4 bg-green-50 p-4 rounded-xl inline-block">Physical loan request submitted successfully! We will contact you once approved.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Library Container -->
        <section class="py-12 bg-slate-50 dark:bg-slate-900/50 min-h-[500px]">
            <div class="max-w-7xl mx-auto px-4">
                <?php if(empty($materials)): ?>
                    <div class="py-20 text-slate-500 text-center text-xl font-bold">No library materials are available at this time.</div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        <?php foreach($materials as $m): ?>
                        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg border border-slate-100 dark:border-slate-800 p-6 flex flex-col hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                            <div class="w-full h-48 bg-slate-200 dark:bg-slate-800 rounded-xl mb-6 overflow-hidden flex items-center justify-center">
                                <?php if(!empty($m['cover_image_path'])): ?>
                                    <img src="<?= htmlspecialchars($m['cover_image_path']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span class="text-slate-400 font-extrabold text-2xl tracking-widest">PDF</span>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-xl font-bold mb-2 font-heading text-slate-900 dark:text-white"><?= htmlspecialchars($m['title']) ?></h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 flex-1"><?= htmlspecialchars($m['description']) ?></p>
                            <div class="flex flex-col gap-3">
                                <button onclick="openRequestModal(<?= $m['id'] ?>, '<?= htmlspecialchars(addslashes($m['title'])) ?>')" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold hover:bg-maroon-600 transition-colors shadow-lg">
                                    Download Free
                                </button>
                                <button onclick="openPhysicalModal(<?= $m['id'] ?>, '<?= htmlspecialchars(addslashes($m['title'])) ?>')" class="w-full bg-transparent text-slate-900 dark:text-white border-2 border-slate-900 dark:border-slate-700 py-3 rounded-xl font-bold hover:bg-slate-900 hover:text-white transition-colors">
                                    Request Hard Copy
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Request Modal -->
    <div id="request-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm hidden p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 md:p-8 max-w-md w-full shadow-2xl relative border dark:border-slate-800 max-h-[90vh] overflow-y-auto">
            <button onclick="closeRequestModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <span class="text-maroon-600 font-bold tracking-widest uppercase text-xs mb-1 block">Secure Resource</span>
            <h3 class="text-xl font-extrabold mb-1 font-heading dark:text-white truncate" id="modal-material-title"></h3>
            <p class="text-sm text-slate-500 mb-4">Please provide your details to unlock this free resource.</p>
            
            <form action="process_library_request.php" method="POST" class="space-y-3">
                <input type="hidden" name="material_id" id="modal-material-id" value="">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" required class="w-full px-3 py-2 text-sm rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="w-full px-3 py-2 text-sm rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Phone Number (Optional)</label>
                    <input type="tel" name="phone" class="w-full px-3 py-2 text-sm rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>
                <button type="submit" class="w-full bg-maroon-600 text-white py-3 mt-2 rounded-xl font-bold text-sm hover:bg-maroon-700 transition shadow-lg shadow-maroon-600/30">Get Access Link</button>
                <p class="text-[10px] text-center text-slate-400 mt-2">By downloading, you agree to receive follow-up emails regarding our projects.</p>
            </form>
        </div>
    </div>

    <!-- Physical Request Modal -->
    <div id="physical-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm hidden p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 md:p-8 max-w-md w-full shadow-2xl relative border dark:border-slate-800 max-h-[90vh] overflow-y-auto">
            <button onclick="closePhysicalModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-1 block">Physical Book Loan</span>
            <h3 class="text-xl font-extrabold mb-1 font-heading dark:text-white truncate" id="physical-modal-title"></h3>
            <p class="text-sm text-slate-500 mb-4">Upload valid ID and submit your inquiry to borrow a physical copy.</p>
            
            <form action="process_physical_request.php" method="POST" enctype="multipart/form-data" class="space-y-3">
                <input type="hidden" name="material_id" id="physical-material-id" value="">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" required class="w-full px-3 py-2 text-sm rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="w-full px-3 py-2 text-sm rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Phone Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" required class="w-full px-3 py-2 text-sm rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Upload ID Card Image <span class="text-red-500">*</span></label>
                    <input type="file" name="id_card" accept="image/*" required class="w-full px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500 outline-none text-xs">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 mt-2 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">Submit Loan Request</button>
                <p class="text-[10px] text-center text-slate-400 mt-2">By requesting, you agree to return the copy by the assigned due date.</p>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 transition-colors duration-300 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 text-left">
            <div class="grid md:grid-cols-4 gap-16 mb-16">
                <!-- Brand Info -->
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

    <script>
        function openRequestModal(id, title) {
            document.getElementById('modal-material-id').value = id;
            document.getElementById('modal-material-title').innerText = title;
            document.getElementById('request-modal').classList.remove('hidden');
        }
        function closeRequestModal() {
            document.getElementById('request-modal').classList.add('hidden');
        }
        function openPhysicalModal(id, title) {
            document.getElementById('physical-material-id').value = id;
            document.getElementById('physical-modal-title').innerText = title;
            document.getElementById('physical-modal').classList.remove('hidden');
        }
        function closePhysicalModal() {
            document.getElementById('physical-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
