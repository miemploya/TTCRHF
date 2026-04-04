<?php
$c = file_get_contents('index.php');
$c = str_replace('We appreciate your support for Edo State.', 'We appreciate your support.', $c);
file_put_contents('index.php', $c);
echo 'Removed region';
?>
