<?php
$file = 'index.php';
$content = file_get_contents($file);

// Find the grid container
preg_match('/<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">(.*?)<\/div>\s*<\/div>\s*<\/section>/s', $content, $matches);
if (!$matches) {
    die("Could not find grid container.");
}

$grid_content = $matches[1];

// We need to match each stat-card
preg_match_all('/<!-- (.*?) \((.*?)\) -->\s*<div class="stat-card.*?>\s*(<div class=".*?bg-([a-z]+)-100.*?>.*?<\/div>)\s*<h3.*?>(.*?)<\/h3>\s*<p.*?>(.*?)<\/p>\s*<\/div>/s', $grid_content, $cards, PREG_SET_ORDER);

$new_grid_content = "";
foreach ($cards as $card) {
    $comment = $card[1];
    $color_name = $card[2]; // e.g., Cyan
    $icon_div = trim($card[3]);
    $theme_color = $card[4]; // e.g., cyan
    $title = trim($card[5]);
    $desc = trim($card[6]);

    // Construct flip card
    $flip = "
                        <!-- $comment ($color_name) -->
                        <div class=\"group h-[22rem] [perspective:1000px]\">
                            <div class=\"relative h-full w-full rounded-3xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] group-hover:-translate-y-2 shadow-sm group-hover:shadow-2xl group-hover:shadow-{$theme_color}-500/20\">
                                <!-- Front Face -->
                                <div class=\"absolute inset-0 p-10 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 [backface-visibility:hidden] flex flex-col\">
                                    {$icon_div}
                                    <h3 class=\"text-2xl font-bold mb-4 dark:text-white text-slate-800 group-hover:text-{$theme_color}-600 transition-colors\">{$title}</h3>
                                    <p class=\"text-slate-500 dark:text-slate-400 leading-relaxed\">{$desc}</p>
                                </div>
                                <!-- Back Face -->
                                <div class=\"absolute inset-0 bg-gradient-to-br from-{$theme_color}-600 to-{$theme_color}-800 rounded-3xl [transform:rotateY(180deg)] [backface-visibility:hidden] flex flex-col items-center justify-center p-8 border border-{$theme_color}-500 shadow-inner\">
                                    <div class=\"bg-white/10 w-32 h-32 rounded-full flex items-center justify-center backdrop-blur-sm shadow-xl p-4\">
                                        <img src=\"<?= htmlspecialchars(\$site_logo) ?>\" class=\"w-full h-full object-contain mix-blend-multiply filter brightness-0 invert opacity-90 drop-shadow-lg\" alt=\"TTCRHF Logo\">
                                    </div>
                                    <h3 class=\"text-white/90 font-bold text-center mt-6 tracking-widest uppercase text-sm\">{$title}</h3>
                                </div>
                            </div>
                        </div>";
    $new_grid_content .= $flip;
}

$new_content = str_replace($grid_content, $new_grid_content . "\n                    ", $content);
file_put_contents($file, $new_content);
echo "Replaced gracefully!\n";
?>
