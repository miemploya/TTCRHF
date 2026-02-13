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
                },
            },
        }
    </script>
    <style>
        :root {
            --brand-emerald: #059669;
            --brand-dark: #064e3b;
        }
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        h1, h2, h3, h4, .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1509059852496-f3822ae057bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'); 
            background-size: cover; background-position: center; 
        }
        .hidden { display: none; }
        .active-nav { color: var(--brand-emerald) !important; border-bottom: 2px solid var(--brand-emerald); }
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
                        <img src="ttcrhf_logo.png?v=2" alt="TTCRHF Logo" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xl tracking-tight text-slate-900 dark:text-white leading-none">TTCRHF</span>
                        <span class="text-[9px] font-bold text-emerald-600 dark:text-emerald-500 tracking-[0.1em] uppercase">The Tribe Called Roots</span>
                    </div>
                </div>
                
                <div class="hidden md:flex space-x-8 font-semibold text-slate-600 dark:text-slate-400 text-sm items-center">
                    <a href="index.php" class="nav-link hover:text-emerald-600 transition-all py-2">Home</a>
                    <a href="about.php" class="nav-link hover:text-emerald-600 transition-all py-2">About Us</a>
                    <a href="events.php" class="nav-link hover:text-emerald-600 transition-all py-2">Events</a>
                    <a href="projects.php" class="nav-link hover:text-emerald-600 transition-all py-2">Projects</a>
                    <a href="gallery.php" class="nav-link hover:text-emerald-600 transition-all py-2">Gallery</a>
                    
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-emerald-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                        <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>
                </div>

                <div class="flex items-center gap-4">
                    <button onclick="navigateTo('donate')" class="bg-emerald-600 text-white px-7 py-3 rounded-full font-bold text-sm hover:bg-emerald-700 transition transform hover:scale-105 shadow-xl shadow-emerald-100 dark:shadow-none">Donate Now</button>
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
            <button onclick="toggleTheme()" class="w-full text-left font-bold text-emerald-600 text-lg py-2 border-t border-slate-100 dark:border-slate-800">Toggle Theme</button>
        </div>
    </nav>

    <!-- Content Sections -->
    <main id="main-content" class="pt-24">
        
        <!-- HOME PAGE -->
        <div id="page-home" class="page-section">
            <!-- Hero -->
            <section class="hero-gradient min-h-[85vh] flex items-center relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center text-white relative z-10">
                    <span class="inline-block bg-emerald-500/20 backdrop-blur-md border border-emerald-400/30 text-emerald-300 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-8">Serving Edo State & Beyond</span>
                    <h1 class="text-5xl md:text-8xl font-extrabold mb-8 leading-[1.1] tracking-tight">The Tribe Called <br><span class="text-emerald-400">Roots Foundation.</span></h1>
                    <p class="text-lg md:text-2xl mb-12 max-w-3xl mx-auto text-slate-200 font-light leading-relaxed">Empowering the less privileged through international standard infrastructure, small business grants, and digital education excellence.</p>
                    <div class="flex flex-col sm:flex-row gap-5 justify-center">
                        <button onclick="navigateTo('projects')" class="bg-emerald-600 text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-emerald-700 transition shadow-2xl shadow-emerald-900/40">Our Interventions</button>
                    </div>
                </div>
            </section>

            <!-- Video Introduction Section -->
            <section class="py-24 bg-white dark:bg-slate-950">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-5xl font-bold mb-4 text-slate-900 dark:text-white">Our Story in Motion</h2>
                        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Watch how we are transforming rural landscapes through the Tribe Called Roots mission.</p>
                    </div>
                    <div class="video-container shadow-2xl dark:shadow-emerald-900/20">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/W4tmxw1mORI" title="TTCRHF Intro Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </section>

            <!-- Comprehensive Pillar Grid -->
            <section class="py-24 bg-slate-50 dark:bg-slate-900/50">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8 text-left">
                        <div class="max-w-2xl">
                            <span class="font-extrabold tracking-widest uppercase text-lg md:text-xl bg-gradient-to-r from-emerald-600 to-teal-400 bg-clip-text text-transparent block mb-4">Core Focus</span>
                            <h2 class="text-4xl md:text-5xl font-bold mt-4 text-slate-900 dark:text-white leading-tight">Five Pillars of Rural <br>Transformation.</h2>
                        </div>
                        <button onclick="navigateTo('projects')" class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-2 hover:gap-4 transition-all">View Project Details &rarr;</button>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
                        <!-- Community Health Initiatives (Cyan) -->
                        <div class="stat-card group p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-cyan-500/50 hover:shadow-2xl hover:shadow-cyan-500/10 hover:-translate-y-2 transition-all duration-300">
                            <div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-cyan-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">Community Health</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Promoting wellness through medical outreach and health education initiatives.</p>
                        </div>
                        <!-- Counseling Services (Teal) -->
                        <div class="stat-card group p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-teal-500/50 hover:shadow-2xl hover:shadow-teal-500/10 hover:-translate-y-2 transition-all duration-300">
                            <div class="w-14 h-14 bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">Counseling Services</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Providing psychological support and professional guidance for emotional well-being.</p>
                        </div>
                        <!-- Volunteer Programs (Orange) -->
                        <div class="stat-card group p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-orange-500/50 hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-300">
                            <div class="w-14 h-14 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-orange-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">Volunteer Programs</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Mobilizing community members to serve, support, and lift up their neighbors.</p>
                        </div>
                        <!-- Awareness Campaigns (Rose) -->
                        <div class="stat-card group p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-rose-500/50 hover:shadow-2xl hover:shadow-rose-500/10 hover:-translate-y-2 transition-all duration-300">
                            <div class="w-14 h-14 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.68c.406.406.954.636 1.528.636h3.18a3.25 3.25 0 003.25-3.25v-1.12c0-1.794-1.456-3.25-3.25-3.25h-3.18a2.16 2.16 0 00-1.528.636l-3.327 3.328a1.5 1.5 0 000 2.122l3.327 3.328z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 dark:text-white group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">Awareness Campaigns</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Educating the public on critical social, health, and developmental issues.</p>
                        </div>
                        <!-- Infrastructure (Amber) -->
                        <div class="stat-card group p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-amber-500/50 hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-2 transition-all duration-300">
                            <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">Infrastructure</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Providing solar-powered boreholes and sustainable community lighting for rural Edo safe-zones.</p>
                        </div>
                        <!-- Orphanage Support (Pink) -->
                        <div class="stat-card group p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-pink-500/50 hover:shadow-2xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300">
                            <div class="w-14 h-14 bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-pink-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors">Orphanage Support</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Comprehensive welfare reaches including structural aid, nutritional supply, and healthcare.</p>
                        </div>
                        <!-- Empowerment Grants (Emerald) -->
                        <div class="stat-card group p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-emerald-500/50 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-300">
                            <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Empowerment Grants</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">Non-repayable grants to help petty traders and SMEs thrive in underserved rural markets.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STRATEGIC PARTNERSHIP SECTION -->
            <section class="py-24 bg-white dark:bg-slate-950">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-16 items-center">
                        <!-- Logos Visual -->
                        <div class="relative flex justify-center items-center">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-100 to-blue-100 dark:from-emerald-900/20 dark:to-blue-900/20 blur-3xl rounded-full opacity-50"></div>
                            <div class="relative z-10 flex items-center gap-8 md:gap-12 animate-float">
                                <!-- TTCRHF Logo -->
                                <div class="w-32 h-32 md:w-40 md:h-40 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl flex items-center justify-center p-2 border-4 border-emerald-500/20">
                                    <img src="ttcrhf_logo.png?v=2" class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal" alt="TTCRHF">
                                </div>
                                <!-- X Icon -->
                                <div class="text-slate-300 dark:text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </div>
                                <!-- Openclax Logo -->
                                <div class="w-32 h-32 md:w-40 md:h-40 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl flex items-center justify-center p-2 border-4 border-blue-500/20">
                                    <img src="openclax_logo.png" class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal" alt="Openclax">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div>
                            <span class="text-blue-600 dark:text-blue-400 font-bold tracking-widest uppercase text-sm mb-4 block">Strategic Partnership</span>
                            <h2 class="text-3xl md:text-5xl font-bold mb-6 text-slate-900 dark:text-white font-heading">Empowering Education with <span class="text-blue-600">Openclax</span></h2>
                            <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed mb-8">
                                We are proud to announce our strategic alliance with <strong>Openclax</strong>, a premier digital learning and assessment platform. Together, we are launching a nationwide initiative to provide <strong>free access to quality education</strong> for public schools across Nigeria.
                            </p>
                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start gap-3">
                                    <div class="mt-1 w-6 h-6 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white">Universal Access</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Removing financial barriers to world-class learning resources.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-1 w-6 h-6 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white">CBT Excellence</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Preparing students for the future with computer-based testing tools.</p>
                                    </div>
                                </li>
                            </ul>
                            <button onclick="navigateTo('contact')" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold hover:gap-4 transition-all group">
                                Learn about the initiative <span class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-full group-hover:bg-blue-600 group-hover:text-white transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg></span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Orphanage Visit Photo Grid -->
            <section class="py-24 bg-white dark:bg-slate-950">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4 dark:text-white">Orphanage Outreach Highlights</h2>
                        <p class="text-slate-500 dark:text-slate-400">Bringing smiles and sustainable support to the most vulnerable members of our Tribe.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="rounded-3xl overflow-hidden shadow-xl dark:shadow-emerald-900/10 transform hover:scale-[1.02] transition-transform">
                            <img src="orphanage1.jpg" class="w-full h-80 object-cover" alt="Orphanage visit 1">
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-xl dark:shadow-emerald-900/10 transform hover:scale-[1.02] transition-transform">
                            <img src="orphanage2.jpg" class="w-full h-80 object-cover" alt="Orphanage visit 2">
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-xl dark:shadow-emerald-900/10 transform hover:scale-[1.02] transition-transform">
                            <img src="orphanage3.jpg" class="w-full h-80 object-cover" alt="Orphanage visit 3">
                        </div>
                    </div>
                </div>
            </section>

            <!-- CONTACT PAGE -->
            <div id="page-contact" class="page-section hidden py-24 px-4 bg-slate-50 dark:bg-slate-900 text-center">
                <div class="max-w-4xl mx-auto">
                     <span class="text-emerald-600 dark:text-emerald-400 font-bold tracking-widest uppercase text-sm mb-4 block">Get In Touch</span>
                    <h1 class="text-5xl font-bold mb-12 dark:text-white font-heading">Partner With Us</h1>
                    <div class="bg-white dark:bg-slate-800 rounded-[3rem] shadow-xl p-8 md:p-12 text-left">
                        <div class="grid md:grid-cols-2 gap-12">
                            <div>
                                <h3 class="text-2xl font-bold mb-6 dark:text-white">Send a Message</h3>
                                <form class="space-y-6" onsubmit="event.preventDefault(); showModal('Message Sent', 'Thank you for reaching out. We will get back to you shortly.');">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Name</label>
                                        <input type="text" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 outline-none transition" placeholder="Your Name">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email</label>
                                        <input type="email" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 outline-none transition" placeholder="email@example.com">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Message</label>
                                        <textarea rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 outline-none transition" placeholder="How can we work together?"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold hover:bg-emerald-700 transition transform hover:-translate-y-1">Send Message</button>
                                </form>
                            </div>
                            <div class="flex flex-col justify-center space-y-8">
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-8 rounded-3xl border border-emerald-100 dark:border-emerald-800/30">
                                    <h4 class="font-bold text-emerald-900 dark:text-emerald-100 mb-4 text-xl">Headquarters</h4>
                                    <p class="text-emerald-800 dark:text-emerald-200 leading-relaxed">
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
            <section class="py-24 bg-emerald-950 text-white">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <h2 class="text-2xl font-bold mb-12 tracking-widest uppercase opacity-60 font-heading">Global Strategic Partners</h2>
                    <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-80 grayscale hover:grayscale-0 transition-all">
                        <span class="text-3xl font-heading font-bold italic">Ministry of Ed.</span>
                        <span class="text-3xl font-heading font-bold">SolarGlobal</span>
                        <span class="text-3xl font-heading font-bold">EdoEmpowers</span>
                        <span class="text-3xl font-heading font-bold">Tech4Rural</span>
                    </div>
                    <div class="mt-16 bg-emerald-900/30 p-12 rounded-[3rem] border border-emerald-800">
                        <h3 class="text-3xl font-bold mb-6 font-heading">Become a Partner</h3>
                        <p class="text-emerald-100 mb-8 max-w-xl mx-auto">Join the Tribe called Roots and help us scale our impact across more rural communities.</p>
                        <button class="bg-white text-emerald-950 px-8 py-3 rounded-full font-bold hover:bg-emerald-50 transition">Get in Touch</button>
                    </div>
                </div>
            </section>
        </div>

        <!-- ABOUT PAGE -->
        <div id="page-about" class="page-section hidden py-24 px-4 max-w-7xl mx-auto">
            <!-- Hero Intro -->
            <div class="text-center mb-20 max-w-4xl mx-auto">
                <span class="text-emerald-600 dark:text-emerald-400 font-bold tracking-widest uppercase text-sm mb-4 block">Who We Are</span>
                <h1 class="text-4xl md:text-5xl font-bold mb-8 dark:text-white font-heading leading-tight">The Tribe Called Roots <br>Humanitarian Foundation (TTCRHF)</h1>
                <div class="relative">
                    <div class="absolute inset-0 bg-emerald-100 dark:bg-emerald-900/20 transform -skew-y-1 rounded-3xl -z-10"></div>
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
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Free Digital Access:</strong> Openclax platform for SSCE prep.</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>CBT Readiness:</strong> Skills for modern testing.</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Resource Distribution:</strong> Essential study materials.</span></li>
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
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Counseling Services:</strong> Mental health support.</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Free Medical Eye Treatment:</strong> Exams and treatments for the needy.</span></li>
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
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Clean Water:</strong> Industrial boreholes.</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Renewable Energy:</strong> Solar lighting for security.</span></li>
                        </ul>
                    </div>

                    <!-- 4. Economic Empowerment (Emerald) -->
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-lg border border-slate-100 dark:border-slate-800 hover:border-emerald-500/50 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">4. Economic Empowerment & Social Welfare</h3>
                        <p class="text-sm text-slate-500 mb-4">Financial foundations for growth.</p>
                        <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>SME Grants:</strong> For local economic growth.</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Vulnerable Outreach:</strong> Support for orphanages and extreme poverty.</span></li>
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
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Volunteer Programs:</strong> Structured community service.</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">✔</span> <span><strong>Awareness Campaigns:</strong> Public education on rights and health.</span></li>
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
        </div>

        <!-- DONATE PAGE -->
        <div id="page-donate" class="page-section hidden">
            <!-- Hero with Gradient -->
            <div class="bg-gradient-to-br from-emerald-900 to-slate-900 text-white py-20 px-6 relative overflow-hidden">
                 <div class="absolute top-0 right-0 w-1/2 h-full bg-emerald-500/10 blur-[100px] rounded-full"></div>
                 <div class="max-w-4xl mx-auto text-center relative z-10">
                     <span class="inline-block bg-white/10 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6">Seeds of Change</span>
                     <h1 class="text-4xl md:text-6xl font-bold font-heading mb-6">Invest in Rural Futures.</h1>
                     <p class="text-xl text-emerald-100 max-w-2xl mx-auto leading-relaxed">Your contribution directly funds solar boreholes, orphanage nutrition plans, and digital exam scholarships. 100% transparency.</p>
                 </div>
            </div>

            <div class="max-w-5xl mx-auto px-4 -mt-12 relative z-20 pb-24">
                <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-slate-100 dark:border-slate-800 p-8 md:p-12">
                    
                    <!-- Impact Tiers (visual reference) -->
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-8 text-center">Choose Your Impact</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                        <button type="button" onclick="selectImpactTier('$10 - Edu-Kit')" class="impact-tier bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 active:scale-95 transition-all p-6 rounded-2xl group text-center">
                            <span class="block text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mb-2 group-hover:scale-110 transition-transform">$10</span>
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">Edu-Kit (Stationery)</span>
                        </button>
                        <button type="button" onclick="selectImpactTier('$25 - CBT Exam Fee')" class="impact-tier bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 active:scale-95 transition-all p-6 rounded-2xl group text-center">
                            <span class="block text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mb-2 group-hover:scale-110 transition-transform">$25</span>
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">CBT Exam Fee</span>
                        </button>
                        <button type="button" onclick="selectImpactTier('$50 - Orphanage Meal Plan')" class="impact-tier bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 active:scale-95 transition-all p-6 rounded-2xl group text-center">
                            <span class="block text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mb-2 group-hover:scale-110 transition-transform">$50</span>
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">Orphanage Meal Plan</span>
                        </button>
                        <button type="button" onclick="selectImpactTier('$100 - SME Micro-Grant')" class="impact-tier bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 active:scale-95 transition-all p-6 rounded-2xl group text-center">
                            <span class="block text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mb-2 group-hover:scale-110 transition-transform">$100</span>
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">SME Micro-Grant</span>
                        </button>
                    </div>

                    <div class="h-px bg-slate-100 dark:bg-slate-800 my-10"></div>

                    <!-- Donation Inquiry Form -->
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2 text-center font-heading">Donation Inquiry Form</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-center mb-10 text-sm">Fill in your details below and our team will contact you with instructions on how to complete your donation.</p>

                    <form id="donate-form" class="space-y-6 max-w-2xl mx-auto">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="donor_name" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition text-slate-900 dark:text-white" placeholder="Your full name">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="donor_email" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition text-slate-900 dark:text-white" placeholder="you@example.com">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="donor_phone" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition text-slate-900 dark:text-white" placeholder="+234 800 000 0000">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Location (City, Country) <span class="text-red-500">*</span></label>
                                <input type="text" name="donor_location" required class="w-full px-5 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition text-slate-900 dark:text-white" placeholder="Benin City, Nigeria">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Amount You Wish to Donate <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-xl font-bold text-slate-400">$</span>
                                <input type="text" name="donor_amount" id="donate-amount-input" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3.5 pl-12 pr-6 text-xl font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" placeholder="Enter amount or select a tier above">
                            </div>
                        </div>

                        <!-- Consent Checkbox -->
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800/30">
                            <label class="flex items-start gap-4 cursor-pointer">
                                <input type="checkbox" name="donor_consent" required class="mt-1 w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                                <span class="text-sm text-slate-700 dark:text-emerald-200 leading-relaxed">
                                    I agree to allow <strong>The Tribe Called Roots Humanitarian Foundation (TTCRHF)</strong> to contact me via phone call or email to provide instructions on how to complete my donation. <span class="text-red-500">*</span>
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="donate-submit-btn" class="w-full bg-emerald-600 text-white py-5 rounded-full font-bold text-xl hover:bg-emerald-700 transition shadow-xl shadow-emerald-200 dark:shadow-emerald-900/20 transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Submit Donation Inquiry
                        </button>

                        <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-4">Your details will be sent securely to <strong>ttcrhf@mail.com</strong>. Our team will reach out to guide you through the donation process.</p>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <!-- Detailed Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 text-left">
            <div class="grid md:grid-cols-4 gap-16 mb-16">
                <!-- Brand Info -->
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white">
                            <img src="ttcrhf_logo.png?v=2" alt="TTCRHF Logo" class="w-full h-full object-cover">
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white uppercase font-heading">TTCRHF</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-8 font-light">The Tribe Called Roots Humanitarian Foundation is an international NGO dedicated to rural upliftment, infrastructure, and educational equity.</p>
                </div>

                <!-- Contact Details -->
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase tracking-widest text-xs font-heading">Contact Info</h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li class="flex items-start gap-3">📍 2/4, Christ Coming Drive, Ulemo, Benin City, Edo State.</li>
                        <li class="flex items-start gap-3">✉️ ttcrhf@mail.com</li>
                        <li class="flex items-start gap-3">📞 +234 809 200 0080</li>
                    </ul>
                </div>

                <!-- Useful Links -->
                <div class="col-span-1">
                    <h4 class="text-white font-bold text-lg mb-8 uppercase tracking-widest text-xs font-heading">Foundation</h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li><a href="about.php" class="hover:text-emerald-500 transition">Our History</a></li>
                        <li><a href="projects.php" class="hover:text-emerald-500 transition">Water & Solar Projects</a></li>

                        <li><button onclick="navigateTo('donate')" class="hover:text-emerald-500 transition">Partner With Us</button></li>
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
                    <a href="#" class="hover:text-emerald-500">Privacy Policy</a>
                    <a href="#" class="hover:text-emerald-500">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Custom Modal -->
    <div id="modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-md hidden p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-12 max-w-lg w-full shadow-2xl text-center border dark:border-slate-800">
            <h3 id="modal-title" class="text-3xl font-extrabold mb-4 dark:text-white font-heading">Success</h3>
            <p id="modal-text" class="text-slate-600 dark:text-slate-400 mb-10 leading-relaxed font-light"></p>
            <button onclick="closeModal()" class="bg-emerald-600 text-white w-full py-5 rounded-2xl font-bold hover:bg-emerald-700 transition">Continue</button>
        </div>
    </div>

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
                    btn.classList.remove('ring-2', 'ring-emerald-500', 'border-emerald-500');
                });
                event.currentTarget.classList.add('ring-2', 'ring-emerald-500', 'border-emerald-500');
            }
        }

        // Donate form AJAX submission
        document.addEventListener('DOMContentLoaded', function() {
            const donateForm = document.getElementById('donate-form');
            if (donateForm) {
                donateForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = document.getElementById('donate-submit-btn');
                    const originalHTML = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Submitting...';
                    submitBtn.disabled = true;
                    
                    const formData = new FormData(donateForm);
                    // Ensure consent is sent
                    if (!donateForm.querySelector('[name="donor_consent"]').checked) {
                        showModal('Required', 'You must agree to allow TTCRHF to contact you before submitting.');
                        submitBtn.innerHTML = originalHTML;
                        submitBtn.disabled = false;
                        return;
                    }
                    formData.append('donor_consent', 'yes');
                    
                    fetch('donate_handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showModal('Thank You! 🌱', data.message);
                            donateForm.reset();
                            document.querySelectorAll('.impact-tier').forEach(btn => {
                                btn.classList.remove('ring-2', 'ring-emerald-500', 'border-emerald-500');
                            });
                        } else {
                            showModal('Notice', data.message);
                        }
                        submitBtn.innerHTML = originalHTML;
                        submitBtn.disabled = false;
                    })
                    .catch(error => {
                        showModal('Error', 'Something went wrong. Please try again or contact us directly at ttcrhf@mail.com');
                        submitBtn.innerHTML = originalHTML;
                        submitBtn.disabled = false;
                    });
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

        window.onload = () => navigateTo('home');
    </script>
</body>
</html>
