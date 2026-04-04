<?php
$page_title = $page_title ?? 'Admin Dashboard - TTCRHF';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    colors: { maroon: { 600: '#a01c1c', 700: '#7B1818' } },
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Plus Jakarta Sans', 'sans-serif'] }
                } 
            }
        }
    </script>
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); filter: blur(4px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
        .animate-fade-up {
            opacity: 0;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .stagger-1 { animation-delay: 100ms; }
        .stagger-2 { animation-delay: 200ms; }
        .stagger-3 { animation-delay: 300ms; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 24px -4px rgba(0, 0, 0, 0.03);
        }
        
        input, select, textarea {
            transition: all 0.3s ease;
        }
        input:focus, select:focus, textarea:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(160, 28, 28, 0.1), 0 8px 10px -6px rgba(160, 28, 28, 0.1);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-900 flex selection:bg-maroon-100 selection:text-maroon-900 overflow-x-hidden">
<?php require_once __DIR__ . '/sidebar.php'; ?>
