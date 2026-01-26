<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | The Tribe Called Roots Humanitarian Foundation</title>
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
        .stat-card { transition: all 0.3s ease; height: 100%; border-radius: 2.5rem; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1); }
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
                        <img src="logo.jpg" alt="TTCRHF Logo" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xl tracking-tight text-slate-900 dark:text-white leading-none font-heading uppercase">TTCRHF</span>
                        <span class="text-[9px] font-bold text-emerald-600 dark:text-emerald-500 tracking-[0.1em] uppercase">The Tribe Called Roots</span>
                    </div>
                </a>
                
                <div class="hidden md:flex space-x-8 font-semibold text-slate-600 dark:text-slate-400 text-sm items-center text-left">
                    <a href="index.php" class="hover:text-emerald-600 transition-all py-2">Home</a>
                    <a href="about.php" class="text-emerald-600 border-b-2 border-emerald-600 py-2">About Us</a>
                    <a href="events.php" class="hover:text-emerald-600 transition-all py-2">Events</a>
                    <a href="projects.php" class="hover:text-emerald-600 transition-all py-2">Projects</a>
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
        
        <!-- About Header -->
        <section class="py-24 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <span class="font-extrabold tracking-widest uppercase text-lg md:text-xl bg-gradient-to-r from-emerald-600 to-teal-400 bg-clip-text text-transparent block mb-4 animate-pulse">Identity & Mission</span>
                <h1 class="text-4xl md:text-7xl font-extrabold mt-4 mb-8 dark:text-white leading-tight font-heading">Empowering Humanity Through Targeted Action</h1>
                <div class="max-w-4xl mx-auto">
                    <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 leading-relaxed font-light">
                        The Tribe Called Roots Humanitarian Foundation (TTCRHF) is a dedicated non-governmental organization committed to bridging the gap for the underserved and empowering the next generation of leaders in our communities.
                    </p>
                </div>
            </div>
        </section>

        <!-- Chairman's Message -->
        <section class="py-24 bg-slate-900 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-emerald-600/5 -skew-x-12 translate-x-20"></div>
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="relative">
                        <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl border-4 border-emerald-600/20">
                            <!-- High-quality image of black chairman in professional attire -->
                            <img src="logo.jpg" alt="Chairman Mr. Victor Oluromi" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-8 -right-8 bg-emerald-600 p-8 rounded-3xl shadow-xl hidden md:block text-left">
                            <p class="text-xs font-bold uppercase tracking-widest text-emerald-100 mb-1">Founder & Chairman</p>
                            <p class="text-2xl font-bold font-heading leading-tight">Mr. Victor Oluromi</p>
                        </div>
                    </div>
                    <div class="text-left">
                        <div class="w-20 h-1 bg-emerald-500 mb-10"></div>
                        <h2 class="text-3xl md:text-5xl font-bold mb-10 font-heading">A Mission for 2026: <br><span class="text-emerald-400">Roots of Transformation</span></h2>
                        <div class="space-y-6 text-slate-300 text-lg leading-relaxed font-light">
                            <p>
                                Welcome to The Tribe Called Roots. Our journey is defined by a simple yet non-negotiable mission: to reach into the most underserved rural communities and plant the seeds of self-sufficiency and dignity.
                            </p>
                            <p>
                                Our roadmap for **2026** is anchored in a landmark commitment to educational equity. We are prioritizing the **CBT transition mandate**, ensuring that through our strategic partnership with **Openclax**, every rural student in Edo State has the digital tools to excel in national examinations.
                            </p>
                            <p>
                                Beyond education, we are scaling our health interventions and business grant programs to provide a holistic foundation for growth. I believe that geography should never determine destiny. Join us as we build a world where progress is inclusive, and every community is illuminated through knowledge and opportunity.
                            </p>
                        </div>
                        <div class="mt-12">
                            <p class="font-heading font-bold text-xl italic text-emerald-400">— Empowering the roots, growing the future.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service Pillar Section -->
        <section class="py-24 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 text-left">
                <div class="text-center mb-20">
                    <h2 class="text-4xl font-extrabold dark:text-white font-heading tracking-tight">Our Core Pillars of Impact</h2>
                    <p class="text-slate-500 mt-4">Structured support for sustainable communal growth.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Pillar 1: Education -->
                    <div class="bg-white dark:bg-slate-900 p-10 border border-slate-100 dark:border-slate-800 shadow-sm stat-card">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-8">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13" /></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 dark:text-white font-heading">1. Education & Digital Literacy</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-medium mb-8">Partnering with <span class="text-emerald-500 font-bold">Openclax</span> to bridge the digital divide.</p>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 text-emerald-500 font-bold">✔</div>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><strong>Free Digital Access:</strong> Openclax platform for SSCE prep.</p>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 text-emerald-500 font-bold">✔</div>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><strong>CBT Readiness:</strong> Skills for modern testing standards.</p>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 text-emerald-500 font-bold">✔</div>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><strong>Resource Distribution:</strong> Essential study materials.</p>
                            </li>
                        </ul>
                    </div>

                    <!-- Pillar 2: Health -->
                    <div class="bg-white dark:bg-slate-900 p-10 border border-slate-100 dark:border-slate-800 shadow-sm stat-card">
                        <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center mb-8">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 dark:text-white font-heading">2. Holistic Health & Wellbeing</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-medium mb-8">Ensuring a sound mind and healthy body.</p>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 text-rose-500 font-bold">✔</div>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><strong>Counseling Services:</strong> Mental health support and guidance.</p>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 text-rose-500 font-bold">✔</div>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><strong>Free Medical Eye Treatment:</strong> Exams and treatments for the needy.</p>
                            </li>
                        </ul>
                    </div>

                    <!-- Pillar 3: Economic Empowerment -->
                    <div class="bg-white dark:bg-slate-900 p-10 border border-slate-100 dark:border-slate-800 shadow-sm stat-card">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center mb-8">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" /></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 dark:text-white font-heading">3. Empowerment & Social Welfare</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-medium mb-8">Financial foundations for sustainable growth.</p>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 text-amber-500 font-bold">✔</div>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><strong>SME Grants:</strong> For local economic development and growth.</p>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 text-amber-500 font-bold">✔</div>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><strong>Vulnerable Outreach:</strong> Targeted support for orphanages and poverty relief.</p>
                            </li>
                        </ul>
                    </div>

                    <!-- Pillar 4: Advocacy -->
                    <div class="bg-white dark:bg-slate-900 p-10 border border-slate-100 dark:border-slate-800 shadow-sm stat-card">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-8">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857" /></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 dark:text-white font-heading">4. Community Engagement & Advocacy</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-medium mb-8">Amplifying impact through collective action.</p>
                        <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                            <li>We actively engage passionate volunteers through structured programs and lead advocacy efforts to educate the public on critical social issues.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision Section -->
        <section class="py-32 bg-white dark:bg-slate-950">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <div class="inline-block p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-full mb-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold mb-10 dark:text-white font-heading">Our Vision</h2>
                <p class="text-2xl md:text-4xl font-light italic text-slate-700 dark:text-slate-300 leading-relaxed tracking-tight">
                    "To create a world where geography does not determine a person's access to opportunity, education, or basic human dignity."
                </p>
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
                            <img src="logo.jpg" alt="TTCRHF Logo" class="w-full h-full object-cover">
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white uppercase font-heading">TTCRHF</span>
                    </div>
                </div>
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase text-xs font-heading">Contacts</h4>
                    <p class="text-sm font-light leading-relaxed">📍 Benin City, Edo State.<br>📞 +234 903 716 2950</p>
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
