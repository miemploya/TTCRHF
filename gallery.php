<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | The Tribe Called Roots Humanitarian Foundation</title>
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
                },
            },
        }
    </script>
    <style>
        :root {
            --brand-emerald: #059669;
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
                    <!-- RECREATED OFFICIAL LOGO AS IMG -->
                    <div class="w-16 h-16 transition-colors duration-300 rounded-full overflow-hidden border-2 border-slate-900 dark:border-white">
                        <img src="ttcrhf_logo.png?v=2" alt="TTCRHF Logo" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xl tracking-tight text-slate-900 dark:text-white leading-none font-heading uppercase">TTCRHF</span>
                        <span class="text-[9px] font-bold text-emerald-600 dark:text-emerald-500 tracking-[0.1em] uppercase">The Tribe Called Roots</span>
                    </div>
                </a>
                
                <div class="hidden md:flex space-x-8 font-semibold text-slate-600 dark:text-slate-400 text-sm items-center text-left">
                    <a href="index.php" class="hover:text-emerald-600 transition-all py-2">Home</a>
                    <a href="about.php" class="hover:text-emerald-600 transition-all py-2">About Us</a>
                    <a href="events.php" class="hover:text-emerald-600 transition-all py-2">Events</a>
                    <a href="projects.php" class="hover:text-emerald-600 transition-all py-2">Projects</a>
                    <a href="gallery.php" class="text-emerald-600 border-b-2 border-emerald-600 py-2">Gallery</a>
                    
                    <button onclick="toggleTheme()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-emerald-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Sections -->
    <main class="pt-24">
        
        <!-- GALLERY PAGE CONTENT -->
        <section class="page-section py-24 px-4 max-w-7xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-12 dark:text-white font-heading">Visual Impact</h1>
            <!-- Masonry-style Grid for 5 Images -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px]">
                <!-- Large Feature Image -->
                <div class="md:col-span-2 md:row-span-2 relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery1.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 1">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-8">
                        <span class="text-white font-bold text-xl">Community Outreach</span>
                    </div>
                </div>
                <!-- Side Images -->
                <div class="relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery2.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 2">
                </div>
                <!-- Bottom Row -->
                <div class="relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery3.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 3">
                </div>
                <div class="md:col-span-1 relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery4.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 4">
                </div>
                <div class="md:col-span-2 relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery5.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 5">
                </div>
            </div>

            <!-- Second Grid Block for Next 5 Images -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px] mt-6">
                <!-- Side Images -->
                <div class="relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery6.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 6">
                </div>
                <!-- Large Feature Image (Right Side) -->
                <div class="md:col-span-2 md:row-span-2 relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery7.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 7">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-8">
                        <span class="text-white font-bold text-xl">Empowering Youth</span>
                    </div>
                </div>
                <!-- Bottom Row -->
                <div class="relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery8.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 8">
                </div>
                <div class="md:col-span-2 relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery9.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 9">
                </div>
                <div class="md:col-span-1 relative group overflow-hidden rounded-[2.5rem] shadow-xl">
                    <img src="gallery10.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="TTCRHF Impact 10">
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
                            <img src="ttcrhf_logo.png?v=2" alt="TTCRHF Logo" class="w-full h-full object-cover">
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white uppercase font-heading">TTCRHF</span>
                    </div>
                </div>
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase text-xs font-heading">Contacts</h4>
                    <p class="text-sm font-light leading-relaxed">📍 2/4, Christ Coming Drive, Ulemo, Benin City, Edo State.<br>📞 +234 809 200 0080</p>
                </div>
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase text-xs font-heading">Legacy</h4>
                    <p class="text-sm font-light leading-relaxed">Our Mission<br>CBT Initiative<br>Economic Growth</p>
                </div>
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase text-xs font-heading">Official Website</h4>
                    <p class="text-sm font-light text-emerald-400 underline italic font-heading">thetribecalledroots.org</p>
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
