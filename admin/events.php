<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

$message = '';
$upload_dir = '../uploads/events/';

// Ensure upload directory exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle Add Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $event_date = $_POST['event_date'] ?? '';
    $location = $_POST['location'] ?? '';
    $status = $_POST['status'] ?? 'upcoming';
    $theme_color = $_POST['theme_color'] ?? 'maroon';
    
    // Handle File Upload
    $flyer_path = '';
    if (isset($_FILES['flyer']) && $_FILES['flyer']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['flyer']['tmp_name'];
        $name = basename($_FILES['flyer']['name']);
        // Sanitize filename
        $name = preg_replace("/[^a-zA-Z0-9.\-_]/", "", $name);
        $new_name = time() . '_' . $name;
        $target_file = $upload_dir . $new_name;
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($imageFileType, $allowed)) {
            if (move_uploaded_file($tmp_name, $target_file)) {
                $flyer_path = 'uploads/events/' . $new_name;
            } else {
                $message = "Error uploading flyer.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, GIF, WEBP allowed.";
        }
    }
    
    if (empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO events (title, description, event_date, location, flyer_path, status, theme_color) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $event_date, $location, $flyer_path, $status, $theme_color])) {
            $message = "Event added successfully!";
        } else {
            $message = "Database error.";
        }
    }
}

// Handle Delete Event
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT flyer_path FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();
    
    if ($event) {
        if (!empty($event['flyer_path']) && file_exists('../' . $event['flyer_path'])) {
            unlink('../' . $event['flyer_path']);
        }
        $pdo->prepare("DELETE FROM events WHERE id = ?")->execute([$id]);
        $message = "Event deleted successfully!";
    }
}

// Fetch events
$events = $pdo->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll();
?>
<?php
$page_title = 'Manage Events - TTCRHF Admin';
require_once 'includes/header.php';
?>
    <main class="flex-1 p-8 ml-0 md:ml-64 relative min-h-screen">
        <header class="flex justify-between items-center mb-10 animate-fade-up">
            <h1 class="text-3xl font-black font-heading text-slate-800 tracking-tight">Manage Events</h1>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 font-medium animate-fade-up"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Add Event Form -->
        <div class="glass-panel p-8 rounded-2xl mb-10 animate-fade-up stagger-1">
            <h2 class="text-xl font-bold mb-6 font-heading">Add New Event</h2>
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="add">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Date</label>
                        <input type="date" name="event_date" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Location</label>
                        <input type="text" name="location" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                            <option value="upcoming">Upcoming</option>
                            <option value="past">Past</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Theme Color</label>
                        <select name="theme_color" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                            <option value="maroon">Maroon (Brand Default)</option>
                            <option value="amber">Amber / Yellow</option>
                            <option value="emerald">Emerald / Green</option>
                            <option value="blue">Blue</option>
                            <option value="purple">Purple</option>
                            <option value="slate">Slate / Dark</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none"></textarea>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Flyer Image</label>
                    <input type="file" name="flyer" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-maroon-600 outline-none">
                </div>
                <div class="pt-4 flex gap-4">
                    <button type="submit" class="bg-maroon-600 text-white font-bold py-2 px-6 rounded-xl hover:bg-maroon-700 transition">Save Event</button>
                    <button type="reset" class="bg-slate-200 text-slate-700 font-bold py-2 px-6 rounded-xl hover:bg-slate-300 transition">Reset Form</button>
                </div>
            </form>
        </div>

        <!-- Events List -->
        <div class="glass-panel rounded-2xl overflow-hidden animate-fade-up stagger-2">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/50 border-b border-slate-200/50 flex flex-col md:table-row font-heading text-sm text-slate-500 uppercase tracking-widest">
                        <th class="p-4 font-bold">Title</th>
                        <th class="p-4 font-bold">Date</th>
                        <th class="p-4 font-bold">Location</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($events)): ?>
                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No events found</td></tr>
                    <?php else: ?>
                        <?php foreach ($events as $e): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="p-4 font-medium"><?= htmlspecialchars($e['title']) ?></td>
                            <td class="p-4 text-sm text-slate-600"><?= htmlspecialchars($e['event_date']) ?></td>
                            <td class="p-4 text-sm text-slate-600"><?= htmlspecialchars($e['location']) ?></td>
                            <td class="p-4 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-bold <?= $e['status'] == 'upcoming' ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-700' ?>">
                                    <?= ucfirst($e['status']) ?>
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="?delete=<?= $e['id'] ?>" onclick="return confirm('Are you sure?')" class="text-red-500 hover:text-red-700 text-sm font-bold">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
