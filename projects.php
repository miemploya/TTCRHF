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
                    <a href="projects.php" class="text-emerald-600 border-b-2 border-emerald-600 py-2">Projects</a>
                    <a href="gallery.php" class="hover:text-emerald-600 transition-all py-2">Gallery</a>
                    
                    <button onclick="toggleTheme()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-emerald-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Sections -->
    <main class="pt-24">
        
        <!-- PROJECTS PAGE CONTENT -->
        <section class="page-section py-24 px-4 max-w-7xl mx-auto">
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
