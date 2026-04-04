<?php
$c = file_get_contents('index.php');
$c = str_replace('<?= htmlspecialchars($site_logo) ?>', '<?= htmlspecialchars($card_logo) ?>', $c);
$c = str_replace('mix-blend-multiply filter brightness-0 invert opacity-90 drop-shadow-lg', 'filter drop-shadow-lg', $c);
file_put_contents('index.php', $c);
echo 'Done';
?>
