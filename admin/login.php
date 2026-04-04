<?php
session_start();
require_once '../includes/db_connect.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = 'Invalid credentials';
        }
    } else {
        $error = 'Please fill all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - TTCRHF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: { colors: { maroon: { 600: '#a01c1c', 700: '#7B1818' } } }
            }
        }
    </script>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-3xl shadow-xl max-w-sm w-full">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold font-[Plus Jakarta Sans]">Admin Portal</h1>
            <p class="text-slate-500 text-sm mt-2">Sign in to manage TTCRHF</p>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-6 font-medium text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none transition">
            </div>
            <button type="submit" class="w-full bg-maroon-600 text-white font-bold py-3 rounded-xl hover:bg-maroon-700 transition">Sign In</button>
        </form>
    </div>
</body>
</html>
