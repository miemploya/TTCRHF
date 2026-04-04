<?php
$c = file_get_contents('index.php');

$colors = ['cyan', 'teal', 'orange', 'rose', 'amber', 'pink', 'maroon'];

foreach ($colors as $color) {
    $c = preg_replace(
        '/bg-white dark:bg-slate-900 (rounded-3xl.*? flex flex-col\">\s*<div class=\"w-14 h-14 bg-' . $color . '-100)/s',
        'bg-' . $color . '-50 dark:bg-slate-900 $1',
        $c
    );
}

file_put_contents('index.php', $c);
echo "Replaced gracefully!\n";
?>
