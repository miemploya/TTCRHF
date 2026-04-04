<?php
require_once 'includes/auth.php';
require_once '../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Layout Container ID.");
}
$id = $_GET['id'];

// Handling the Asynchronous Save Sequence
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['html'])) {
    $html = $_POST['html'];
    $css = $_POST['css'] ?? '';
    
    $stmt = $pdo->prepare("UPDATE custom_pages SET html_content = ?, css_content = ? WHERE id = ?");
    $stmt->execute([$html, $css, $id]);
    echo "SYNCED";
    exit;
}

// Spin Up The Canvas Data
$stmt = $pdo->prepare("SELECT * FROM custom_pages WHERE id = ?");
$stmt->execute([$id]);
$page = $stmt->fetch();
if (!$page) {
    die("Design Blueprint offline.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visual Builder Core - <?= htmlspecialchars($page['title']) ?></title>
    
    <!-- GrapesJS Framework -->
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage@1.0.2"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic@1.0.1"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        body, html { margin: 0; padding: 0; height: 100%; overflow: hidden; font-family: 'Inter', sans-serif; background: #0f172a; }
        .gjs-cv-canvas { top: 0; width: 100%; height: 100%; }
        
        /* Master Engine Topbar */
        .builder-topbar {
            height: 64px;
            background: #0f172a;
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
        .builder-container { height: calc(100vh - 64px); background: #f8fafc; }
        
        /* Controls */
        .save-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white; border: none; padding: 10px 28px;
            border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s;
            box-shadow: 0 4px 15px -3px rgba(16, 185, 129, 0.4);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; text-transform: uppercase; tracking-wide: 1px;
        }
        .save-btn:hover { background: linear-gradient(135deg, #059669 0%, #047857 100%); transform: translateY(-1px); }
        .back-btn {
            color: #94a3b8; text-decoration: none; font-size: 13px; margin-right: 24px;
            font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
            transition: color 0.3s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .back-btn:hover { color: #f8fafc; }
        
        .design-tag {
            background: #1e293b; padding: 6px 14px; border-radius: 6px; color: #cbd5e1; font-size: 12px; font-family: monospace; border: 1px solid #334155;
        }
    </style>
</head>
<body>
    <div class="builder-topbar">
        <div style="display: flex; align-items: center;">
            <a href="pages.php" class="back-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> 
                Exit Engine
            </a>
            <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; letter-spacing: 0.5px; display: flex; align-items: center; gap: 12px;">
                <span style="color: white; font-size: 16px;"><?= htmlspecialchars($page['title']) ?></span>
                <span class="design-tag">/page.php?slug=<?= htmlspecialchars($page['slug']) ?></span>
            </div>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="back-btn" style="margin: 0; padding: 10px 18px; border: 1px solid #334155; border-radius: 8px; background: #1e293b; color: #fff;" onclick="openRawEditor()">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                DOM Injection
            </button>
            <button class="save-btn" id="saveBtn" onclick="saveDesign()">Sync & Publish Layout</button>
        </div>
    </div>
    
    <!-- Custom Raw Editor Modal -->
    <div id="rawEditorModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15, 23, 42, 0.9); z-index:99999; flex-direction:column; align-items:center; justify-content:center; backdrop-filter:blur(8px);">
        <div style="background:#1e293b; width:90%; height:85%; border-radius:12px; display:flex; flex-direction:column; overflow:hidden; border:1px solid #334155; box-shadow:0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div style="padding:16px 24px; background:#0f172a; border-bottom:1px solid #334155; display:flex; justify-content:space-between; align-items:center;">
                <h3 style="margin:0; font-family:'Plus Jakarta Sans', sans-serif; color:white; font-size:18px; font-weight:700;">Raw DOM Injection Interface</h3>
                <button onclick="closeRawEditor()" style="background:transparent; border:none; color:#cbd5e1; cursor:pointer; padding:8px; border-radius:6px; transition:all 0.3s;" onmouseover="this.style.background='#1e293b'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1';">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div style="display:flex; flex:1; padding:24px; gap:24px;">
                <div style="flex:1; display:flex; flex-direction:column;">
                    <label style="color:#94a3b8; font-family:'Inter', sans-serif; font-weight:600; text-transform:uppercase; font-size:12px; margin-bottom:8px; letter-spacing:1px;">Core HTML Structure</label>
                    <textarea id="rawHtml" style="flex:1; background:#0f172a; color:#10b981; border:1px solid #334155; border-radius:8px; padding:16px; font-family:monospace; font-size:13px; resize:none; outline:none; box-shadow:inset 0 2px 4px rgba(0,0,0,0.1);"></textarea>
                </div>
                <div style="flex:1; display:flex; flex-direction:column;">
                    <label style="color:#94a3b8; font-family:'Inter', sans-serif; font-weight:600; text-transform:uppercase; font-size:12px; margin-bottom:8px; letter-spacing:1px;">CSS Property Styling</label>
                    <textarea id="rawCss" style="flex:1; background:#0f172a; color:#38bdf8; border:1px solid #334155; border-radius:8px; padding:16px; font-family:monospace; font-size:13px; resize:none; outline:none; box-shadow:inset 0 2px 4px rgba(0,0,0,0.1);"></textarea>
                </div>
            </div>
            <div style="padding:16px 24px; background:#0f172a; border-top:1px solid #334155; display:flex; justify-content:flex-end;">
                <button onclick="injectRawDOM()" class="save-btn">Apply Direct Modification</button>
            </div>
        </div>
    </div>
    
    <div class="builder-container" id="gjs"></div>
    
    <script>
      const editor = grapesjs.init({
        container: '#gjs',
        fromElement: false,
        height: '100%',
        width: 'auto',
        storageManager: false, // Bypassing LocalStorage for Direct MySQL Sync
        plugins: ['gjs-preset-webpage', 'gjs-blocks-basic'],
        pluginsOpts: {
          'gjs-preset-webpage': {
              blocksBasicOpts: { flexGrid: true }
          }
        },
        canvas: {
            styles: [
                'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap',
                'https://cdn.tailwindcss.com'
            ],
        }
      });

      // Hydrate existing DB blueprint into Canvas
      editor.setComponents(`<?= str_replace('`', '\`', $page['html_content'] ?? '') ?>`);
      editor.setStyle(`<?= str_replace('`', '\`', $page['css_content'] ?? '') ?>`);

      // DOM Injection Core Handlers
      function openRawEditor() {
          document.getElementById('rawHtml').value = editor.getHtml();
          document.getElementById('rawCss').value = editor.getCss();
          document.getElementById('rawEditorModal').style.display = 'flex';
      }
      
      function closeRawEditor() {
          document.getElementById('rawEditorModal').style.display = 'none';
      }
      
      function injectRawDOM() {
          const newHtml = document.getElementById('rawHtml').value;
          const newCss = document.getElementById('rawCss').value;
          editor.setComponents(newHtml);
          editor.setStyle(newCss);
          closeRawEditor();
      }

      // Asynchronous Payload Synchronization
      function saveDesign() {
          const btn = document.getElementById('saveBtn');
          btn.textContent = "SYNCHRONIZING...";
          btn.style.opacity = '0.7';
          btn.style.pointerEvents = 'none';
          
          const html = editor.getHtml();
          const css = editor.getCss();
          
          fetch('page_builder.php?id=<?= $id ?>', {
              method: 'POST',
              headers: {'Content-Type': 'application/x-www-form-urlencoded'},
              body: `html=${encodeURIComponent(html)}&css=${encodeURIComponent(css)}`
          }).then(res => res.text()).then(data => {
              btn.textContent = "LIVE SECURED";
              btn.style.background = "linear-gradient(135deg, #059669 0%, #047857 100%)";
              btn.style.opacity = '1';
              
              setTimeout(() => {
                  btn.textContent = "Sync & Publish Layout";
                  btn.style.background = "linear-gradient(135deg, #10b981 0%, #059669 100%)";
                  btn.style.pointerEvents = 'auto';
              }, 2500);
          }).catch(err => {
              btn.textContent = "NETWORK FAILURE";
              btn.style.background = "#e11d48";
              btn.style.opacity = '1';
              btn.style.pointerEvents = 'auto';
          });
      }
    </script>
</body>
</html>
